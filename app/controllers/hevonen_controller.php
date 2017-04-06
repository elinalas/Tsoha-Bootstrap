<?php
class HevonenController extends BaseController{
  public static function index(){
    
    $hepat = Hevonen::all();
    
    View::make('hevonen/hevoset.html', array('hepat' => $hepat));
  }
  
  public static function show($rekisterinumero){
   
    $hevonen = Hevonen::find($rekisterinumero);
    $kayttaja = Kayttaja::find($hevonen->kayttaja);
    
   
    View::make('hevonen/hevonen.html', array('hevonen' => $hevonen, 'kayttaja' => $kayttaja));
  }
  
  public static function create(){
    
    View::make('hevonen/lisaa_hevonen.html');
  }
  
  public static function store() {
        
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
    $hevonen = Hevonen::find($id);
    View::make('hevonen/muokkaa_hevonen.html', array('attributes' => $hevonen));
  }
  
  
  public static function destroy($rekisterinumero){
    $hevonen = new Hevonen(array('rekisterinumero' => $rekisterinumero));
    $hevonen->destroy();

    Redirect::to('/hevoset', array('message' => 'Hevonen on poistettu onnistuneesti!'));
  }
  
}