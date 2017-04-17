<?php

  class Osallistuminen extends BaseModel{

    public $id, $kilpailu, $hevonen, $ratsastaja, $ratsastajan_jasennumero, $maksustatus;
 
  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Osallistuminen');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $osallistumiset = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $osallistumiset[] = new Osallistuminen(array(
        'id' => $row['id'],
        'kilpailu' => $row['kilpailu'],
        'hevonen' => $row['hevonen'],
        'ratsastaja' => $row['ratsastaja'],
        'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']  
      ));
    }

    return $osallistumiset;
  }
  
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Osallistuminen WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $osallistuminen = new Osallistuminen(array(
        'id' => $row['id'],
        'kilpailu' => $row['kilpailu'],
        'hevonen' => $row['hevonen'],
        'ratsastaja' => $row['ratsastaja'],
        'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']  
      ));

      return $osallistuminen;
    }

    return null;
  }
  
  public static function findallkilpailu($kilpailu){
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
        'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']  
      ));


    }

    return $osallistumiset;
  }
  
  public static function findallhevonen($hevonen){
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
        'ratsastajan_jasennumero' => $row['ratsastajan_jasennumero']  
      ));


    }
    return $osallistumiset;

  }
  
  public static function merkitse_maksetuksi($id) {
        self::check_logged_in();
        if ($user_logged_in.status == false) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Sinun on oltava ylläpitäjä voidaksesi merkitä maksuja!'));
        }
        $osallistuminen = Osallistuminen::find($id);
    }

  
  }