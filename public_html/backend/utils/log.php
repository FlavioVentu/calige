<?php

# classe per gestire le tipologie di error log
class ErrorLog {

    private static function setLog($path): void {
        ini_set('display_errors', false);
        ini_set('error_log', $path);
    }

    public static function logDB() {
        self::setLog('../db/logs/error.log');
    }

}