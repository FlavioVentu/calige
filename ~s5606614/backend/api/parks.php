<?php

# setto i log in modo che gli errori vadano in un file specifico
use Couchbase\QueryException;

require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# sfruttiamo la cache lato client (7 giorni) dato che presumibilmente i parchi saranno sempre gli stessi
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

# PARTE DB

# setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();

#parte di interrogazione al DB
$query = "SELECT titolo, immagine FROM parco";

require_once '../db/Connection.php';
require_once '../db/queries/Parks.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $parks = new Parks($con,$query);
    $res = $parks->execute();

    # se tutto va bene mando una risposta di successo con i dati dell'utente
    echo json_encode([
        "message" => "Numero di parchi trovati: " . count($res),
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

    http_response_code(404);
    echo json_encode([
        "message" => $e->getMessage()
    ]);
    exit;

} finally {
    $con->close();
}
