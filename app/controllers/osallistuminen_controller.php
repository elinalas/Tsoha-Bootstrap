<?php
require 'app/models/hevonen.php';
require 'app/models/kayttaja.php';
require 'app/models/osallistuminen.php';
require 'app/models/kilpailu.php';
class OsallistuminenController extends BaseController{
  public static function index(){
    // Haetaan kaikki pelit tietokannasta
    $osallistumiset = Osallistuminen::all();
    $hevoset = array();
    $kilpailut = array();
        foreach ($osallistumiset as $osallistuminen) {
            $kilpailut = Kilpailu::findallosallistuminen($osallistuminen->kilpailu);
            $hevoset = Hevonen::findallosallistuminen($osallistuminen->hevonen);
        }
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('osallistuminen/osallistumiset.html', array('osallistumiset' => $osallistumiset,'hevoset' => $hevoset));
  }
  
  public static function show($id){
    // Haetaan kaikki pelit tietokannasta
    $osallistuminen = Osallistuminen::find($id);
    //$kilpailu = Kilpailu::find($osallistuminen->kilpailu)
    
    
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('osallistuminen/osallistuminen.html', array('osallistuminen' => $osallistuminen));
  }
  
  public static function create(){
    // Haetaan kaikki pelit tietokannasta
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('osallistuminen/lisaa_osallistuminen.html');
  }
  
  public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $osallistuminen = new Osallistuminen(array(
            'ratsastaja' => $params['ratsastaja'],
            'ratsastajan_jasennumero' => $params['ratsastajan_jasennumero'],
            'hevonen' => $params['hevonen'],
            'kilpailu' => $params['kilpailu']
        ));

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $osallistuminen->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/osallistuminen/' . $osallistuminen->id, array('message' => 'Osallistuminen lisätty!'));
    }
}

