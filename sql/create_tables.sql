-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kilpailu {
 id SERIAL PRIMARY KEY,
 paivamaara INTEGER NOT NULL,
 nimi varchar(25) NOT NULL,
 taso varchar(10) NOT NULL,
 kilpailupaikka varchar(150) NOT NULL
}

CREATE TABLE Kayttaja {
 jasennumero INTEGER PRIMARY KEY NOT NULL,
 nimi varchar(150) NOT NULL,
 yllapitaja boolean DEFAULT FALSE
}

CREATE TABLE Hevonen {
 rekisterinumero INTEGER PRIMARY KEY NOT NULL,
 nimi varchar(150) NOT NULL,
 kokoluokka varchar(10) NOT NULL,
 kayttaja INTEGER REFERENCES Kayttaja(jasennumero)
}

CREATE TABLE Osallistuminen {
 id SERIAL PRIMARY KEY, 
 ratsastaja varchar(150) NOT NULL,
 ratsastajan_jasennumero varchar(150) NOT NULL,
 maksettu boolean DEFAULT FALSE,
 hevonen INTEGER REFERENCES Hevonen(rekisterinumero),
 kilpailu INTEGER REFERENCES Kilpailu(id)
}
