<?php

# classe per la gestione della connessione al DB
final class Connection {
    const HOST = 'localhost';
    const USER = 's5606614';
    const PASS = '3pwd4InIxy';
    const DB = 's5606614';

    public static function getCon(): mysqli
    {

        $con = new mysqli(self::HOST, self::USER, self::PASS, self::DB);

        if($con->connect_error) {
            throw new mysqli_sql_exception($con->error);
        }
        
        return $con;
    }
}
