<?php

class KayttajaController extends BaseController {

    public static function index() {
        self::check_logged_in();
        if ($user_logged_in.status == FALSE) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi nähdä kaikki käyttäjät!'));
        }
        $kayttajat = Kayttaja::all();

        View::make('kayttaja/kayttajat.html', array('kayttajat' => $kayttajat));
    }

    public static function show($jasennumero) {

        $kayttaja = Kayttaja::find($jasennumero);
        $hevoset = Hevonen::findallkayttaja($jasennumero);
        $osallistumiset = array();
        foreach ($hevoset as $hevonen) {
            $osallistumiset += Osallistuminen::findallhevonen($hevonen->rekisterinumero);
        }

        View::make('kayttaja/kayttaja.html', array('kayttaja' => $kayttaja, 'hevoset' => $hevoset, 'osallistumiset' => $osallistumiset));
    }

    public static function create() {
        //
        View::make('kayttaja/luo_kayttaja.html');
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi'],
            'jasennumero' => $params['jasennumero'],
            'salasana' => $params['salasana'],
            'status' => false
        );


        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if (count($errors) == 0) {
            $kayttaja->save();
            Redirect::to('/kayttaja/' . $kayttaja->jasennumero, array('message' => 'Käyttäjä luotu!'));
        } else {
            View::make('kayttaja/luo_kayttaja.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function kirjaudu_sisaan() {
        View::make('kayttaja/kirjaudu_sisaan.html');
    }

    public static function handle_kirjaudu_sisaan() {
        $params = $_POST;

        $kayttaja = Kayttaja::authenticate($params['nimi'], $params['salasana']);

        if (!$kayttaja) {
            View::make('kayttaja/kirjaudu_sisaan.html', array('error' => 'Väärä nimi tai salasana!', 'nimi' => $params['nimi']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->jasennumero;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
        }
    }
    
    public static function logout(){
    $_SESSION['user'] = null;
    Redirect::to('/kirjaudu_sisaan', array('message' => 'Olet kirjautunut ulos!'));
  }

}
