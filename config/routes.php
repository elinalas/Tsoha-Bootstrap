<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/kilpailut', function() {
    HelloWorldController::kilpailut();
  });

  $routes->get('/kayttajat', function() {
    HelloWorldController::kayttajat();
  });
  
  $routes->get('/hevoset', function() {
    HevonenController::index();
  });
  
  $routes->get('/osallistumiset', function() {
    HelloWorldController::osallistumiset();
  });
  
  $routes->get('/muokkaa_osallistuminen', function() {
    HelloWorldController::muokkaa_osallistuminen();
  });
  
  $routes->get('/muokkaa_kilpailu', function() {
    HelloWorldController::muokkaa_kilpailu();
  });
  
  $routes->get('/kayttaja', function() {
    HelloWorldController::kayttaja();
  });
  
  $routes->get('/kilpailu', function() {
    HelloWorldController::kilpailu();
  });
  
  $routes->get('/hevonen/:rekisterinumero', function($rekisterinumero) {
    HevonenController::show($rekisterinumero);
  });
  
  $routes->get('/osallistuminen', function() {
    HelloWorldController::osallistuminen();
  });
  
  $routes->get('/lisaa_osallistuminen', function() {
    HelloWorldController::lisaa_osallistuminen();
  });
  
  $routes->get('/lisaa_hevonen', function() {
    HelloWorldController::lisaa_hevonen();
  });
  
  $routes->get('/lisaa_kilpailu', function() {
    HelloWorldController::lisaa_kilpailu();
  });
  
  $routes->get('/luo_kayttaja', function() {
    HelloWorldController::luo_kayttaja();
  });
  
  $routes->get('/kirjaudu_sisaan', function() {
    HelloWorldController::kirjaudu_sisaan();
  });
 
 