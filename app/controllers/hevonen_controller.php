<?php
require 'app/models/hevonen.php';
require 'app/models/kayttaja.php';
class HevonenController extends BaseController{
  public static function index(){
    // Haetaan kaikki pelit tietokannasta
    $hepat = Hevonen::all();
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('hevonen/hevoset.html', array('hepat' => $hepat));
  }
  
  public static function show($rekisterinumero){
    // Haetaan kaikki pelit tietokannasta
    $hevonen = Hevonen::find($rekisterinumero);
    $kayttaja = Kayttaja::find($hevonen->kayttaja);
    
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('hevonen/hevonen.html', array('hevonen' => $hevonen, 'kayttaja' => $kayttaja));
  }
  
  public static function create(){
    // Haetaan kaikki pelit tietokannasta
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('hevonen/lisaa_hevonen.html');
  }
  
  public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $hevonen = new Hevonen(array(
            'nimi' => $params['nimi'],
            'rekisterinumero' => $params['rekisterinumero'],
            'kayttaja' => $params['kayttaja'],
            'kokoluokka' => $params['kokoluokka']
        ));

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $hevonen->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/hevonen/' . $hevonen->rekisterinumero, array('message' => 'Uusi hevonen on lisätty!'));
    }
}