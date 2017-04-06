<?php

class Kayttaja extends BaseModel {

    public $nimi, $jasennumero, $status, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_jasennumero', 'validate_salasana');
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $kayttajat = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $kayttajat[] = new Kayttaja(array(
                'nimi' => $row['nimi'],
                'jasennumero' => $row['jasennumero'],
                'status' => $row['status']
            ));
        }

        return $kayttajat;
    }

    public static function find($jasennumero) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE jasennumero = :jasennumero LIMIT 1');
        $query->execute(array('jasennumero' => $jasennumero));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'nimi' => $row['nimi'],
                'jasennumero' => $row['jasennumero'],
                'status' => $row['status']
            ));

            return $kayttaja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, salasana, jasennumero) VALUES (:nimi, :salasana, :jasennumero)');
        $query->execute(array('nimi' => $this->nimi, 'salasana' => $this->salasana, 'jasennumero' => $this->jasennumero));
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

    public function validate_salasana() {
        $errors = array();
        if ($this->salasana == '' || $this->salasana == null) {
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }
        if (strlen($this->salasana) < 6) {
            $errors[] = 'Salasanan tulee olla vähintään 6 merkkiä!';
        }
        if (strlen($this->salasana) > 30) {
            $errors[] = 'Salasanan tulee olla enintään 30 merkkiä!';
        }
        return $errors;
    }

    public function validate_jasennumero() {
        $errors = array();
        if ($this->salasana == '' || $this->salasana == null) {
            $errors[] = 'Jasennumero ei saa olla tyhjä!';
        }
        if (strlen($this->jasennumero) != 8) {
            $errors[] = 'Jasennumeron tulee olla 6 merkkiä!';
        }
        return $errors;
    }

    public function authenticate($nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $kayttaja = new Kayttaja($row);
            return $kayttaja;
        } else {
            return null;
        }
    }

}
