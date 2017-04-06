-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kilpailu (paivamaara, nimi, tasoluokitus, kilpailupaikka) VALUES ('20.04.2017', 'Helppo C', '1. taso', 'Hauska Ratsutalli'), ('20.04.2017', 'Helppo A', '1. taso', 'Hauska Ratsutalli');
INSERT INTO Kayttaja (jasennumero, nimi, salasana, status) VALUES (28279949, 'Elina Lassila', 'Elina Lassila', true), (01010101, 'Tiina Testinainen', 'Tiina Testinainen', false);
INSERT INTO Hevonen (rekisterinumero, nimi, kokoluokka, kayttaja) VALUES (428034327750002, 'Rodmens', 'Hevonen', 28279949), (010101010101011, 'Toivo Testiheppa', 'Hevonen', 01010101);
INSERT INTO Osallistuminen (ratsastaja, ratsastajan_jasennumero, hevonen, kilpailu) 
VALUES ('Elina Lassila', 28279949, 428034327750002, 1), ('Elina Lassila', 28279949, 428034327750002, 2), ('Tanja Testinainen', 11111111, 010101010101011, 1);
