<?php

class Osallistuminen extends BaseModel {

    public $id, $kilpailu, $hevonen, $ratsastaja, $ratsastajan_jasennumero, $maksettu;

    public function __construct($attributes) {
        parent::__construct($attributes);
         $this->validators = array('validate_ratsastaja', 'validate_kilpailu', 'validate_ratsastajan_jasennumero', 'validate_hevonen');
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Osallistuminen');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $osallistumiset = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $osallistumiset[] = new Osallistuminen(array(
                'id' => $row['id'],
                'kilpailu' => $row['kilpailu'],
                'hevonen' => $row['hevonen'],
                'ratsastaja' => $row['ratsastaja'],
                'maksettu' => $row['maksettu'], 
                'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']
            ));
        }

        return $osallistumiset;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Osallistuminen WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $osallistuminen = new Osallistuminen(array(
                'id' => $row['id'],
                'kilpailu' => $row['kilpailu'],
                'hevonen' => $row['hevonen'],
                'ratsastaja' => $row['ratsastaja'],
                'maksettu' => $row['maksettu'], 
                'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']
            ));

            return $osallistuminen;
        }

        return null;
    }

    public static function findallkilpailu($kilpailu) {
        $query = DB::connection()->prepare('SELECT * FROM Osallistuminen WHERE kilpailu = :kilpailu');
        $query->execute(array('kilpailu' => $kilpailu));
        $rows = $query->fetchAll();
        $osallistumiset = array();

        foreach ($rows as $row) {
            $osallistumiset[] = new Osallistuminen(array(
                'id' => $row['id'],
                'kilpailu' => $row['kilpailu'],
                'hevonen' => $row['hevonen'],
                'ratsastaja' => $row['ratsastaja'],
                'maksettu' => $row['maksettu'],
                'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']
            ));
        }

        return $osallistumiset;
    }

    public static function findallhevonen($hevonen) {
        $query = DB::connection()->prepare('SELECT * FROM Osallistuminen WHERE hevonen = :hevonen');
        $query->execute(array('hevonen' => $hevonen));
        $rows = $query->fetchAll();
        $osallistumiset = array();

        foreach ($rows as $row) {
            $osallistumiset[] = new Osallistuminen(array(
                'id' => $row['id'],
                'kilpailu' => $row['kilpailu'],
                'hevonen' => $row['hevonen'],
                'ratsastaja' => $row['ratsastaja'],
                'maksettu' => $row['maksettu'],
                'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']
            ));
        }
        return $osallistumiset;
    }

    public static function merkitse_maksetuksi($id) {
        $query = DB::connection()->prepare('UPDATE Osallistuminen SET maksettu = true WHERE id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
    }
    
    public static function merkitse_maksamattomaksi($id) {
        $query = DB::connection()->prepare('UPDATE Osallistuminen SET maksettu = false WHERE id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Osallistuminen (kilpailu, hevonen, ratsastaja, ratsastajan_jasennumero) VALUES (:kilpailu, :hevonen, :ratsastaja, :ratsastajan_jasennumero) RETURNING id');
        $query->execute(array('kilpailu' => $this->kilpailu, 'hevonen' => $this->hevonen, 'ratsastaja' => $this->ratsastaja, 'ratsastajan_jasennumero' => $this->ratsastajan_jasennumero));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Osallistuminen SET kilpailu = :kilpailu, hevonen = :hevonen, ratsastaja = :ratsastaja, ratsastajan_jasennumero = :ratsastajan_jasennumero WHERE id = :id');
        $query->execute(array('id' => $this->id, 'kilpailu' => $this->kilpailu, 'hevonen' => $this->hevonen, 'ratsastaja' => $this->ratsastaja, 'ratsastajan_jasennumero' => $this->ratsastajan_jasennumero));
        $row = $query->fetch();
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Osallistuminen WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }
    
    public function validate_ratsastaja() {
        $errors = array();
        if ($this->ratsastaja == '' || $this->ratsastaja == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->ratsastaja) < 5) {
            $errors[] = 'Nimen tulee olla vähintään 4 merkkiä.';
        }
        if (strlen($this->ratsastaja) > 25) {
            $errors[] = 'Nimen tulee olla enintään 150 merkkiä.';
        }
        return $errors;
    }
    
    public function validate_hevonen() {
        $errors = array();
        if ($this->hevonen == '' || $this->hevonen == null) {
            $errors[] = 'Hevonen ei saa olla tyhjä!';
        }      
        return $errors;
    }
    
    public function validate_kilpailu() {
        $errors = array();
        if ($this->kilpailu == '' || $this->kilpailu == null) {
            $errors[] = 'Hevonen ei saa olla tyhjä!';
        }      
        return $errors;
    }
    
    public function validate_ratsastajan_jasennumero() {
        $errors = array();
        if ($this->ratsastajan_jasennumero == '' || $this->ratsastajan_jasennumero == null) {
            $errors[] = 'Jasennumero ei saa olla tyhjä!';
        }
        if (strlen($this->ratsastajan_jasennumero) != 8) {
            $errors[] = 'Jasennumeron tulee olla 8 merkkiä!';
        }
        return $errors;
    }

}
