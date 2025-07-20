<?php

# setto i log in modo che gli errori vadano in un file specifico
require_once '../utils/Log.php';
ErrorLog::logGeneral();

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

# se la richiesta http non è GET restituiamo errore
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

# se non abbiamo salvato nella sessione la variabile username rimandiamo alla pagina di login (utente non loggato)
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

# Logout: svuotiamo e distruggiamo la sessione
$_SESSION = [];
session_destroy();

# Se è una richiesta da browser, facciamo redirect alla login
if (isBrowserRequest()) {
    header('Location: ../../frontend/pages/login.php');
    exit;

# Altrimenti rispondiamo in JSON
} else {
    echo json_encode([
        "status" => "Successo",
        "message" => "Logout effettuato correttamente"
    ]);
}
