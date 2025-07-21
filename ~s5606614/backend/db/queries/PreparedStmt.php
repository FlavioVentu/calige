<?php

# classe astratta per tutte le query che usano il prepared statement
abstract class PreparedStmt {

    private $con;
    private $query;

    public function __construct(mysqli $con, string $query) {
        $this->con = $con;
        $this->query = $query;
    }

    # funzione astratta da implementare in ogni classe che la estende
    abstract public function execute(string $types, array $params);


    # parte iniziale di un prepared stmt
    protected function prepare(string $types, array $params): mysqli_stmt {

        $stmt = $this->con->prepare($this->query);
        if(!$stmt) {
            throw new mysqli_sql_exception("Errore nella preparazione dello statement:" . get_class($this));
        }
        $stmt->bind_param($types,...$params);
        if(!$stmt) {
            throw new mysqli_sql_exception("Errore nel bind dei parametri:" . get_class($this));
        }
        if(!$stmt->execute()) {
            throw new mysqli_sql_exception("Errore nell'esecuzione della query:" . get_class($this));
        }

        return $stmt;
    }

    # metodo per la chiusura dello stmt
    protected function close(mysqli_stmt $stmt): void {
        if (!$stmt->close()) {
            throw new mysqli_sql_exception("Errore durante la chiusura dello statement:" . get_class($this));
        }
    }
}
