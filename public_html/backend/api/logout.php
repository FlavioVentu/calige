<?php

# utilizziamo formato json per la risposta nel body
header("Content-Type: application/json");

session_start();

# Se l'utente non è loggato lo mandiamo al login
if (!isset($_SESSION['username'])) {
    // Se arriva da browser, redirect alla pagina di login
    if (!empty($_SERVER['HTTP_USER_AGENT']) &&
        strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
        header('Location: ../../frontend/pages/login.php');
    } else {
        http_response_code(401);
        echo json_encode([
            "status" => "Errore",
            "message" => "Nessuna sessione attiva"
        ]);
    }
    exit;
}

# Logout: distruggiamo la sessione
session_unset();
session_destroy();

# Se è una richiesta da browser, facciamo redirect alla login
if (!empty($_SERVER['HTTP_USER_AGENT']) &&
    strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
    header('Location: ../../frontend/pages/login.php');
    exit;
}

# Altrimenti rispondiamo in JSON
echo json_encode([
    "status" => "Successo",
    "message" => "Logout effettuato correttamente"
]);
