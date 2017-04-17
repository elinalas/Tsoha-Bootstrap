<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['kayttaja'])) {
            $kayttaja_jasennumero = $_SESSION['kayttaja'];
            // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
            $kayttaja = Kayttaja::find($kayttaja_jasennumero);

            return $kayttaja;
        }

        // Käyttäjä ei ole kirjautunut sisään

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['kayttaja'])) {
            Redirect::to('/kirjaudu_sisaan', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }
    
    public static function is_admin() {
        $user = self::get_user_logged_in();
        return $user && $user['status'];
    }
    
    

}
