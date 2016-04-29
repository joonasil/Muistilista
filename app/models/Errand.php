<?php

class Errand extends BaseModel {
    public $id, $user_id, $description, $priority, $completed, $deadline;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_description', 'validate_priority');
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Errand');
        
        $query->execute();
        
        $rows = $query->fetchAll();
        $errands = array();
        
        foreach($rows as $row){
            $errands[] = new Errand(array(
                'id' => (int) $row['id'],
                'user_id' => (int) $row['user_id'],
                'description' => $row['description'],
                'priority' => (int) $row['priority'],
                'completed' => (boolean) $row['completed'],
                'deadline' => $row['deadline']
            ));
        }
        
        return $errands;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Errand WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $errand = new Errand(array(
                'id' => (int) $row['id'],
                'user_id' => (int) $row['user_id'],
                'description' => $row['description'],
                'priority' => (int) $row['priority'],
                'completed' => (boolean) $row['completed'],
                'deadline' => $row['deadline']
            ));
            
            return $errand;
        }
        
        return null;
    }
    
    public static function all_user($id) {
        $query = DB::connection()->prepare('SELECT * FROM Errand WHERE user_id = :user ORDER BY priority');
        
        $query->execute(array('user' => $id));
        
        $rows = $query->fetchAll();
        $errands = array();
        
        if($rows){
            foreach($rows as $row){
                $errands[] = new Errand(array(
                    'id' => (int) $row['id'],
                    'user_id' => (int) $row['user_id'],
                    'description' => $row['description'],
                    'priority' => (int) $row['priority'],
                    'completed' => (boolean) $row['completed'],
                    'deadline' => $row['deadline']
                ));
            }

            return $errands;
        }
        return null;
    }
    
    public static function all_user_sublist($user, $list) {
        $query = DB::connection()->prepare('SELECT * FROM Errand,Categories WHERE user_id = :user AND Errand.id = Categories.errand_id AND Categories.category_id = :list ORDER BY priority');
        
        $query->execute(array('user' => $user, 'list' => $list));
        
        $rows = $query->fetchAll();
        $errands = array();
        
        if($rows){
            foreach($rows as $row){
                $errands[] = new Errand(array(
                    'id' => (int) $row['id'],
                    'user_id' => (int) $row['user_id'],
                    'description' => $row['description'],
                    'priority' => (int) $row['priority'],
                    'completed' => (boolean) $row['completed'],
                    'deadline' => $row['deadline']
                ));
            }

            return $errands;
        }
        return null;
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Errand (user_id, description, priority, deadline) VALUES (:id, :description, :priority, :deadline) RETURNING id');
        $query->execute(array('id' => $_SESSION['user'], 'description' => $this->description, 'priority' => $this->priority, 'deadline' => $this->deadline));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update(){
        self::toggle();
        self::toggle();
        $query = DB::connection()->prepare('UPDATE Errand SET (user_id, description, priority,completed , deadline) = (:user_id, :description, :priority, :completed, :deadline) WHERE id=:id RETURNING id');
        $query->execute(array('user_id' => $_SESSION['user'],'description' => $this->description, 'priority' => $this->priority,'completed' => $this->completed, 'deadline' => $this->deadline, 'id' => $this->id));   
    }
    
    public static function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Errand WHERE id=:id');
        $query2 = DB::connection()->prepare('DELETE FROM Categories WHERE errand_id=:id');
        $query2->execute(array('id' => $id));
        $query->execute(array('id' => $id));
    }
    
    public function validate_description(){
        $errors = array();
        if(self::validate_empty_string($this->description)){
            $errors[] = 'Askare ei saa olla tyhjä!';
        }
        return $errors;
    }
    
    public function validate_priority(){
        $errors = array();
        if($this->priority < 0){
            $errors[] = 'Tärkeysaste ei saa olla negatiivinen!';
        }
        return $errors;
    }
    
    public function toggle(){
        if($this->completed){
            $this->completed = 'false';
        }else{
            $this->completed = 'true';
        }
    }
}
