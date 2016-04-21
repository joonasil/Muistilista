<?php

class ErrandController extends BaseController{
    public static function index(){
        self::check_logged_in();
        $errands = Errand::all_user();
        $categories = Category::all();
        $user = self::get_user_logged_in();
        View::make('app/list.html', array('errands' => $errands, 'categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function edit($id){
        self::check_logged_in();
        $errand = Errand::find($id);
        $categories = Category::all();
        $user = self::get_user_logged_in();
        View::make('app/edit.html', array('errand' => $errand, 'categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function add(){
        self::check_logged_in();
        $categories = Category::all();
        $user = self::get_user_logged_in();
        View::make('app/add.html', array('categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function store(){
        self::check_logged_in();
        $params = $_POST;
        
        //laita tähän user_id session avulla!
        $errand = new Errand(array(
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        ));
        $user = self::get_user_logged_in();
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
        Redirect::to('/list', array('message' => 'Askare lisätty muistilistalle!', 'user_logged_in' => $user));
    }
    
    public static function update($id){
        self::check_logged_in();
        $params = $_POST;
        
        //laita tähän user_id session avulla!
        $errand = new Errand(array(
            'id' => $id,
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        ));
        $user = self::get_user_logged_in();
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
        Redirect::to('/list', array('message' => 'Askare lisätty muistilistalle!', 'user_logged_in' => $user));
    }
    
    public static function delete($id){
        self::check_logged_in();
        Errand::delete($id);
        $user = self::get_user_logged_in();
        Redirect::to('/list', array('message' => 'Askare poistettu onnistuneesti!', 'user_logged_in' => $user));
    }
}
