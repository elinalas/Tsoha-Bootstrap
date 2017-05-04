CREATE TABLE Kilpailu (
 id SERIAL PRIMARY KEY,
 paivamaara DATE NOT NULL,
 nimi varchar(25) NOT NULL,
 tasoluokitus varchar(10) NOT NULL,
 kilpailupaikka varchar(150) NOT NULL
);

CREATE TABLE Kayttaja (
 jasennumero bigint PRIMARY KEY NOT NULL,
 nimi varchar(150) NOT NULL,
 salasana varchar(30) NOT NULL,
 status boolean DEFAULT FALSE
);

CREATE TABLE Hevonen (
 rekisterinumero bigint PRIMARY KEY NOT NULL,
 nimi varchar(150) NOT NULL,
 kokoluokka varchar(10) NOT NULL,
 kayttaja INTEGER REFERENCES Kayttaja(jasennumero) ON DELETE CASCADE
);

CREATE TABLE Osallistuminen (
 id SERIAL PRIMARY KEY, 
 ratsastaja varchar(150) NOT NULL,
 ratsastajan_jasennumero integer NOT NULL,
 maksettu boolean DEFAULT FALSE,
 hevonen bigint REFERENCES Hevonen(rekisterinumero) ON DELETE CASCADE,
 kilpailu INTEGER REFERENCES Kilpailu(id) ON DELETE CASCADE
);
