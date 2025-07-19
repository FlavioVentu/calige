<?php

class UserUpdate {
    private $con;
    private $password;

    public function __construct(mysqli $con, ?string $password) {
        $this->con = $con;
        $this->password = $password;
    }

    public function execute(string $username, string $firstname, string $lastname, string $email): void {
        if ($this->password) {
            $hashed = password_hash($this->password, PASSWORD_DEFAULT);
            $sql = "UPDATE utente SET nome = ?, cognome = ?, email = ?, password = ? WHERE username = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('sssss', $firstname, $lastname, $email, $hashed, $username);
        } else {
            $sql = "UPDATE utente SET nome = ?, cognome = ?, email = ? WHERE username = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('ssss', $firstname, $lastname, $email, $username);
        }

        if (!$stmt->execute()) {
            throw new Exception("Errore durante l'aggiornamento del profilo");
        }

        $stmt->close();
    }
}
