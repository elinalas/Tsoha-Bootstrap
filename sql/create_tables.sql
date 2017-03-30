CREATE TABLE Kilpailu (
 id SERIAL PRIMARY KEY,
 paivamaara varchar(10) NOT NULL,
 nimi varchar(25) NOT NULL,
 tasoluokitus varchar(10) NOT NULL,
 kilpailupaikka varchar(150) NOT NULL
);

CREATE TABLE Kayttaja (
 jasennumero bigint PRIMARY KEY NOT NULL,
 nimi varchar(150) NOT NULL,
 yllapitaja boolean DEFAULT FALSE
);

CREATE TABLE Hevonen (
 rekisterinumero bigint PRIMARY KEY NOT NULL,
 nimi varchar(150) NOT NULL,
 kokoluokka varchar(10) NOT NULL,
 kayttaja INTEGER REFERENCES Kayttaja(jasennumero)
);

CREATE TABLE Osallistuminen (
 id SERIAL PRIMARY KEY, 
 ratsastaja varchar(150) NOT NULL,
 ratsastajan_jasennumero integer NOT NULL,
 maksettu boolean DEFAULT FALSE,
 hevonen bigint REFERENCES Hevonen(rekisterinumero),
 kilpailu INTEGER REFERENCES Kilpailu(id)
);