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
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Allow: POST");
    if (isBrowserRequest()) {
        header('Location: ../../frontend/pages/update_profile.php');
    } else {
        http_response_code(405);
        echo json_encode([
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
            "message" => "Utente non autenticato"
        ]);
    }
    exit;
}

# se non abbiamo tutti i parametri ritorniamo errore
if(!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email'])) {
    http_response_code(400);
    echo json_encode([
            "message" => "Mancanza di dati necessari per aggiornamento del profilo"
        ]);
    exit;
}

$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);

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

# PARTE DB

# setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();

$firstname = ucwords($firstname);
$lastname = ucwords($lastname);
$user = $_SESSION['username'];
$user_email = $_SESSION['email'];

# se la nuova email è diversa da quella vecchia la aggiorno
($email !== $user_email) ?
    $query = "UPDATE utente SET nome=?, cognome=?, email=? WHERE username='$user'":
    $query = "UPDATE utente SET nome=?, cognome=? WHERE username='$user'";


require_once '../db/Connection.php';
require_once '../db/queries/UserUpdateProfile.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $new_data = new UserUpdateProfile($con, $query);
    ($email !== $user_email) ?
        $new_data->execute('sss',array($firstname,$lastname,$email)) :
        $new_data->execute('ss',array($firstname,$lastname));

    # se tutto va bene mando una risposta di successo con le informazioni aggiornate
    echo json_encode([
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
    echo json_encode([
        "message" => "Problema interno :("
    ]);
    exit;

} finally {
    $con->close();
}
