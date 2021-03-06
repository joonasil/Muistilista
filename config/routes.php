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
  
   $routes->get('/list/add', function(){
      ErrandController::add();
  });
  
  $routes->post('/list/add', function(){
    ErrandController::store();
  });
  
  $routes->get('/list/:id', function($id) {
      ErrandController::subindex($id);
  });
  
  $routes->post('/list/:id/toggle', function($id) {
      ErrandController::toggle($id);
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
  
  $routes->get('/user', function(){
      UserController::list_users();
  });
  
  $routes->post('/user/:id/toggle', function($id){
      UserController::toggle_admin($id);
  });
  
  $routes->post('/user/:id/delete', function($id){
      UserController::delete($id);
  });
  
  $routes->post('/category/:id/delete', function($id){
      ErrandController::delete_category($id);
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
  
  $routes->get('/category/add', function(){
      ErrandController::add_category(); 
  });
  
  $routes->post('/category/add', function(){
      ErrandController::save_category(); 
  });
  
  