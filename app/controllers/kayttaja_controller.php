<?php
require 'app/models/hevonen.php';
require 'app/models/kayttaja.php';
require 'app/models/osallistuminen.php';
class KayttajaController extends BaseController{
  public static function index(){
    // Haetaan kaikki pelit tietokannasta
    $kayttajat = Kayttaja::all();
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('kayttaja/kayttajat.html', array('kayttajat' => $kayttajat));
  }
  
  public static function show($jasennumero){
    // Haetaan kaikki pelit tietokannasta
    $kayttaja = Kayttaja::find($jasennumero);
    $hevoset = Hevonen::findallkayttaja($jasennumero);
    $osallistumiset = array();
    foreach($hevoset as $hevonen){
        $osallistumiset += Osallistuminen::findallhevonen($hevonen->rekisterinumero);
    }
    
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('kayttaja/kayttaja.html', array('kayttaja' => $kayttaja, 'hevoset' => $hevoset, 'osallistumiset' => $osallistumiset));
  }
  
  public static function create(){
    // Haetaan kaikki pelit tietokannasta
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('kayttaja/luo_kayttaja.html');
  }
  
  public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $kayttaja = new Kayttaja(array(
            'nimi' => $params['nimi'],
            'jasennumero' => $params['jasennumero'],
            'status' => false            
        ));

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $kayttaja->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/kayttaja/' . $kayttaja->jasennumero, array('message' => 'Käyttäjä luotu!'));
    }
}

