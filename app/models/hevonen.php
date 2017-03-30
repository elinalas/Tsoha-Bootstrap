<?php

class Hevonen extends BaseModel {

    public $nimi, $rekisterinumero, $kayttaja, $kokoluokka;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Hevonen');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $hepat = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $hepat[] = new Hevonen(array(
                'nimi' => $row['nimi'],
                'rekisterinumero' => $row['rekisterinumero'],
                'kayttaja' => $row['kayttaja'],
                'kokoluokka' => $row['kokoluokka']
            ));
        }

        return $hepat;
    }

    public static function find($rekisterinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Hevonen WHERE rekisterinumero = :rekisterinumero LIMIT 1');
        $query->execute(array('rekisterinumero' => $rekisterinumero));
        $row = $query->fetch();

        if ($row) {
            $hevonen = new Hevonen(array(
                'nimi' => $row['nimi'],
                'rekisterinumero' => $row['rekisterinumero'],
                'kayttaja' => $row['kayttaja'],
                'kokoluokka' => $row['kokoluokka']
            ));

            return $hevonen;
        }

        return null;
    }
    
    public static function findallkayttaja($kayttaja) {
        $query = DB::connection()->prepare('SELECT * FROM Hevonen WHERE kayttaja = :kayttaja');
        $query->execute(array('kayttaja' => $kayttaja));
        $row = $query->fetch();

        if ($row) {
            $hevoset[] = new Hevonen(array(
                'nimi' => $row['nimi'],
                'rekisterinumero' => $row['rekisterinumero'],
                'kayttaja' => $row['kayttaja'],
                'kokoluokka' => $row['kokoluokka']
            ));

            return $hevoset;
        }

        return null;
    }
    
    public static function findallosallistuminen($rekisterinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Hevonen WHERE rekisterinumero = :rekisterinumero');
        $query->execute(array('rekisterinumero' => $rekisterinumero));
        $row = $query->fetch();

        if ($row) {
            $hevoset[] = new Hevonen(array(
                'nimi' => $row['nimi'],
                'rekisterinumero' => $row['rekisterinumero'],
                'kayttaja' => $row['kayttaja'],
                'kokoluokka' => $row['kokoluokka']
            ));

            return $hevoset;
        }

        return null;
    }

    

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Hevonen (nimi, rekisterinumero, kayttaja, kokoluokka) VALUES (:nimi, :rekisterinumero, :kayttaja, :kokoluokka) RETURNING rekisterinumero');
        $query->execute(array('nimi' => $this->nimi, 'rekisterinumero' => $this->rekisterinumero, 'kayttaja' => $this->kayttaja, 'kokoluokka' => $this->kokoluokka));
        $row = $query->fetch();
    }

}
