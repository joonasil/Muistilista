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
        $user_id = self::get_user_logged_in();
        
        if(!($params['password1'] == $params['password2'])){
            View::make('app/register.html', array('errors' => array('error' => 'Salasanat eivät täsmää!'), 'user_logged_in' => $user_id));
        }
        
        $account = new Account(array(
            'username' => $params['username'],
            'password' => $params['password1'],
            'is_admin' => 'false'
        ));
        $errors = $account->errors();
        if(count($errors) == 0){
            $_SESSION['user'] = $account->save();
            Redirect::to('/', array('message' => 'Rekisteröityminen valmis!'));
        }
        View::make('app/register.html', array('errors' => $errors, 'user_logged_in' => $user_id));
    }
    
    public static function logout(){
        self::check_logged_in();
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
    
    public static function list_users(){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        if(!$user->is_admin){
            Redirect::to('/', array('message' => 'Sivu sallittu vain admineille!'));
        }
        $users = Account::all();
        View::make('app/users.html', array('users' => $users));
    }
    
    public static function toggle_admin($id){
        self::check_logged_in();
        $user = Account::find($id);
        if($user->username == 'Joonas'){
            Redirect::to('/user', array('message' => 'Adminia Joonas ei voi poistaa!'));
        }
        $user->toggle_admin();
        $user->update();
        if($user->is_admin){
            Redirect::to('/user', array('message' => 'Admin lisätty!'));
        }
        Redirect::to('/user', array('message' => 'Admin poistettu!'));
    }
    
    public static function delete($id){
        $user = Account::find($id);
        if($user->username == 'Joonas'){
            Redirect::to('/user', array('message' => 'Käyttäjää Joonas ei voi poistaa!'));
        }
        Account::delete($id);
        Redirect::to('/user', array('message' => 'Käyttäjä poistettu!'));
    }
}

