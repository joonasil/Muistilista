<?php

class ErrandController extends BaseController{
    public static function index(){
        $errands = Errand::all();
        $categories = Category::all();
        View::make('app/list.html', array('errands' => $errands, 'categories' => $categories));
    }
    
    public static function edit($id){
        $errand = Errand::find($id);
        $categories = Category::all();
        View::make('app/edit.html', array('errand' => $errand, 'categories' => $categories));
    }
    
    public static function add(){
        $categories = Category::all();
        
        View::make('app/add.html', array('categories' => $categories));
    }
    
    public static function store(){
        $params = $_POST;
        
        //laita tähän user_id session avulla!
        $errand = new Errand(array(
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        ));
        
        $errand->save();
        $id = $errand->id;
        //korjaa!!
        if($params) {
        $categories = $params['categories'];
            foreach ($categories as $category) {
                $temp = new Categories($id, $category);
                $temp->save();
            }
        }
        Redirect::to('/list', array('message' => 'Askare lisätty muistilistalle!'));
    }
    
    public static function update($id){
        $params = $_POST;
        
        //laita tähän user_id session avulla!
        $errand = new Errand(array(
            'id' => $id,
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        ));
        
        $errand->update();
        $id = $errand->id;
        //korjaa!!
        if($params) {
        $categories = $params['categories'];
            foreach ($categories as $category) {
                $temp = new Categories($id, $category);
                $temp->save();
            }
        }
        Redirect::to('/list', array('message' => 'Askare lisätty muistilistalle!'));
    }
    
    public static function delete($id){
        Errand::delete($id);
        Redirect::to('/list', array('message' => 'Askare poistettu onnistuneesti!'));
    }
}
