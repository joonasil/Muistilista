<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('suunnitelmat/frontpage.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
    
    public static function login(){
        View::make('suunnitelmat/login.html');
    }
    
    public static function todo(){
        View::make('suunnitelmat/list.html');
    }
    
    public static function register() {
        View::make('suunnitelmat/register.html');
    }
    
    public static function add() {
        View::make('suunnitelmat/add.html');
    }
    
  }
