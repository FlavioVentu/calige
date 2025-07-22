<?php

# setto i log in modo che gli errori vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

require_once '../utils/functions.php';

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla pagina frontend della login
# altrimenti mandiamo un payload json di errore con metodo non valido
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (isBrowserRequest()) {
        header('Location: ../../frontend/pages/login.php');
    } else {
        http_response_code(405);
        echo json_encode([
            "status" => "Errore",
            "message" => "Richiesta effettuata con un metodo HTTP non supportato (richiesto POST, trovato " . $_SERVER['REQUEST_METHOD'] . ")"
        ]);
    }
    exit;
}

session_start();


# se abbiamo salvato nella sessione la variabile username rimandiamo alla home page (utente ha già fatto login)
# Se non è una richiesta da browser, rispondiamo in JSON con errore 400
if (isset($_SESSION['username'])) {
    if (isBrowserRequest()) {
        header('Location: ../../');
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "Errore",
            "message" => "Utente già autenticato"
        ]);
    }
    exit;
}

# se non abbiamo tutti i parametri ritorniamo errore
if(!isset($_POST['email']) || !isset($_POST['pass'])) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Mancanza di dati necessari per il login"
        ]);
    exit;
}

# salviamo i dati in delle variabili globali eliminando spazi all'inizio e fine
$email = trim($_POST['email']);
$password = trim($_POST['pass']);

# controllo variabili
# email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Formato email invalido"
        ]);
    exit;
}

# password
if(strlen($password) < 8) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Password non sufficientemente lunga"
        ]);
    exit;
}

# PARTE DB

# risposta json in caso di errore del server
$internal_error = json_encode([
        "status" => "Errore",
        "message" => "Problema interno :("
        ]);

# setto il log degli errori del DB
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

# parte di interrogazione al DB
$query ="SELECT * FROM utente WHERE email = ?";

require_once '../db/queries/UserLogin.php';
try {

    $reg = new UserLogin($con,$query,$password);
    $reg->execute('s',array($email));

    # se tutto va bene mando una risposta di successo
    echo json_encode([
        "status" => "Successo",
        "message" => "Utente autenticato!"
    ]);

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;

} catch (Error $e) {

    http_response_code(400);
    echo json_encode([
        "status" => "Errore",
        "message" => "Credenziali errate"
    ]);
    exit;

} finally {
    $con->close();
}
