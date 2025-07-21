<?php
require_once 'Stmt.php';

class UserShowProfile extends Stmt {

    public function execute(): array {
        $res = $this->init();

        if($res->num_rows !== 1) {
            throw new mysqli_sql_exception("L'utente non è stato trovato:" . get_class($this));
        }

        if(!($row = $res->fetch_assoc())) {
            throw new mysqli_sql_exception("Errore nella restituzione del record nella query:" . get_class($this));
        }

        $this->close($res);

        return $row;
    }
}
