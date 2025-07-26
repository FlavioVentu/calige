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

CREATE TABLE posizione (
    titolo VARCHAR(20),
    città VARCHAR(30) NOT NULL DEFAULT 'Genova',
    latitudine DECIMAL(9,6) NOT NULL,
    longitudine DECIMAL(9,6) NOT NULL,
    PRIMARY KEY (titolo),
    UNIQUE (latitudine, longitudine),
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
    FOREIGN KEY (autore) REFERENCES utente(username) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag) REFERENCES community(tag) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE commento (
    commid INT AUTO_INCREMENT,
    autore VARCHAR(20) NOT NULL,
    postid INT NOT NULL,
    descrizione VARCHAR(255) NOT NULL,
    data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (commid),
    FOREIGN KEY (autore) REFERENCES utente(username) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (postid) REFERENCES post(postid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE menzione (
    username VARCHAR(20),
    postid INT,
    PRIMARY KEY (username, postid),
    FOREIGN KEY (username) REFERENCES utente(username) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (postid) REFERENCES post(postid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE segue (
    username VARCHAR(20),
    tag VARCHAR(20),
    accesso TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (username, tag),
    FOREIGN KEY (username) REFERENCES utente(username) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag) REFERENCES community(tag) ON DELETE CASCADE ON UPDATE CASCADE
);