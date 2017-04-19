<?php

class Hevonen extends BaseModel {

    public $nimi, $rekisterinumero, $kayttaja, $kokoluokka;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_rekisterinumero', 'validate_kokoluokka');

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
        $rows = $query->fetchAll();
        $hevoset = array();

        foreach ($rows as $row) {
            $hevoset[] = new Hevonen(array(
                'nimi' => $row['nimi'],
                'rekisterinumero' => $row['rekisterinumero'],
                'kayttaja' => $row['kayttaja'],
                'kokoluokka' => $row['kokoluokka']
            ));
        }
        return $hevoset;
    }

    public static function findosallistuminen($rekisterinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Hevonen WHERE rekisterinumero = :rekisterinumero');
        $query->execute(array('rekisterinumero' => $rekisterinumero));
        $rows = $query->fetchAll();
        $hevonen = array();

        foreach ($rows as $row) {
            $hevonen = new Hevonen(array(
                'nimi' => $row['nimi'],
                'rekisterinumero' => $row['rekisterinumero'],
                'kayttaja' => $row['kayttaja'],
                'kokoluokka' => $row['kokoluokka']
            ));
        }
        return $hevonen;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Hevonen (nimi, rekisterinumero, kayttaja, kokoluokka) VALUES (:nimi, :rekisterinumero, :kayttaja, :kokoluokka) RETURNING rekisterinumero');
        $query->execute(array('nimi' => $this->nimi, 'rekisterinumero' => $this->rekisterinumero, 'kayttaja' => $this->kayttaja, 'kokoluokka' => $this->kokoluokka));
        $row = $query->fetch();
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Hevonen (nimi, rekisterinumero, kayttaja, kokoluokka) VALUES (:nimi, :rekisterinumero, :kayttaja, :kokoluokka) RETURNING rekisterinumero');
        $query->execute(array('nimi' => $this->nimi, 'rekisterinumero' => $this->rekisterinumero, 'kayttaja' => $this->kayttaja, 'kokoluokka' => $this->kokoluokka));
        $row = $query->fetch();
    }
    
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Hevonen WHERE rekisterinumero = :rekisterinumero');
        $query->execute(array('rekisterinumero' => $this->rekisterinumero));
        $row = $query->fetch();
    }


    public function validate_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 2) {
            $errors[] = 'Nimen tulee olla vähintään 2 merkkiä!';
        }
        if (strlen($this->nimi) > 150) {
            $errors[] = 'Nimen tulee olla enintään 150 merkkiä!';
        }
        
        return $errors;
    }

    public function validate_rekisterinumero() {
        $errors = array();
        if ($this->rekisterinumero == '' || $this->rekisterinumero == null) {
            $errors[] = 'Rekisterinumero ei saa olla tyhjä!';
        }
        if (!is_numeric($this->rekisterinumero)) {
            $errors[] = 'Rekisterinumeron tulee sisältää vain numeroita!';
        }
        if (strlen($this->rekisterinumero) < 14) {
            $errors[] = 'Tarkistathan, että rekisterinumero vastaa hevosen oikeaa rekisterinumeroa. '
                    . 'Pituuden tulee olla vähintään 14 merkkiä.';
        }
        if (strlen($this->rekisterinumero) > 15) {
            $errors[] = 'Tarkistathan, että rekisterinumero vastaa hevosen oikeaa rekisterinumeroa. Pituus saa olla enintään 15 merkkiä.';
        }
        
        return $errors;
    }
    
    public function validate_kokoluokka() {
        $errors = array();
        if ($this->kokoluokka != 'Hevonen' && $this->kokoluokka != 'Poni') {
            $errors[] = 'Luomasi hevosen kokoluokan tulee olla: Hevonen tai Poni. Valitse oikea kokoluokka.';
        }
        return $errors;
    }

}
