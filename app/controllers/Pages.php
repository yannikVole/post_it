<?php
class Pages extends Controller{


    public function __construct(){
        //Load Models in here!
    }

    public function index(){
        if(isLoggedIn()){
            redirect("posts");
        }
        $data = [
            "title" => "SharePosts",
            "description" => "Simple social network built on my custom MVC framework"
        ];

        

        $this->view("pages/index", $data);
    }

    public function about(){
        $data = [
            "title" => "About",
            "description" => "App to share posts with other users"
        ];

        $this->view("pages/about",$data);
    }
}