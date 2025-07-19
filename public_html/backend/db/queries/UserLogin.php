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
        if(!($result = $stmt->get_result())) {
            throw new mysqli_sql_exception("Errore nel recuperare il risultato della query:" . get_class($this));
        }

        $this->close($stmt);

        # 1. controllare che la query abbia restituito 1 solo record
        
        if($result->num_rows !== 1) {
            throw new Error("L'email non è presente nel database");
        }

        # Recuperiamo il record
        if(!($row = $result->fetch_assoc())) {
            throw new mysqli_sql_exception("Errore nel recuperare il record della query:" . get_class($this));
        }

        $result->free();

        # 2. salvarsi il campo password del db e confrontarlo con la password inserita  dall'utente (password_verify)
        
        $pass = $row['password'];
        if (!password_verify($this->pass, $pass)) {
            throw new Error("Le password non coincidono");
        }

        # 3. se tutto è ok creare la variabile di sessione username contenente tale dato dal db
        $_SESSION['username'] = $row['username'];

}
}
