<?php

# classe per gestire le tipologie di error log
final class ErrorLog {

    private static function setLog($path): void {
        ini_set('display_errors', false);
        ini_set('error_log', $path);
    }

    # errori DB
    public static function logDB(): void {
        self::setLog('../db/logs/error.log');
    }

    # errori Generali
    public static function logGeneral(): void {
        self::setLog('logs/error.log');
    }

}
