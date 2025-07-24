<?php

require_once 'PreparedStmt.php';

class UserLogin extends PreparedStmt {

    private string $pass;

    public function __construct(mysqli $con, string $query, string $pass) {
        parent::__construct($con,$query);
        $this->pass = $pass;
    }

    public function execute(string $types, array $params): void
    {
        $stmt = $this->prepare($types,$params);
        if(!($result = $stmt->get_result())) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        $this->close($stmt);

        # 1. controlliamo che la query abbia restituito 1 solo record
        
        if($result->num_rows !== 1) {
            throw new Error("L'email non è presente nel database");
        }

        # Recuperiamo il record come array associativo
        if(!($row = $result->fetch_assoc())) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        $result->free();

        # 2. salvarsi il campo password del db e confrontarlo con la password inserita dall'utente (password_verify)

        if (!password_verify($this->pass, $row['password'])) {
            throw new Error("Le password non coincidono");
        }

        # 3. se tutto è ok creare la variabile di sessione username ed email contenente tale dati dal db
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $params[0]; # email

    }
}
