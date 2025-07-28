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

require_once "../utils/functions.php";

# se la richiesta http non è POST
# se viene fatta da un browser rimandiamo alla homepage
# altrimenti mandiamo un payload json di errore con metodo non valido
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Allow: POST");
    if (isBrowserRequest()) {
        header('Location: ../../');
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
$testo = null;
# se non abbiamo il titolo del parco e il punteggio ritorniamo errore
if(!isset($_GET['titolo']) || !isset($_POST['punteggio'])) {
    http_response_code(400);
    echo json_encode([
        "message" => "Mancanza parametri per l'inserimento della recensione"
    ]);
    exit;
}

$titolo = trim($_GET['titolo']);

# controllo variabili
require_once "../utils/const.php";

if(!preg_match(NAME_SURNAME_PATTERN, $titolo)) {
    http_response_code(400);
    echo json_encode([
        "message" => "Titolo fornito non valido"
    ]);
    exit;
}

if (!($punteggio=filter_var($_POST['punteggio'],FILTER_VALIDATE_INT))){
    http_response_code(400);
    echo json_encode([
        "message" => "Punteggio fornito non valido"
    ]);
    exit;
}

if($punteggio < 0 || $punteggio > 5) {
    http_response_code(400);
    echo json_encode([
        "message" => "Valore del punteggio fornito non valido"
    ]);
    exit;
}

$testo = null;
if(isset($_POST['testo'])) {
    $testo = trim($_POST['testo']);
    if(strlen($testo) === 0) {
        $testo = null;
    }
}

#PARTE DB
#setto i log in modo che gli errori del db vadano in un file specifico
ErrorLog::logDB();

$user = $_SESSION['username'];

($testo) ? 
    $query = "INSERT INTO recensione(autore,titolo,punteggio,testo) VALUES ('$user',?,'$punteggio',?)" :
    $query = "INSERT INTO recensione(autore,titolo,punteggio) VALUES ('$user',?,'$punteggio')";

require_once '../db/Connection.php';
require_once '../db/queries/AddReview.php';
try {

    # stabilisco una connessione al DB
    $con = Connection::getCon();

    $new_data = new AddReview($con, $query);
    ($testo) ?
        $new_data->execute('ss', array($titolo,$testo)) :
        $new_data->execute('s',array($titolo));

    # se tutto va bene mando una risposta di successo con le informazioni aggiornate
    echo json_encode([
        "message" => "Recensione inserita!"
    ]);

} catch (mysqli_sql_exception $e) {

    $error = $e->getMessage();
    if(str_contains($error,"Duplicate entry")) {
        http_response_code(400);
        echo json_encode([
            "message" => "Recensione già effettuata"
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