<?php

# funzione per generare randomicamente uno username di un utente
function randomUsername($length = 20) {
    $caratteri = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
    $username = '';
    $total_char = strlen($caratteri) - 1;

    for($i = 0; $i < $length; $i++) {
        $username .= $caratteri[random_int(0, $total_char)];
    }

    return $username;
}
