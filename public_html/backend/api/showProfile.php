<?php
header("Content-Type: application/json");
session_start();


require_once '../db/queries/userProfile.php';

# Controllo autenticazione utente
if (!isset($_SESSION['login'])) {
    http_response_code(401);
    echo json_encode([
        "status" => "Errore",
        "message" => "Utente non autenticato"
    ]);
    exit;
}

$username = $_SESSION['login'];


require_once '../db/connection.php';
try {
    $con = Connection::getCon();
    $profile = new UserProfile($con);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        # Recupera dati profilo
        $userData = $profile->getUserProfile($username);

        if (!$userData) {
            http_response_code(404);
            echo json_encode([
                "status" => "Errore",
                "message" => "Utente non trovato"
            ]);
            exit;
        }

        echo json_encode([
            "status" => "Successo",
            "data" => $userData
        ]);
        exit;

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # Modifica dati profilo

        # Controllo dati ricevuti
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            http_response_code(400);
            echo json_encode([
                "status" => "Errore",
                "message" => "Formato dati non valido"
            ]);
            exit;
        }

        $nome = isset($input['nome']) ? trim($input['nome']) : null;
        $cognome = isset($input['cognome']) ? trim($input['cognome']) : null;
        $email = isset($input['email']) ? trim($input['email']) : null;
        $password = isset($input['password']) ? trim($input['password']) : null;
        $confirm = isset($input['confirm']) ? trim($input['confirm']) : null;

        # Validazioni (semplificate)
        if ($nome !== null && (strlen($nome) < 2 || strlen($nome) > 30)) {
            http_response_code(400);
            echo json_encode(["status"=>"Errore","message"=>"Nome non valido"]);
            exit;
        }

        if ($cognome !== null && (strlen($cognome) < 2 || strlen($cognome) > 30)) {
            http_response_code(400);
            echo json_encode(["status"=>"Errore","message"=>"Cognome non valido"]);
            exit;
        }

        if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["status"=>"Errore","message"=>"Email non valida"]);
            exit;
        }

        if ($password !== null) {
            if (strlen($password) < 8) {
                http_response_code(400);
                echo json_encode(["status"=>"Errore","message"=>"Password troppo corta"]);
                exit;
            }
            if ($password !== $confirm) {
                http_response_code(400);
                echo json_encode(["status"=>"Errore","message"=>"Le password non coincidono"]);
                exit;
            }
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $passwordHash = null;
        }

        # Chiamata a metodo update
        $profile->updateUserProfile($username, $nome, $cognome, $email, $passwordHash);

        echo json_encode([
            "status" => "Successo",
            "message" => "Profilo aggiornato"
        ]);
        exit;

    } else {
        http_response_code(405);
        echo json_encode([
            "status" => "Errore",
            "message" => "Metodo non supportato"
        ]);
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "Errore",
        "message" => "Errore interno"
    ]);
} finally {
    if (isset($con)) $con->close();
}
