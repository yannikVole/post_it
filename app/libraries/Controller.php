<?php
//base controller which will be inherited by every other controller
//loads models and views
class Controller{
    public function model($model){
        //get model file
        require_once "../app/models/".$model.".php";

        //instantiate model
        return new $model();

    }

    public function view($view, $data = []){
        if(file_exists("../app/views/".$view.".php")){
            require_once "../app/views/".$view.".php";
        }else {
            die("View does not exist!");
        }
    }
}