## Schema relazionale

UTENTE(<u>username</u>, nome, cognome, _email_, password)

PARCO(<u>titolo</u>, descrizione, immagine)

POSIZIONE(<u>titolo</u><sup>PARCO</sup>, città, _latitudine, longitudine_)

COMMUNITY(<u>tag</u>, descrizione)

POST(<u>postid</u>, autore<sup>UTENTE</sup>, tag<sup>COMMUNITY</sup>, descrizione, data)

COMMENTO(<u>commid</u>, autore<sup>UTENTE</sup>, postid<sup>POST</sup>, descrizione, data)

MENZIONE(<u>username<sup>UTENTE</sup>, postid</u><sup>POST</sup>)

SEGUE(<u>username<sup>UTENTE</sup>, tag<sup>COMMUNITY</sup></u>, accesso)

RECENSIONE(<u>autore<sup>UTENTE</sup>, titolo</u><sup>PARCO</sup>, punteggio, data, testo<sub>o</sub>)