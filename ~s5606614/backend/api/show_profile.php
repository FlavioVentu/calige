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

# se la richiesta http non è formata con il metodo get restituisco un errore
if($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("Allow: GET");
    http_response_code(405);
    echo json_encode([
        "message" => "Richiesta effettuata con un metodo HTTP non supportato (richiesto GET, trovato " . $_SERVER['REQUEST_METHOD'] . ")"
    ]);
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

# PARTE DB

# setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();


# salvo lo username dell'utente
$user = $_SESSION['username'];

# parte di interrogazione al DB
$query ="SELECT nome,cognome, email FROM utente WHERE username = '$user'";

require_once '../db/Connection.php';
require_once '../db/queries/UserShowProfile.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $show = new UserShowProfile($con,$query);
    $info = $show->execute();

    # se tutto va bene mando una risposta di successo con i dati dell'utente
    echo json_encode([
        "message" => "Informazioni disponibili!",
        "data" => [
            "username" => $user,
            "firstname" => htmlentities($info['nome']),
            "lastname" => htmlentities($info['cognome']),
            "email" => $info['email']
        ]
    ]);

} catch (mysqli_sql_exception $e) {

    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        "message" => "Problema interno :("
    ]);
    exit;

}  finally {
    $con->close();
}
