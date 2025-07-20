<?php

require_once 'preparedStmt.php';

class UserRegistration extends PreparedStmt {

    public function execute(string $types, array $params) {
        $stmt = $this->prepare($types,$params);

        if ($stmt->affected_rows !== 1) {
            throw new mysqli_sql_exception("L'inserimento non è andato a buon fine:" . get_class($this));
        }
        
        $this->close($stmt);
    }
}
