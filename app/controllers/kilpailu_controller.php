<?php

class KilpailuController extends BaseController {

    public static function index() {

        $kilpailut = Kilpailu::all();

        View::make('kilpailu/kilpailut.html', array('kilpailut' => $kilpailut));
    }

    public static function show($id) {
        // Haetaan kaikki pelit tietokannasta
        $kilpailu = Kilpailu::find($id);
        $osallistumiset = Osallistuminen::findallkilpailu($kilpailu->id);
        $hevoset = array();
        foreach ($osallistumiset as $osallistuminen) {
            $hevonen = Hevonen::findosallistuminen($osallistuminen->hevonen);
            $hevoset[$hevonen->rekisterinumero] = $hevonen;
        }

        View::make('kilpailu/kilpailu.html', array('kilpailu' => $kilpailu, 'osallistumiset' => $osallistumiset, 'hevoset' => $hevoset));
    }

    public static function create() {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi luoda kilpailuja!'));
        }
        View::make('kilpailu/lisaa_kilpailu.html');
    }

    public static function store() {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi luoda kilpailuja!'));
        }
        $params = $_POST;

        $attributes = array(
            'paivamaara' => $params['paivamaara'],
            'nimi' => $params['nimi'],
            'tasoluokitus' => $params['tasoluokitus'],
            'kilpailupaikka' => $params['kilpailupaikka']
        );

        $kilpailu = new Kilpailu($attributes);
        $errors = $kilpailu->errors();

        if (count($errors) == 0) {
            $kilpailu->save();
            Redirect::to('/kilpailut', array('message' => 'Kilpailu on lisätty!'));
        } else {
            View::make('kilpailu/lisaa_kilpailu.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function edit($id) {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi muokata kilpailuja!'));
        }
        $kilpailu = Kilpailu::find($id);
        View::make('kilpailu/muokkaa_kilpailu.html', array( 'attributes' => $kilpailu));
    }

    public static function update($id) {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi muokata kilpailuja!'));
        }
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'paivamaara' => $params['paivamaara'],
            'nimi' => $params['nimi'],
            'tasoluokitus' => $params['tasoluokitus'],
            'kilpailupaikka' => $params['kilpailupaikka']
        );

        $kilpailu = new Kilpailu($attributes);
        $errors = $kilpailu->errors();

        if (count($errors) > 0) {
            View::make('kilpailu/muokkaa_kilpailu.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $kilpailu->update();

            Redirect::to('/kilpailu/' . $kilpailu->id, array('message' => 'Kilpailua muokattiin onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        !self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Vain ylläpitäjä voi poistaa kilpailuja!'));
        }
        $kilpailu = new Kilpailu(array('id' => $id));
        $kilpailu->destroy();

        Redirect::to('/kilpailut', array('message' => 'Kilpailu on poistettu onnistuneesti!'));
    }

}
