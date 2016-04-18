<?php

class Category extends BaseModel {
    public $id, $name;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Category');
        
        $query->execute();
        
        $rows = $query->fetchAll();
        $categories = array();
        
        foreach($rows as $row){
            $categories[] = new Category(array(
                'id' => (int) $row['id'],
                'name' => $row['category_name']      
            ));
        }
        
        return $categories;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $category = new Category(array(
                'id' => (int) $row['id'],
                'name' => $row['category_name']
            ));
            
            return $category;
        }
        
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Category (category_name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}
