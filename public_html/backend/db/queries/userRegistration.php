<?php

require_once 'preparedQuery.php';

class UserRegistration extends PreparedQuery {

    public function execute(string $types, array $params) {
        $stmt = $this->prepareStmt($types,$params);

        if ($stmt->affected_rows !== 1) {
            throw new mysqli_sql_exception("L'inserimento non è andato a buon fine");
        }
        
        $this->closeStmt($stmt);
    }
}