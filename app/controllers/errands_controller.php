<?php

class ErrandController extends BaseController{
    public static function index(){
        $errands = Errand::all();
        
        View::make('app/list.html', array('errands' => $errands));
    }
    
    public static function edit($id){
        $errand = Errand::find($id);
        
        View::make('app/edit.html', array('errand' => $errand));
    }
    
    public static function store(){
        $params = $_POST;
        
        $errand = new Errand(array(
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        ));
        
        $errand->save();
        
        Redirect::to('/list', array('message' => 'Askare lisätty muistilistalle!'));
    }
}
