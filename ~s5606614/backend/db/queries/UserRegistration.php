<?php

require_once 'PreparedStmt.php';

class UserRegistration extends PreparedStmt {

    public function execute(string $types, array $params): void
    {
        $stmt = $this->prepare($types,$params);

        if ($stmt->affected_rows !== 1) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }
        
        $this->close($stmt);
    }
}
