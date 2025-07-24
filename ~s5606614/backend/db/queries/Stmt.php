<?php

# classe astratta per tutte le query
abstract class Stmt {

    private mysqli $con;
    private string $query;

    public function __construct(mysqli $con, string $query) {
        $this->con = $con;
        $this->query = $query;
    }

    # funzione astratta da implementare in ogni classe che la estende
    abstract public function execute();


    # parte iniziale di un prepared stmt
    protected function init(): mysqli_result {

         # se la query non va a buon fine lancio un'eccezione
        if (!($res = $this->con->query($this->query))) {
            throw new mysqli_sql_exception("Errore nell'esecuzione della query" . get_class($this));
        }

        return $res;
    }

}
