-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kilpailu (paivamaara, nimi, taso, kilpailupaikka) VALUES ("20.04.2017", "Helppo C", "1. taso", "Hauska Ratsutalli");
INSERT INTO Kilpailu (paivamaara, nimi, taso, kilpailupaikka) VALUES ("20.04.2017", "Helppo A", "1. taso", "Hauska Ratsutalli");
INSERT INTO Kayttaja (jasennumero, nimi, yllapitaja) VALUES (28279949, "Elina Lassila", true);
INSERT INTO Kayttaja (jasennumero, nimi) VALUES (01010101, "Tiina Testinainen");
INSERT INTO Hevonen (rekisterinumero, nimi, kokoluokka, kayttaja) VALUES (428034327750002, "Rodmens", "Hevonen", 28279949);
INSERT INTO Hevonen (rekisterinumero, nimi, kokoluokka, kayttaja) VALUES (010101010101011, "Toivo Testiheppa", "Hevonen", 01010101);
INSERT INTO Osallistuminen (ratsastaja, ratsastajan_jasennumero, hevonen, kilpailu) 
VALUES ("Elina Lassila", 28279949, 428034327750002, 1);
INSERT INTO Osallistuminen (ratsastaja, ratsastajan_jasennumero, hevonen, kilpailu) 
VALUES ("Elina Lassila", 28279949, 428034327750002, 2);
INSERT INTO Osallistuminen (ratsastaja, ratsastajan_jasennumero, hevonen, kilpailu) 
VALUES ("Tanja Testinainen", 11111111, 010101010101011, 1);