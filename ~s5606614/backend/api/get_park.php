<?php

# setto i log in modo che gli errori vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# sfruttiamo la cache lato client (7 giorni) dato che presumibilmente i dati del parco saranno sempre gli stessi
header("Cache-Control: public, max-age=604800");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 604800) . " GMT");

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
$query ="SELECT descrizione, immagine, città, latitudine, longitudine FROM parco NATURAL JOIN posizione WHERE titolo = ?";

require_once '../db/Connection.php';
require_once '../db/queries/GetPark.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $park = new GetPark($con,$query);
    $res = $park->execute('s',array($titolo));

    # se tutto va bene mando una risposta di successo (GeoJson)
    echo json_encode([
        "type" => "Feature",
        "properties" => $res[0],
        "geometry" => [
            "type" => "Point",
            "coordinates" => [$res[1]['latitudine'],$res[1]['longitudine']]
        ]

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
