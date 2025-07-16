<?php

abstract class PreparedQuery {

    protected $conn;
    protected $query;

    public function __construct(mysqli $con, string $query) {
        $this->conn = $con;
        $this->query = $query;
    }

    abstract public function execute(string $types, array $params);


    # metodi per i prepared statement
    protected function prepareStmt(string $types, array $params) {
        $stmt = $this->conn->prepare($this->query);
        if(!$stmt) {
            throw new mysqli_sql_exception("Errore nella preparazione dello statement");
        }
        $stmt->bind_param($types,...$params);
        if(!$stmt) {
            throw new mysqli_sql_exception("Errore nel bind dei parametri");
        }
        if(!$stmt->execute()) {
            throw new mysqli_sql_exception("Errore nell'esecuzione della query");
        }

        return $stmt;
    }

    protected function closeStmt(mysqli_stmt $stmt): void {
        if (!$stmt->close()) {
            throw new mysqli_sql_exception("Errore durante la chiusura dello statement");
        }
    }
}
