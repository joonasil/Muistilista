<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
      UserController::login();
  });
  
  $routes->post('/login', function() {
      UserController::handle_login();
  });
  
  $routes->get('/list', function() {
      ErrandController::index();
  });
  
  $routes->get('/tietokantayhteys', function(){
    DB::test_connection();
  });
  
  $routes->get('/register', function(){
      UserController::register();
  });
  
  $routes->post('/register', function(){
      UserController::hadle_register();
  });
  
  $routes->get('/list/add', function(){
      ErrandController::add();
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
  
  $routes->post('/list/:id/edit', function($id){
      ErrandController::update($id);
  });
  
  $routes->post('/list/:id/delete', function($id){
      ErrandController::delete($id);
  });
  
  $routes->post('/logout', function(){
      UserController::logout();
  });
  
  