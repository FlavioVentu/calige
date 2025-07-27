<?php

require_once 'PreparedStmt.php';

class UserRegistration extends PreparedStmt {

    public function execute(string $types, array $params): void
    {
        $stmt = $this->prepare($types,$params);
        
        $this->close($stmt);
    }
}
