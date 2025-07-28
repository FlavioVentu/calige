<?php

require_once "PreparedStmt.php";

class GetReviews extends PreparedStmt
{

    public function execute(string $types, array $params): array
    {
        $stmt = $this->prepare($types, $params);

        if(!($result = $stmt->get_result())) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        $this->close($stmt);

        if($result->num_rows === 0) {
            throw new Error("Nessuna recensione trovata");
        }

        # Recuperiamo il record come array associativo
        if(!($res = $result->fetch_all(MYSQLI_ASSOC))) {
            throw new mysqli_sql_exception("Errore nel recuperare le recensioni: " . get_class($this));
        }

        $result->free();

        foreach($res as $record){
            $record['testo'] = htmlentities($record['testo']);
        }

        return $res;
    }
}
