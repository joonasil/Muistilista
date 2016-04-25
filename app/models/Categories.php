<?php

class Categories extends BaseModel {
    public $errand, $category;
    
    public function __construct($errand, $category) {
        $this->errand = $errand;
        $this->category = $category;
    } 
    
    public static function findAll($errand) {
        $query = DB::connection()->prepare('SELECT * FROM Categories WHERE errand_id = :errand');
        $query->execute(array('errand' => $errand));
        $rows = $query->fetchAll();
        $categories = array();
        if($rows){
            foreach ($rows as $row) {
                $categories[] = (int) $row['category_id'];
            }
            
            return $categories;
        }
        
        return null;
    }
    
    public static function find($errand, $category) {
        $query = DB::connection()->prepare('SELECT * FROM Categories WHERE errand_id = :errand AND category_id = :category LIMIT 1');
        $query->execute(array('errand' => $errand, 'category' => $category));
        $row = $query->fetch();
        
        if($row){
            return new Categories($row['errand_id'], $row['category_id']);
        }
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Categories (errand_id, category_id) VALUES (:errand, :category)');
        $query->execute(array('errand' => $this->errand, 'category' => $this->category));
    }
    
    public function delete($id){
        $query = DB::connection()->prepare('DELETE FROM Categories WHERE errand_id=:id');
        $query->execute(array('id' => $id));
    }
}
