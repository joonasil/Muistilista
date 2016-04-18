<?php

class Errand extends BaseModel {
    public $id, $user_id, $description, $priority, $completed, $deadline;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Errand (user_id, description, priority, deadline) VALUES (1, :description, :priority, :deadline) RETURNING id');
        $query->execute(array('description' => $this->description, 'priority' => $this->priority, 'deadline' => $this->deadline));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE Errand SET (user_id, description, priority, deadline) = (1, :description, :priority, :deadline) WHERE id=:id RETURNING id');
        $query->execute(array('description' => $this->description, 'priority' => $this->priority, 'deadline' => $this->deadline, 'id' => $this->id));
//        $row = $query->fetch();
        
    }
    
    public static function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Errand WHERE id=:id');
        $query->execute(array('id' => $id)); 
    }
}
