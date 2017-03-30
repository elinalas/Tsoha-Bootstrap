<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
    
    public static function kilpailut(){
     
      View::make('kilpailut.html');
    }
    
    public static function kayttajat(){    
      View::make('kayttajat.html');
    }
    
    public static function osallistumiset(){    
      View::make('osallistumiset.html');
    }
    
    public static function muokkaa_osallistuminen(){    
      View::make('muokkaa_osallistuminen.html');
    }
     public static function muokkaa_kilpailu(){    
      View::make('muokkaa_kilpailu.html');
    }
    
     public static function kilpailu(){    
      View::make('kilpailu.html');
    }
    
     public static function osallistuminen(){    
      View::make('osallistuminen.html');
    }
    
    
     public static function kayttaja(){    
      View::make('kayttaja.html');
    }
    
     public static function lisaa_osallistuminen(){    
      View::make('lisaa_osallistuminen.html');
    }
    
     public static function lisaa_kilpailu(){    
      View::make('lisaa_kilpailu.html');
    }
    
     public static function lisaa_hevonen(){    
      View::make('lisaa_hevonen.html');
    }
    
     public static function luo_kayttaja(){    
      View::make('luo_kayttaja.html');
    }
    
     public static function kirjaudu_sisaan(){    
      View::make('kirjaudu_sisaan.html');
    }
  }
