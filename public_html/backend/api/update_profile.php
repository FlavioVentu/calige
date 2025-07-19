<?php

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla pagina frontend della sign-up
# altrimenti mandiamo un payload json di errore con metodo non valido
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (!empty($_SERVER['HTTP_USER_AGENT']) &&
        strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
        header('Location: ../../frontend/pages/profile.php');
    } else {
        http_response_code(405);
        echo json_encode([
            "status" => "Errore",
            "message" => "Metodo HTTP non supportato"
        ]);
    }
    exit;
}

session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode([
        "status" => "Errore",
        "message" => "Utente non autenticato"
    ]);
    exit;
}

$firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : null;
$lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : null;
$email     = isset($_POST['email']) ? trim($_POST['email']) : null;
$password  = isset($_POST['pass']) ? trim($_POST['pass']) : null;

if (!$firstname || !$lastname || !$email) {
    http_response_code(400);
    echo json_encode([
        "status" => "Errore",
        "message" => "Nome, cognome ed email sono obbligatori"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "status" => "Errore",
        "message" => "Formato email non valido"
    ]);
    exit;
}

if ($password && strlen($password) < 8) {
    http_response_code(400);
    echo json_encode([
        "status" => "Errore",
        "message" => "Password troppo corta"
    ]);
    exit;
}

require_once '../utils/log.php';
ErrorLog::logDB();

require_once '../db/connection.php';

$con;
try {
    $con = Connection::getCon();
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        "status" => "Errore",
        "message" => "Problema di connessione al database"
    ]);
    exit;
}

require_once '../db/queries/userUpdate.php';

try {
    $updater = new UserUpdate($con, $password);
    $updater->execute($_SESSION['username'], $firstname, $lastname, $email);
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        "status" => "Errore",
        "message" => "Errore nel database durante l'aggiornamento"
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "status" => "Errore",
        "message" => $e->getMessage()
    ]);
    exit;
} finally {
    $con->close();
}

echo json_encode([
    "status" => "Successo",
    "message" => "Profilo aggiornato con successo"
]);

