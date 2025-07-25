<?php

require_once "Stmt.php";

class Parks extends Stmt
{

    public function execute(): array
    {
        $res = $this->init();

        if($res->num_rows === 0) {
            throw new Error("Nessun parco trovato");
        }

        if(!($parks = $res->fetch_all(MYSQLI_ASSOC))) {
            throw new mysqli_sql_exception("Errore nella restituzione del risultato della query:" . get_class($this));
        }

        $res->free();

        return $parks;
    }
}
