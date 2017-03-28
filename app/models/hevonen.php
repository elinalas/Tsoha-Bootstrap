<?php

  class Hevonen extends BaseModel{

    public $nimi, $rekisterinumero, $omistaja, $kokoluokka;
 
  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Hevonen');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $hepat = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $hepat[] = new Hevonen(array(
        'nimi' => $row['nimi'],
        'rekisterinumero' => $row['rekisterinumero'],
        'omistaja' => $row['omistaja'],
        'kokoluokka' => $row['kokoluokka']
      ));
    }

    return $hepat;
  }
  
  public static function find($rekisterinumero){
    $query = DB::connection()->prepare('SELECT * FROM Hevonen WHERE rekisterinumero = :rekisterinumero LIMIT 1');
    $query->execute(array('rekisterinumero' => $rekisterinumero));
    $row = $query->fetch();

    if($row){
      $hevonen = new Hevonen(array(
        'nimi' => $row['nimi'],
        'rekisterinumero' => $row['rekisterinumero'],
        'omistaja' => $row['omistaja'],
        'kokoluokka' => $row['kokoluokka']
      ));

      return $hevonen;
    }

    return null;
  }
  
  }