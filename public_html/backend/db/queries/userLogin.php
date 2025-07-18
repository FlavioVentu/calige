<?php

require_once 'preparedStmt.php';

class UserLogin extends PreparedStmt {

    private $pass;

    public function __construct(mysqli $con, string $query, string $pass) {
        parent::__construct($con,$query);
        $this->pass = $pass;
    }

    public function execute(string $types, array $params) {
        $stmt = $this->prepare($types,$params);
        $result = $stmt->get_result();

        # 1. controllare che la query abbia restituito 1 solo record
        
        if ($result->num_rows !== 1) {
            throw new mysqli_sql_exception("L'inserimento non è andato a buon fine");
        }
        # Recuperiamo il record
        $row = $result->fetch_assoc();

        # 2. salvarsi il campo password del db e confrontarlo con la password inserita  dall'utente (password_verify)
        
        $Password = $row['password'];
        if (password_verify($this->pass, $Password)) {

        # 3. se tutto è ok creare la variabile di sessione username contenente tale dato dal db
        $_SESSION['username'] = $row['username'];
        echo "Login riuscito!";
        } else {
            echo "Password errata.";
        }
    } else {
        echo "Utente non trovato";
    }


    $this->close($stmt);
}
