<?php

require_once "PreparedStmt.php";

class GetPark extends PreparedStmt
{
    public function execute(string $types, array $params): array
    {
        $stmt = $this->prepare($types, $params);

        if(!($result = $stmt->get_result())) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        $this->close($stmt);

        if($result->num_rows !== 1) {
            throw new Error("Parco non trovato");
        }

        # Recuperiamo il record come array associativo
        if(!($row = $result->fetch_assoc())) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        $result->free();

        return array_chunk($row, 4, true);
    }
}
