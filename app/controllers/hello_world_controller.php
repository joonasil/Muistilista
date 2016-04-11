<?php
    
class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('suunnitelmat/frontpage.html');
    }

    public static function sandbox(){
      $admin = Account::find(1);
      $users = Account::all();
      $errands = Errand::all();
      Kint::dump($admin);
      Kint::dump($users);
      Kint::dump($errands);
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
    
    public static function edit() {
        View::make('suunnitelmat/edit.html');
    }
  }
