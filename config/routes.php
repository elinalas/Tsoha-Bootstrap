<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
  
  $routes->get('/kilpailut', function() {
    KilpailuController::index();
  });

  $routes->get('/kayttajat', function() {
    KayttajaController::index();
  });
  
  $routes->get('/hevoset', function() {
    HevonenController::index();
  });
  
  $routes->get('/osallistumiset', function() {
    OsallistuminenController::index();
  });
  
  $routes->get('/muokkaa_osallistuminen', function() {
    HelloWorldController::muokkaa_osallistuminen();
  });
  
  $routes->get('/muokkaa_kilpailu', function() {
    HelloWorldController::muokkaa_kilpailu();
  });
  
  $routes->get('/kayttaja/:jasennumero', function($jasennumero) {
    KayttajaController::show($jasennumero);
  });
  
  $routes->get('/kilpailu/:id', function($id) {
    KilpailuController::show($id);
  });
  
  $routes->get('/hevonen/:rekisterinumero', function($rekisterinumero) {
    HevonenController::show($rekisterinumero);
  });
  
  $routes->get('/osallistuminen/:id', function($id) {
    OsallistuminenController::show($id);
  });
  
  $routes->get('/lisaa_osallistuminen', function() {
      OsallistuminenController::create();
  });
  
  $routes->post('/osallistuminen', function() {
      OsallistuminenController::store();
  });
  
  $routes->post('/hevonen', function() {
    HevonenController::store();
  });
  
  $routes->get('/lisaa_hevonen', function() {
    HevonenController::create();
  });
  
  $routes->get('/lisaa_kilpailu', function() {
    HelloWorldController::lisaa_kilpailu();
  });
  
  $routes->get('/luo_kayttaja', function() {
    KayttajaController::create();
  });
  
  $routes->post('/kayttaja', function() {
    KayttajaController::store();
  });
  
  $routes->get('/kirjaudu_sisaan', function() {
    HelloWorldController::kirjaudu_sisaan();
  });
 
 