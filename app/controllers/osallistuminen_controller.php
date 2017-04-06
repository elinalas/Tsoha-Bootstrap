<?php
class OsallistuminenController extends BaseController{
  public static function index(){
    $osallistumiset = Osallistuminen::all();
    $hevoset = array();
    $kilpailut = array();
        foreach ($osallistumiset as $osallistuminen) {
            $kilpailut = Kilpailu::findallosallistuminen($osallistuminen->kilpailu);
            $hevoset = Hevonen::findallosallistuminen($osallistuminen->hevonen);
        }

    View::make('osallistuminen/osallistumiset.html', array('osallistumiset' => $osallistumiset,'hevoset' => $hevoset));
  }
  
  public static function show($id){

    $osallistuminen = Osallistuminen::find($id);

    View::make('osallistuminen/osallistuminen.html', array('osallistuminen' => $osallistuminen));
  }
  
  public static function create(){

    View::make('osallistuminen/lisaa_osallistuminen.html');
  }
  
  public static function store() {

        $params = $_POST;

        $osallistuminen = new Osallistuminen(array(
            'ratsastaja' => $params['ratsastaja'],
            'ratsastajan_jasennumero' => $params['ratsastajan_jasennumero'],
            'hevonen' => $params['hevonen'],
            'kilpailu' => $params['kilpailu']
        ));


        $osallistuminen->save();

        Redirect::to('/osallistuminen/' . $osallistuminen->id, array('message' => 'Osallistuminen lisätty!'));
    }
}

