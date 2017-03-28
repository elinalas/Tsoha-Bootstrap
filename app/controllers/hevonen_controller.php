<?php
require 'app/models/hevonen.php';
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
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('hevonen/hevonen.html', array('hevonen' => $hevonen));
  }
}