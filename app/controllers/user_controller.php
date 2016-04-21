<?php

class UserController extends BaseController{
    public static function login(){
        $user = self::get_user_logged_in();
        View::make('app/login.html', array('user_logged_in' => $user));
    }
    public static function handle_login(){
        $params = $_POST;
        
        $user = Account::authenticate($params['username'], $params['password']);
        $user_id = self::get_user_logged_in();
        if(!$user){
            View::make('app/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana', 'user_logged_in' => $user_id));
        }else{
            $_SESSION['user'] = $user->id;
        }
        Redirect::to('/', array('message' => 'Kirjauduttu sisään onnistuneesti!', 'user_logged_in' => $user_id));
    }
    
    public static function register(){
        $user = self::get_user_logged_in();
        View::make('app/register.html', array('user_logged_in' => $user));
    }
    
    public static function hadle_register(){
        $params = $_POST;
        
        $user = Account::find_name($params['username']);
        $user_id = self::get_user_logged_in();
        if($user){
            View::make('app/register.html', array('error' => 'Käyttäjänimi varattu!', 'user_logged_in' => $user_id));
        }
        if(!($params['password1'] == $params['password2'])){
            View::make('app/register.html', array('error' => 'Salasanat eivät täsmää!', 'user_logged_in' => $user_id));
        }
        $account = new Account(array(
            'username' => $params['username'],
            'password' => $params['password1'],
            'is_admin' => 'false'
        ));
        $account->save();
        Redirect::to('/', array('message' => 'Rekisteröityminen valmis!'));
    }
    
    public static function logout(){
        self::check_logged_in();
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
}

