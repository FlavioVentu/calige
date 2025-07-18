<?php
require_once 'preparedStmt.php';

class UserProfile extends PreparedStmt {

    public function getUserProfile(string $username) {
        $stmt = $this->prepare('s', [$username], "SELECT username, nome, cognome, email FROM utente WHERE username = ?");
        $result = $stmt->get_result();

        if ($result->num_rows !== 1) {
            $this->close($stmt);
            return false;
        }

        $data = $result->fetch_assoc();
        $this->close($stmt);

        return $data;
    }

    public function updateUserProfile(string $username, ?string $nome, ?string $cognome, ?string $email, ?string $passwordHash) {
        // Costruiamo la query dinamicamente a seconda dei parametri passati
        $fields = [];
        $types = '';
        $params = [];

        if ($nome !== null) {
            $fields[] = 'nome = ?';
            $types .= 's';
            $params[] = $nome;
        }
        if ($cognome !== null) {
            $fields[] = 'cognome = ?';
            $types .= 's';
            $params[] = $cognome;
        }
        if ($email !== null) {
            $fields[] = 'email = ?';
            $types .= 's';
            $params[] = $email;
        }
        if ($passwordHash !== null) {
            $fields[] = 'password = ?';
            $types .= 's';
            $params[] = $passwordHash;
        }

        if (count($fields) === 0) {
            // Nessun campo da aggiornare
            return;
        }

        $types .= 's'; // per username alla fine
        $params[] = $username;

        $setClause = implode(', ', $fields);
        $query = "UPDATE utente SET $setClause WHERE username = ?";

        $stmt = $this->prepare($types, $params, $query);

        if ($stmt->affected_rows < 1) {
            $this->close($stmt);
            throw new Exception("Aggiornamento non riuscito o nessuna modifica effettuata");
        }

        $this->close($stmt);
    }
}
