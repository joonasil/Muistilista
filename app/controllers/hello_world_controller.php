<?php
    
class HelloWorldController extends BaseController{

    public static function index(){
        $user = self::get_user_logged_in();
        View::make('app/frontpage.html', array('user_logged_in' => $user));
    }

    public static function sandbox(){
      $admin = Account::find(1);
      $users = Account::all();
      $errands = Errand::all();
      Kint::dump($admin);
      Kint::dump($users);
      Kint::dump($errands);
    }

  }
