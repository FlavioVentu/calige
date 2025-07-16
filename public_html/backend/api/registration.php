<?php

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla pagina frontend della sign-up
# altrimenti mandiamo un payload json di errore con metodo non valido
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (!empty($_SERVER['HTTP_USER_AGENT']) &&
           strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
        header('Location: ../../frontend/pages/signup.php');
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

# se abbiamo salvato nella sessione la variabile login rimandiamo alla homepage (utente già loggato)
if(isset($_SESSION['login'])) {
    header('Location: ../../');
    exit;
}

# se non abbiamo tutti i parametri ritorniamo errore
if(!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email']) || !isset($_POST['pass']) || !isset($_POST['confirm'])) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Mancanza di dati necessari per la registrazione"
        ]);
    exit;
}

# salviamo i dati in delle variabili globali eliminando spazi all'inizio e fine
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);
$password = trim($_POST['pass']);
$confirm = trim($_POST['confirm']);


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

# password
if(strlen($password) < 8) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Password non sufficientemente lunga"
        ]);
    exit;
}

# confirm
if($password !== $confirm) {
    http_response_code(400);
    echo json_encode([
            "status" => "Errore",
            "message" => "Le due password non coincidono"
        ]);
    exit;
}

# faccio l'hash della password
$hash = password_hash($password, PASSWORD_BCRYPT);

# genero uno username casuale per la registrazione
require_once '../utils/functions.php';
$random_username = randomUsername();

# PARTE DB

# risposta json in caso di errore del server
$internal_error = json_encode([
        "status" => "Errore",
        "message" => "Problema interno :("
        ]);

# setto i log in modo che gli errori del db vadano in un file specifico
require_once '../utils/log.php';
ErrorLog::logDB();

# stabilisco una connesione al DB
require_once '../db/connection.php';
$con;

try {

    $con = Connection::getCon();

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;

}

$query = "INSERT INTO utente (username, nome, cognome, email, password) VALUE ('$random_username',?,?,?,?)";

require_once '../db/queries/userRegistration.php';
try {

    $reg = new UserRegistration($con,$query);
    $reg->execute('ssss',array($firstname,$lastname,$email,$password));

} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo $internal_error;
    exit;
} finally {
    $con->close();
}

# se tutto va bene mando una risposta di successo
echo json_encode([
            "status" => "Successo",
            "message" => "Utente registrato!",
            "data" => [
                "username" => $random_username
            ]
        ]);