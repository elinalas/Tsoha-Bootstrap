<?php
class HevonenController extends BaseController{
  public static function index(){
    self::check_logged_in();
    if (self::is_admin()) {
       Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi nähdä kaikki hevoset!'));
    }
    $hepat = Hevonen::all();
    
    View::make('hevonen/hevoset.html', array('hepat' => $hepat));
  }
  
  public static function show($rekisterinumero){   
    $hevonen = Hevonen::find($rekisterinumero);
    $kayttaja = Kayttaja::find($hevonen->kayttaja);
    
    View::make('hevonen/hevonen.html', array('hevonen' => $hevonen, 'kayttaja' => $kayttaja));
  }
  
  public static function create(){
    self::check_logged_in();
    View::make('hevonen/lisaa_hevonen.html');
  }
  
  public static function store() {
        self::check_logged_in();
        $params = $_POST;
       
        $attributes = array(
            'nimi' => $params['nimi'],
            'rekisterinumero' => $params['rekisterinumero'],
            'kayttaja' => $params['kayttaja'],
            'kokoluokka' => $params['kokoluokka']);
        
        $hevonen = new Hevonen($attributes);
        $errors = $hevonen->errors();
        
        if(count($errors) == 0) {
            $hevonen->save();
            Redirect::to('/hevonen/' . $hevonen->rekisterinumero, array('message' => 'Uusi hevonen on lisätty!'));
        } else {
            View::make('hevonen/lisaa_hevonen.html', array('errors' => $errors, 'attributes' => $attributes));
        }
        
        

        
        
    }
    
    public static function edit($id){
    self::check_logged_in();
    $hevonen = Hevonen::find($id);
    if (self::get_user_logged_in()->jasennumero != $hevonen->omistaja) {
       Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain omistaja voi muokata hevostaan!'));
    }
   
    View::make('hevonen/muokkaa_hevonen.html', array('attributes' => $hevonen));
  }
  
  
  public static function destroy($rekisterinumero){
    self::check_logged_in();
    
    $hevonen = new Hevonen(array('rekisterinumero' => $rekisterinumero));
    if (self::get_user_logged_in()->jasennumero != $hevonen->omistaja) {
       Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain omistaja voi poistaa hevosen!'));
    }
   
    $hevonen->destroy();

    Redirect::to('/hevoset', array('message' => 'Hevonen on poistettu onnistuneesti!'));
  }
  
}