<?php
class KayttajaController extends BaseController{
    
    public static function index() {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi nähdä kaikki käyttäjät!'));
        }
        $kayttajat = Kayttaja::all();

        View::make('kayttaja/kayttajat.html', array('kayttajat' => $kayttajat));
    }

    public static function show($jasennumero) {

        $kayttaja = Kayttaja::find($jasennumero);
        $hevoset = Hevonen::findallkayttaja($jasennumero);
        $kilpailut = Kilpailu::all();
        $osallistumiset = Kayttaja::loyda_osallistumiset($jasennumero);

        View::make('kayttaja/kayttaja.html', array('kayttaja' => $kayttaja, 'hevoset' => $hevoset, 'osallistumiset' => $osallistumiset, 'kilpailut' => $kilpailut));
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

    public static function logout() {
        $_SESSION['kayttaja'] = session_destroy();
        Redirect::to('/kirjaudu_sisaan', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function destroy($jasennumero) {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi poistaa käyttäjiä!'));
        }
        $kayttaja = new Kayttaja(array('jasennumero' => $jasennumero));
        $kayttaja->destroy();

        Redirect::to('/kilpailut', array('message' => 'Käyttäjä on poistettu onnistuneesti!'));
    }
    
    

}
