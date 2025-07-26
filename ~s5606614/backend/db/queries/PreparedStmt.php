<?php

# classe astratta per tutte le query che usano il prepared statement
abstract class PreparedStmt {

    private mysqli $con;
    private string $query;

    public function __construct(mysqli $con, string $query) {
        $this->con = $con;
        $this->query = $query;
    }

    # funzione astratta da implementare in ogni classe che la estende
    abstract public function execute(string $types, array $params);


    # parte iniziale di un prepared stmt
    protected function prepare(string $types, array $params): mysqli_stmt {

        if(!($stmt = $this->con->prepare($this->query))) {
            throw new mysqli_sql_exception("Errore nella preparazione dello stmt: " . get_class($this));
        }

        if(!$stmt->bind_param($types,...$params)) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        if(!$stmt->execute()) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }

        return $stmt;
    }

    # metodo per la chiusura dello stmt
    protected function close(mysqli_stmt $stmt): void {
        if (!$stmt->close()) {
            throw new mysqli_sql_exception($stmt->error . ": " . get_class($this));
        }
    }
}
