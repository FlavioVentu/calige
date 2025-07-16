<?php

require_once 'preparedStmt.php';

class UserLogin extends PreparedStmt {

    private $pass;

    public function __constructor(mysqli $con, string $query, string $pass) {
        parent::__constructor($con,$query);
        $this->pass = $pass;
    }

    public function execute(string $types, array $params) {
        $stmt = $this->prepare($types,$params);

        # TODO: implementare la logica del login
        # 1. controllare che la query abbia restituito 1 solo record
        # 2. salvarsi il campo password del db e confrontarlo con la password inserita  dall'utente (password_verify)
        # 3. se tutto è ok creare la variabile di sessione username contenente tale dato dal db

        $this->close($stmt);
    }
}
