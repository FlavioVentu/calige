<?php

# classe per la gestione della connesione al DB
final class Connection {
    const HOST = 'localhost';
    const USER = 'root';
    const PASS = 'root';
    const DB = 's5606614';

    public static function getCon(): mysqli
    {

        $con = new mysqli(self::HOST, self::USER, self::PASS, self::DB);

        if($con->connect_error) {
            throw new mysqli_sql_exception("Errore di connessione al DB");
        }
        
        return $con;
    }
}
