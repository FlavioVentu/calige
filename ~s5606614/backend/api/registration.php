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

require_once '../utils/functions.php';

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla pagina frontend della sign-up
# altrimenti mandiamo un payload json di errore con metodo non valido
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Allow: POST");
    if (isBrowserRequest()) {
        header('Location: ../../frontend/pages/signup.php');
    } else {
        http_response_code(405);
        echo json_encode([
            "message" => "Richiesta effettuata con un metodo HTTP non supportato (richiesto POST, trovato " . $_SERVER['REQUEST_METHOD'] . ")"
        ]);
    }
    exit;
}

session_start();

# se abbiamo salvato nella sessione la variabile username rimandiamo alla home page (utente ha già fatto il login)
# Se non è una richiesta da browser, rispondiamo in JSON con errore 400
if (isset($_SESSION['username'])) {
    if (isBrowserRequest()) {
        header('Location: ../../');
    } else {
        http_response_code(400);
        echo json_encode([
            "message" => "Utente già autenticato"
        ]);
    }
    exit;
}

# se non abbiamo tutti i parametri ritorniamo errore
if(!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email']) || !isset($_POST['pass']) || !isset($_POST['confirm'])) {
    http_response_code(400);
    echo json_encode([
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
require_once "../utils/const.php";

# nome
if(!preg_match(NAME_SURNAME_PATTERN, $firstname)) {
    http_response_code(400);
    echo json_encode([
            "message" => "Nome fornito non valido"
        ]);
    exit;
}

# cognome
if(!preg_match(NAME_SURNAME_PATTERN, $lastname)) {
    http_response_code(400);
    echo json_encode([
            "message" => "Cognome fornito non valido"
        ]);
    exit;
}

# email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
            "message" => "Formato email invalido"
        ]);
    exit;
}

# password
if(!preg_match(PASS_PATTERN, $password)) {
    http_response_code(400);
    echo json_encode([
            "message" => "Formato password invalido"
        ]);
    exit;
}

# confirm
if($password !== $confirm) {
    http_response_code(400);
    echo json_encode([
            "message" => "Le due password non coincidono"
        ]);
    exit;
}

# faccio hash della password
if(!($hash = password_hash($password, PASSWORD_DEFAULT))) {
    http_response_code(500);
    echo json_encode([
        "message" => "Problema interno :("
    ]);
}

# genero uno username casuale per la registrazione
$random_username = randomUsername();
$firstname = ucwords($firstname);
$lastname = ucwords($lastname);

# PARTE DB

# setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();


# parte di interrogazione al DB
$query = "INSERT INTO utente (username, nome, cognome, email, password) VALUES ('$random_username',?,?,?,?)";

require_once '../db/Connection.php';
require_once '../db/queries/UserRegistration.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $reg = new UserRegistration($con,$query);
    $reg->execute('ssss',array($firstname,$lastname,$email,$hash));

    # se tutto va bene mando una risposta di successo includendo lo username generato
    echo json_encode([
        "message" => "Utente registrato!",
        "data" => [
            "username" => $random_username
        ]
    ]);

} catch (mysqli_sql_exception $e) {

    $error = $e->getMessage();
    if(str_contains($error,"Duplicate entry")) {
        http_response_code(400);
        echo json_encode([
            "message" => "Email già in uso"
        ]);
    } else {
        error_log($error);
        http_response_code(500);
        echo json_encode([
            "message" => "Problema interno :("
        ]);
    }
    exit;

} finally {
    $con->close();
}
