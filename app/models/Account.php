<?php

class Account extends BaseModel {
    public $id, $username, $password, $is_admin;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
    }
}

