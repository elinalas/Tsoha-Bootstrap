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
            $hevoset = Hevonen::findallosallistuminen($osallistuminen->hevonen);
        }

        View::make('kilpailu/kilpailu.html', array('kilpailu' => $kilpailu, 'osallistumiset' => $osallistumiset, 'hevoset' => $hevoset));
    }

    public static function create() {
        View::make('kilpailu/lisaa_kilpailu.html');
    }

    public static function store() {

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
        $kilpailu = Kilpailu::find($id);
        View::make('kilpailu/muokkaa_kilpailu.html', array('attributes' => $kilpailu));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = new Kilpailu(array(
            'paivamaara' => $params['paivamaara'],
            'nimi' => $params['nimi'],
            'tasoluokitus' => $params['tasoluokitus'],
            'kilpailupaikka' => $params['kilpailupaikka']
        ));

        $kilpailu = new Kilpailu($attributes);
        $errors = $kilpailu->errors();

        if (count($errors) > 0) {
            View::make('kilpailu/muokkaa_kilpailu.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $kilpailu->update();

            Redirect::to('/kilpailu/' . $kilpailu->id, array('message' => 'Kilpailua ei muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        $kilpailu = new Kilpailu(array('id' => $id));
        $kilpailu->destroy();

        Redirect::to('/kilpailut', array('message' => 'Kilpailu on poistettu onnistuneesti!'));
    }

}
