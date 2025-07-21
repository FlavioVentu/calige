<?php

# setto i log in modo che gli errori vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

require_once '../utils/functions.php';

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla pagina frontend della sign-up
# altrimenti mandiamo un payload json di errore con metodo non valido
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (isBrowserRequest()) {
        header('Location: ../../frontend/pages/update_profile.php');
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

# se non abbiamo tutti i parametri ritorniamo errore
if(!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email'])) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Mancanza di dati necessari per aggiornamento del profilo"
        ]);
    exit;
}

$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);

# CONTROLLO VARIABILI

# nome
if(strlen($firstname) < 2 || strlen($firstname) > 30) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Nome fornito non valido"
        ]);
    exit;
}

# cognome
if(strlen($lastname) < 2 || strlen($lastname) > 30) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Cognome fornito non valido"
        ]);
    exit;
}

# email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Formato email invalido"
        ]);
    exit;
}

# risposta json in caso di errore del server
$internal_error = json_encode([
        "status" => "Errore",
        "message" => "Problema interno :("
        ]);

# setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();

# stabilisco una connessione al DB
require_once '../db/connection.php';

try {

    $con = Connection::getCon();

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;
}

$user = $_SESSION['username'];

$query = "UPDATE utente SET nome=?, cognome=?, email=? WHERE username='$user'";

require_once '../db/queries/UserUpdateProfile.php';
try {

    $new_data = new UserUpdateProfile($con, $query);
    $new_data->execute('sss',array($firstname,$lastname,$email));

    # se tutto va bene mando una risposta di successo con le informazioni aggiornate
    echo json_encode([
        "status" => "Successo",
        "message" => "Dati aggiornati!",
        "data" => [
            "username" => $user,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email
        ]
    ]);

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;

} finally {
    $con->close();
}
