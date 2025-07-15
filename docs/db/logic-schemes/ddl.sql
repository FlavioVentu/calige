CREATE TABLE utente (
    username VARCHAR(20),
    nome VARCHAR(30) NOT NULL,
    cognome VARCHAR(30) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (username),
    UNIQUE (email),
    CHECK ( email LIKE '%@%.%')
);

CREATE TABLE parco (
    titolo VARCHAR(20),
    descrizione VARCHAR(255) NOT NULL,
    immagine VARCHAR(30) NOT NULL,
    PRIMARY KEY (titolo),
    CHECK ( immagine LIKE '%.%')
);

CREATE TABLE indirizzo (
    titolo VARCHAR(20),
    città VARCHAR(30) NOT NULL DEFAULT 'Genova',
    via VARCHAR(50) NOT NULL,
    cap CHAR(5) NOT NULL,
    PRIMARY KEY (titolo),
    FOREIGN KEY (titolo) REFERENCES parco(titolo) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE community (
    tag VARCHAR(20),
    descrizione VARCHAR(255) NOT NULL,
    PRIMARY KEY (tag)
);

CREATE TABLE post (
    postid INT AUTO_INCREMENT,
    autore VARCHAR(20) NOT NULL,
    tag VARCHAR(20) NOT NULL,
    descrizione VARCHAR(255) NOT NULL,
    data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (postid),
    FOREIGN KEY (autore) REFERENCES utente(username),
    FOREIGN KEY (tag) REFERENCES community(tag)
);

CREATE TABLE commento (
    commid INT AUTO_INCREMENT,
    autore VARCHAR(20) NOT NULL,
    postid INT NOT NULL,
    descrizione VARCHAR(255) NOT NULL,
    data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (commid),
    FOREIGN KEY (autore) REFERENCES utente(username),
    FOREIGN KEY (postid) REFERENCES post(postid)
);

CREATE TABLE menzione (
    username VARCHAR(20),
    postid INT,
    PRIMARY KEY (username, postid),
    FOREIGN KEY (username) REFERENCES utente(username),
    FOREIGN KEY (postid) REFERENCES post(postid)
);

CREATE TABLE segue (
    username VARCHAR(20),
    tag VARCHAR(20),
    accesso TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (username, tag),
    FOREIGN KEY (username) REFERENCES utente(username),
    FOREIGN KEY (tag) REFERENCES community(tag)
);