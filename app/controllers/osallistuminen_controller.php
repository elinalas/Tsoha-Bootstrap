<?php

class OsallistuminenController extends BaseController {

    public static function index() {
        $osallistumiset = Osallistuminen::all();
        $hevoset = array();      
        if (self::get_user_logged_in()){
            $kayttajanhevoset = Hevonen::findallkayttaja(self::get_user_logged_in()->jasennumero);
        } else {
            $kayttajanhevoset = array();
        }
        $kilpailut = array();
        foreach ($osallistumiset as $osallistuminen) {
            $kilpailu = Kilpailu::findosallistuminen($osallistuminen->kilpailu);
            $kilpailut[$kilpailu->id] = $kilpailu;
            $hevonen = Hevonen::findosallistuminen($osallistuminen->hevonen);
            $hevoset[$hevonen->rekisterinumero] = $hevonen;
        }        

        View::make('osallistuminen/osallistumiset.html', array('osallistumiset' => $osallistumiset, 'kilpailut' => $kilpailut, 'hevoset' => $hevoset, 'kayttajanhevoset' => $kayttajanhevoset));
    }

    public static function show($id) {

        $osallistuminen = Osallistuminen::find($id);

        View::make('osallistuminen/osallistuminen.html', array('osallistuminen' => $osallistuminen));
    }

    public static function create() {
        self::check_logged_in();
        $omathevoset = Hevonen::findallkayttaja(self::get_user_logged_in()->jasennumero);
        $kaikkikilpailut = Kilpailu::all();
        View::make('osallistuminen/lisaa_osallistuminen.html', array('kaikkikilpailut' => $kaikkikilpailut, 'omathevoset' => $omathevoset));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'ratsastaja' => $params['ratsastaja'],
            'ratsastajan_jasennumero' => $params['ratsastajan_jasennumero'],
            'hevonen' => $params['hevonen'],
            'kilpailu' => $params['kilpailu']
        );

        $osallistuminen = new Osallistuminen($attributes);
        $errors = $osallistuminen->errors();

        if (count($errors) == 0) {
            $osallistuminen->save();
            Redirect::to('/osallistuminen/' . $osallistuminen->id, array('message' => 'Osallistuminen lisätty!'));
        } else {
            View::make('osallistuminen/lisaa_osallistuminen.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function merkitse_osallistuminen_maksetuksi($id) {
        self::check_logged_in();
        if (!self::is_admin()) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Sinun on oltava ylläpitäjä voidaksesi merkitä maksuja!'));
        }
        Osallistuminen::merkitse_maksetuksi($id);

        Redirect::to('/osallistumiset', array('message' => 'Osallistuminen maksettu!'));
    }

    public static function edit($id) {
        !self::check_logged_in();
        $osallistuminen = Osallistuminen::find($id);
        $hevonen = Hevonen::find($osallistuminen->hevonen);
        $kilpailu = Kilpailu::find($osallistuminen->kilpailu);
        View::make('kilpailu/muokkaa_kilpailu.html', array('attributes' => array('osallistuminen' => $osallistuminen, 'hevonen' => $hevonen, 'kilpailu' => $kilpailu)));
    }

    public static function update($id) {
        !self::check_logged_in();
        $params = $_POST;

        $attributes = new Osallistuminen(array(
            'ratsastaja' => $params['ratsastaja'],
            'ratsastajan_jasennumero' => $params['ratsastajan_jasennumero'],
            'hevonen' => $params['hevonen'],
            'kilpailu' => $params['kilpailu']
        ));

        $osallistuminen = new Osallistuminen($attributes);
        $errors = $osallistuminen->errors();

        if (count($errors) > 0) {
            View::make('osallistuminen/muokkaa_osallistuminen.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $osallistuminen->update();

            Redirect::to('/osallistuminen/' . $osallistuminen->id, array('message' => 'Osallistumista ei muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        !self::check_logged_in();
        $osallistuminen = new Osallistuminen(array('id' => $id));
        $osallistuminen->destroy();

        Redirect::to('/osallistumiset', array('message' => 'Osallistuminen on poistettu onnistuneesti!'));
    }

}
