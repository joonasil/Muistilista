<?php

class UserController extends BaseController{
    public static function login(){
        View::make('app/login.html');
    }
    public static function handle_login(){
        $params = $_POST;
        
        $user = Account::authenticate($params['username'], $params['password']);
        
        if(!$user){
            View::make('app/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana'));
        }else{
            $_SESSION['user'] = $user->id;
        }
        Redirect::to('/', array('message' => 'Kirjauduttu sisään onnistuneesti!'));
    }
    
    public static function register(){
        View::make('app/register.html');
    }
    
    public static function hadle_register(){
        $params = $_POST;
        
        $user = Account::find_name($params['username']);
        
        if($user){
            View::make('app/register.html', array('error' => 'Käyttäjänimi varattu!'));
        }
        if(!($params['password1'] == $params['password2'])){
            View::make('app/register.html', array('error' => 'Salasanat eivät täsmää!'));
        }
        $account = new Account(array(
            'username' => $params['username'],
            'password' => $params['password'],
            'is_admin' => 'false'
        ));
        Redirect::to('/', array('message' => 'Rekisteröityminen valmis!'));
    }
}

