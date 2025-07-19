<?php

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla pagina frontend della show_profile
# altrimenti mandiamo un payload json di errore con metodo non valido
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (!empty($_SERVER['HTTP_USER_AGENT']) &&
           strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
        header('Location: ../../frontend/pages/show_profile.php');
    } else {
        http_response_code(405);
        echo json_encode([
            "status" => "Errore",
            "message" => "Richiesta effettuata con un metodo HTTP non supportato"
        ]);
    }
    exit;
}

session_start();

# se l'utente non è loggato mandiamo errore
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode([
        "status" => "Errore",
        "message" => "Utente non autenticato"
    ]);
    exit;
}

# PARTE DB

# risposta json in caso di errore del server
$internal_error = json_encode([
        "status" => "Errore",
        "message" => "Problema interno :("
        ]);

# setto i log in modo che gli errori del db vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logDB();

# stabilisco una connesione al DB
require_once '../db/Connection.php';
$con;

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

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;

}  finally {
    $con->close();
}

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