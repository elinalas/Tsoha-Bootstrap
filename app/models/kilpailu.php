<?php

class Kilpailu extends BaseModel {

    public $id, $paivamaara, $nimi, $tasoluokitus, $kilpailupaikka;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_paivamaara', 'validate_tasoluokitus', 'validate_kilpailupaikka');
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Kilpailu');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $kisat = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $kisat[] = new Kilpailu(array(
                'id' => $row['id'],
                'paivamaara' => $row['paivamaara'],
                'nimi' => $row['nimi'],
                'tasoluokitus' => $row['tasoluokitus'],
                'kilpailupaikka' => $row['kilpailupaikka']
            ));
        }

        return $kisat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kilpailu WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kilpailu = new Kilpailu(array(
                'id' => $row['id'],
                'paivamaara' => $row['paivamaara'],
                'nimi' => $row['nimi'],
                'tasoluokitus' => $row['tasoluokitus'],
                'kilpailupaikka' => $row['kilpailupaikka']
            ));

            return $kilpailu;
        }

        return null;
    }

    public static function findall($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kilpailu WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $kilpailut = array();

        foreach ($rows as $row) {
            $kilpailut[] = new Kilpailu(array(
                'id' => $row['id'],
                'paivamaara' => $row['paivamaara'],
                'nimi' => $row['nimi'],
                'tasoluokitus' => $row['tasoluokitus'],
                'kilpailupaikka' => $row['kilpailupaikka']
            ));
        }
        return $kilpailut;
    }

    public static function findosallistuminen($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kilpailu WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $kilpailu = array();

        foreach ($rows as $row) {
            $kilpailu = new Kilpailu(array(
                'id' => $row['id'],
                'paivamaara' => $row['paivamaara'],
                'nimi' => $row['nimi'],
                'tasoluokitus' => $row['tasoluokitus'],
                'kilpailupaikka' => $row['kilpailupaikka']
            ));
        }
        return $kilpailu;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kilpailu (paivamaara, nimi, tasoluokitus, kilpailupaikka) VALUES (:paivamaara, :nimi, :tasoluokitus, :kilpailupaikka)');
        $query->execute(array('paivamaara' => $this->paivamaara, 'nimi' => $this->nimi, 'tasoluokitus' => $this->tasoluokitus, 'kilpailupaikka' => $this->kilpailupaikka));
        $row = $query->fetch();
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Kilpailu (paivamaara, nimi, tasoluokitus, kilpailupaikka) VALUES (:paivamaara, :nimi, :tasoluokitus, :kilpailupaikka) RETURNING id');
        $query->execute(array('id' => $this->id, 'paivamaara' => $this->paivamaara, 'nimi' => $this->nimi, 'tasoluokitus' => $this->tasoluokitus, 'kilpailupaikka' => $this->kilpailupaikka));
        $row = $query->fetch();
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Kilpailu WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }

    public function validate_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 5) {
            $errors[] = 'Nimen tulee olla vähintään 2 merkkiä! Esim. 50 cm tai Helppo C.';
        }
        if (strlen($this->nimi) > 25) {
            $errors[] = 'Nimen tulee olla enintään 25 merkkiä. Käytä virallisia nimiä.';
        }
        return $errors;
    }

    public function validate_paivamaara() {
        $errors = array();
        if ($this->paivamaara == '' || $this->nimi == null) {
            $errors[] = 'Päivämäärä ei saa olla tyhjä!';
        }
        if (strlen($this->paivamaara) != 10) {
            $errors[] = 'Päivämäärä tulee olla muodossa pvm.kk.vuosi, esim. 12.01.2017.';
        }
        if (strpos($this->paivamaara, ':')) {
            $errors[] = 'Päivämäärä tulee olla muodossa pvm.kk.vuosi, esim. 12.01.2017. Tarkista kaksoispisteet.';
        }
        return $errors;
    }

    public function validate_tasoluokitus() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Tasoluokitus ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 6) {
            $errors[] = 'Tasoluokitus ei kelpaa. Tasoluokitus vähintään 6 merkkiä, esim. Taso 1.';
        }
        if (strlen($this->nimi) > 10) {
            $errors[] = 'Tasoluokitus ei kelpaa. Tasoluokitus enintään 10 merkkiä. Voit merkitä maksimissaan: Harjoitus';
        }
        return $errors;
    }

    public function validate_kilpailupaikka() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Kilpailupaikka ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) > 150) {
            $errors[] = 'Nimi on liian pitkä!';
        }
        return $errors;
    }

}
