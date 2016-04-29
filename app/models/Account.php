<?php

class Account extends BaseModel {
    public $id, $username, $password, $is_admin;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password');
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Account');
        
        $query->execute();
        
        $rows = $query->fetchAll();
        $accounts = array();
        
        foreach($rows as $row){
            $accounts[] = new Account(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'is_admin' => $row['is_admin']
            ));
        }
        
        return $accounts;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Account WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $account = new Account(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'is_admin' => $row['is_admin']
            ));
            
            return $account;
        }
        
        return null;
    }
    
    public static function find_name($name){
        $query = DB::connection()->prepare('SELECT * FROM Account WHERE username = :name LIMIT 1');
        $query->execute(array('name' => $name));
        $row = $query->fetch();
        if($row){
            $value = 1;
            return $value;
        }
        return null;
    }
    
    public static function authenticate($username, $password){
        $query = DB::connection()->prepare('SELECT * FROM Account WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array('username' => $username, 'password' => $password));
        $row = $query->fetch();
        if($row){
            $account = new Account(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'is_admin' => $row['is_admin']
            ));
            
            return $account;
        }else{
            return null;
        }
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Account (username, password, is_admin) VALUES (:username, :password, :is_admin) RETURNING id');
        $query->execute(array('username' => $this->username, 'password' => $this->password, 'is_admin' => $this->is_admin));
        $row = $query->fetch();
        $this->id = $row['id'];
        return $this->id;
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE Account SET (username, password, is_admin) = (:username, :password, :is_admin) WHERE id=:id');
        $query->execute(array('username' => $this->username, 'password' => $this->password, 'is_admin' => $this->is_admin, 'id' => $this->id));   
    }
    
    public function validate_name(){
        $errors = array();
        if(self::validate_empty_string($this->username)){
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if(self::validate_string_length($this->username, 3)){
            $errors[] = 'Nimen tulee olla vähintään kolme merkkiä pitkä!';
        }
        $user = self::find_name($this->username);
        if($user){
            $errors[] = 'Käyttäjänimi varattu!';
        }
        return $errors;
    }
    
    public function validate_password(){
        $errors = array();
        if(self::validate_empty_string($this->password)){
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }
        if(self::validate_string_length($this->password, 3)){
            $errors[] = 'Salasanan tulee olla vähintään kolme merkkiä pitkä!';
        }
        return $errors;
    }
    
    public function toggle_admin(){
        if($this->is_admin){
            $this->is_admin = 'false';
        }else{
            $this->is_admin = 'true';
        }
    }
    
    public static function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Account WHERE id=:id');
        $query2 = DB::connection()->prepare('DELETE FROM Errand WHERE user_id=:id');
        $query2->execute(array('id' => $id));
        $query->execute(array('id' => $id));
    }
}

