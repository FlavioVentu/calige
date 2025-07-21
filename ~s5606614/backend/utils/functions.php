<?php

# funzione per generare uno username di un utente
use Random\RandomException;

function randomUsername($length = 20): string
{
    $caratteri = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
    $username = '';
    $total_char = strlen($caratteri) - 1;

    for($i = 0; $i < $length; $i++) {
        try {
            $username .= $caratteri[random_int(0, $total_char)];
        } catch (RandomException $e) {
            throw new Error("Errore nella generazione dello username: " . $e->getMessage());
        }
    }

    return $username;
}

# funzione per controllare se una richiesta è da browser
function isBrowserRequest(): bool
{
    return !empty($_SERVER['HTTP_USER_AGENT']) && str_contains($_SERVER['HTTP_USER_AGENT'], 'Mozilla');
}
