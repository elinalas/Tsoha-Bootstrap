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


$routes->post('/hevonen/:rekisterinumero/destroy', function($rekisterinumero) {
    HevonenController::destroy($rekisterinumero);
});

$routes->get('/kilpailu/:id/muokkaa_kilpailu', function($id) {
    // Pelin muokkauslomakkeen esittäminen
    KilpailuController::edit($id);
});
$routes->post('/kilpailu/:id/muokkaa_kilpailu', function($id) {
    // Pelin muokkaaminen
    KilpailuController::update($id);
});


$routes->post('/kilpailu/:id/destroy', function($id) {
    KilpailuController::destroy($id);
});

$routes->get('/lisaa_hevonen', function() {
    HevonenController::create();
});


$routes->get('/luo_kayttaja', function() {
    KayttajaController::create();
});

$routes->post('/kayttaja', function() {
    KayttajaController::store();
});

$routes->get('/kirjaudu_sisaan', function() {
    KayttajaController::kirjaudu_sisaan();
});

$routes->post('/kirjaudu_sisaan', function() {
    KayttajaController::handle_kirjaudu_sisaan();
});

$routes->post('/kilpailu', function() {
    KilpailuController::store();
});

$routes->get('/lisaa_kilpailu', function() {
    KilpailuController::create();
});

$routes->post('/kirjaudu_ulos', function() {
    KayttajaController::logout();
});

$routes->post('/osallistuminen/:id/merkitse_maksetuksi', function($id) {
    OsallistuminenController::merkitse_osallistuminen_maksetuksi($id);
});
