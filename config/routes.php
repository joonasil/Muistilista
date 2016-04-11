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
      ErrandController::index();
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
  
  $routes->post('/list/add', function(){
  ErrandController::store();
  });
  
  $routes->get('/list/edit', function(){
      HelloWorldController::edit();
  });
  
  $routes->get('/list/:id/edit', function($id){
      ErrandController::edit($id);
  });
  
  