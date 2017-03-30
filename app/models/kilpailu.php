<?php

  class Kilpailu extends BaseModel{

    public $id, $paivamaara, $nimi, $tasoluokitus, $kilpailupaikka;
 
  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Kilpailu');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $kisat = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
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
  
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Kilpailu WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
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
  
  public static function findall($id){
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
  
  public static function findallosallistuminen($id){
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
  
   public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kilpailu (paivamaara, nimi, tasoluokitus, kilpailupaikka) VALUES (:paivamaara, :nimi, :tasoluokitus, :kilpailupaikka)');
        $query->execute(array('paivamaara' => $this->paivamaara, 'nimi' => $this->nimi, 'tasoluokitus' => $this->tasoluokitus, 'kilpailupaikka' => $this->kilpailupaikka));
        $row = $query->fetch();
    }
  
  }