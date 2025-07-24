<?php

require_once "UserRegistration.php";

class UserUpdateProfile extends PreparedStmt {

    public function execute(string $types, array $params): void
    {
        $stmt = $this->prepare($types,$params);

        $this->close($stmt);

        # se è stata modificata anche la email la aggiorniamo in sessione
        if(count($params) === 3) {
            $_SESSION['email'] = $params[2]; # email
        }
    }
}
