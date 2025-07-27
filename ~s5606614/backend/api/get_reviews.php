<?php

# setto i log in modo che gli errori vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# gestione cache in modo che non venga salvato niente lato client
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");  # per compatibilità con HTTP/1.0
header("Expires: 0");

# se la richiesta http non è formata con il metodo get restituisco un errore
if($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("Allow: GET");
    http_response_code(405);
    echo json_encode([
        "message" => "Richiesta effettuata con un metodo HTTP non supportato (richiesto GET, trovato " . $_SERVER['REQUEST_METHOD'] . ")"
    ]);
    exit;
}

# se non abbiamo il titolo del parco ritorniamo errore
if(!isset($_GET['titolo'])) {
    http_response_code(400);
    echo json_encode([
        "message" => "Nessun parco scelto"
    ]);
    exit;
}

$titolo = trim($_GET['titolo']);

# controllo variabili
require_once "../utils/const.php";

if(!preg_match(NAME_SURNAME_PATTERN, $titolo)) {
    http_response_code(400);
    echo json_encode([
        "message" => "Titolo fornito non valido"
    ]);
    exit;
}

# PARTE DB

# setto il log degli errori del DB
ErrorLog::logDB();

# parte di interrogazione al DB
$query ="SELECT autore, punteggio, testo, data FROM recensione WHERE titolo = ? AND testo IS NOT NULL ORDER BY data DESC";

require_once '../db/Connection.php';
require_once '../db/queries/GetReviews.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $reviews = new GetReviews($con,$query);
    $res = $reviews->execute('s',array($titolo));

    # se tutto va bene mando una risposta di successo
    echo json_encode([
        "message" => "Recensioni trovate: " . count($res),
        "data" => $res
    ]);

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        "message" => "Problema interno :("
    ]);
    exit;

} catch (Error $e) {

    http_response_code(400);
    echo json_encode([
        "message" => $e->getMessage()
    ]);
    exit;

} finally {
    $con->close();
}

