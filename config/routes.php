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
  
  $routes->get('/register', function(){
      HelloWorldController::register();
  });
  
  $routes->get('/list/add', function(){
      HelloWorldController::add();
  });