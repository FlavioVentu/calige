<?php

# setto i log in modo che gli errori vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# se la richiesta http non è formata con il metodo get restituisco un errore
if($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        "status" => "Errore",
        "message" => "Richiesta effettuata con un metodo HTTP non supportato (richiesto GET, trovato " . $_SERVER['REQUEST_METHOD'] . ")"
    ]);
    exit;
}

session_start();

require_once '../utils/functions.php';

# se non abbiamo salvato nella sessione la variabile username rimandiamo alla pagina di login (utente non ha fatto login)
# Se non è una richiesta da browser, rispondiamo in JSON con errore 401
if (!isset($_SESSION['username'])) {
    if (isBrowserRequest()) {
        header('Location: ../../frontend/pages/login.php');
    } else {
        http_response_code(401);
        echo json_encode([
            "status" => "Errore",
            "message" => "Utente non autenticato"
        ]);
    }
    exit;
}

# PARTE DB

# risposta json in caso di errore del server
$internal_error = json_encode([
        "status" => "Errore",
        "message" => "Problema interno :("
        ]);

# setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();

# stabilisco una connessione al DB
require_once '../db/Connection.php';

try {

    $con = Connection::getCon();

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;

}

# salvo lo username dell'utente
$user = $_SESSION['username'];

# parte di interrogazione al DB
$query ="SELECT nome,cognome,email FROM utente WHERE username = '$user'";

require_once '../db/queries/UserShowProfile.php';
try {

    $reg = new UserShowProfile($con,$query);
    $info = $reg->execute();

    # se tutto va bene mando una risposta di successo con i dati dell'utente
    echo json_encode([
        "status" => "Successo",
        "message" => "Informazioni disponibili!",
        "data" => [
            "username" => $user,
            "firstname" => $info['nome'],
            "lastname" => $info['cognome'],
            "email" => $info['email']
        ]
    ]);

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;

}  finally {
    $con->close();
}
