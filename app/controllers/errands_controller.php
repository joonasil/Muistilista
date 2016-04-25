<?php

class ErrandController extends BaseController{
    public static function index(){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $errands = Errand::all_user($user->id);
        $categories = Category::find_user($user->id);
        View::make('app/list.html', array('errands' => $errands, 'categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function subindex($list){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $errands = Errand::all_user_sublist($user->id, $list);
        $categories = Category::find_user($user->id);
        View::make('app/list.html', array('errands' => $errands, 'categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function edit($id){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $errand = Errand::find($id);
        $categories = Category::find_user($user->id);
        View::make('app/edit.html', array('errand' => $errand, 'categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function add(){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $categories = Category::find_user($user->id);
        View::make('app/add.html', array('categories' => $categories, 'user_logged_in' => $user));
    }
    
    public static function add_category(){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        View::make('app/category.html', array('user_logged_in' => $user));
    }
    
    public static function save_category(){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $params = $_POST;
        
        $category = new Category(array(
            'name' => $params['name'],
            'user_id' => $user->id
        ));
        $errors = $category->errors();
        if(count($errors) == 0){
            $category->save();
            Redirect::to('/list', array('message' => 'Luokka lisätty!'));
        }
        View::make('app/category.html', array('errors' => $errors, 'user_logged_in' => $user));
    }
    
    public static function store(){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $params = $_POST;
        
        $errand = new Errand(array(
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        ));
        
        $errors = $errand->errors();
        if(count($errors) == 0){
            $errand->save();
            $id = $errand->id;

            if(array_key_exists('categories', $params)) {
            $categories = $params['categories'];
                foreach ($categories as $category) {
                    $temp = new Categories($id, $category);
                    $temp->save();
                }
            }
            Redirect::to('/list', array('message' => 'Askare lisätty muistilistalle!', 'user_logged_in' => $user));
        }
        $categories = Category::find_user();
        View::make('app/add.html', array('categories' => $categories, 'errors' => $errors, 'user_logged_in' => $user));
    }
    
    public static function update($id){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $params = $_POST;
        $old = Errand::find($id)->completed;
        $errand = new Errand(array(
            'id' => $id,
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline'],
            'completed' => $old
        ));
        $errors = $errand->errors();
        if(count($errors) == 0){
            $id = $errand->id;
            Categories::delete($id);
            $errand->update();
         
            if(array_key_exists('categories', $params)) {
            $categories = $params['categories'];
                foreach ($categories as $category) {
                    $temp = new Categories($id, $category);           
                    $temp->save();   
                }
            }
            Redirect::to('/list', array('message' => 'Askare muokattu!', 'user_logged_in' => $user));
        }
        $categories = Category::find_user($user->id);
        View::make('app/edit.html', array('categories' => $categories, 'errors' => $errors, 'user_logged_in' => $user));
    }
    
    public static function delete($id){
        self::check_logged_in();
        Errand::delete($id);
        $user = self::get_user_logged_in();
        Redirect::to('/list', array('message' => 'Askare poistettu onnistuneesti!', 'user_logged_in' => $user));
    }
    
    public static function toggle($id){
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $errand = Errand::find($id);
        $errand->toggle();
        $errand->update();
        Redirect::to('/list', array('user_logged_in' => $user));
    }
}
