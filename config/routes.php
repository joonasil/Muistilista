<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
      HelloWorldController::login();
  });
  
  $routes->get('/list', function() {
      HelloWorldController::todo();
  });
  
  $routes->get('/tietokantayhteys', function(){
    DB::test_connection();
  });