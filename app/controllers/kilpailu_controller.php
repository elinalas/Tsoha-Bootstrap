<?php
require 'app/models/hevonen.php';
require 'app/models/kayttaja.php';
require 'app/models/kilpailu.php';
require 'app/models/osallistuminen.php';
class KilpailuController extends BaseController{
  public static function index(){
    // Haetaan kaikki pelit tietokannasta
    $kilpailut = Kilpailu::all();
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('kilpailu/kilpailut.html', array('kilpailut' => $kilpailut));
  }
  
  public static function show($id){
    // Haetaan kaikki pelit tietokannasta
    $kilpailu = Kilpailu::find($id);
    $osallistumiset = Osallistuminen::findallkilpailu($kilpailu->id);
    $hevoset = array();
        foreach ($osallistumiset as $osallistuminen) {
            $hevoset = Hevonen::findallosallistuminen($osallistuminen->hevonen);
        }

        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('kilpailu/kilpailu.html', array('kilpailu' => $kilpailu, 'osallistumiset' => $osallistumiset, 'hevoset' => $hevoset));
  }
  
  public static function create(){
    // Haetaan kaikki pelit tietokannasta
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('kilpailu/lisaa_kilpailu.html');
  }
  
  public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $kilpailu = new Kilpailu(array(
            'paivamaara' => $params['paivamaara'],
            'tasoluokitus' => $params['tasoluokitus'],
            'kilpailupaikka' => $params['kilpailupaikka']           
        ));

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $kilpailu->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/kilpailu/' . $kilpailu->id, array('message' => 'Kilpailu lisätty!'));
    }
}

