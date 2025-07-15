## Entità

| Nome      | Descrizione                                                                | Attributi                              | Identificatori  |
|-----------|----------------------------------------------------------------------------|----------------------------------------|-----------------|
| Utente    | Gli utenti del sistema                                                     | username, nome, cognome, email, password | username, email   |
| Post      | Elementi con il quale gli utenti comunicano nel forum                      | postid, descrizione, data              | postid          |
| Parco     | Tutti i parchi che gestiamo nel nostro applicativo                         | titolo, descrizione, immagine          | titolo          |
| Indirizzo | Luogo dove si trovano i nostri parchi                                      | città, via, cap                   | PARCO(titolo) |
| Commenti  | Elementi che utilizzano gli utenti per interagire con post di altri utenti | commid, descrizione, data              | commid          |
| Community | Contenitori per i post dove si possono iscrivere gli utenti                | titolo, descrizione                    | titolo          |

## Associazioni

| Nome     | Descrizione            | Attributi | Entità collegate  |
|----------|------------------------|-----------|-------------------|
| Pubblica | Pubblicazione post     |           | Utente, Post      |
| Segue    | Follow alla community  | accesso   | Utente, Community |
| Risiede  | Luogo del parco        |           | Parco, Indirizzo  |
| Menziona | Utenti citati nel post |           | Post, Utente      |
| Scrive   | Pubblicazione commento |           | Utente, Commento  |
| Risponde | Risposta ad un post    |           | Commento, Post    |
| Ha       | Contesto post          |           | Community, Post   |