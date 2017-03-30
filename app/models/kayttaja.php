<?php

  class Kayttaja extends BaseModel{

    public $nimi, $jasennumero, $status;
 
  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $kayttajat = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $kayttajat[] = new Kayttaja(array(
        'nimi' => $row['nimi'],
        'jasennumero' => $row['jasennumero'],
        'status' => $row['status']
      ));
    }

    return $kayttajat;
  }
  
  public static function find($jasennumero){
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE jasennumero = :jasennumero LIMIT 1');
    $query->execute(array('jasennumero' => $jasennumero));
    $row = $query->fetch();

    if($row){
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
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, jasennumero) VALUES (:nimi, :jasennumero)');
        $query->execute(array('nimi' => $this->nimi, 'jasennumero' => $this->jasennumero));
        $row = $query->fetch();
    }
  
  }