<?php
class Posts extends Controller{

    public function __construct(){
        if(!isLoggedIn()){
            redirect("users/login");
        }

        $this->postModel = $this->model("Post");
        $this->userModel = $this->model("User");
        $this->commentModel = $this->model("Comment");
    }

    public function index(){
        $posts = $this->postModel->getPosts();
        $data = [
            "posts" => $posts
        ];

        $this->view("posts/index", $data);
    }

    public function show($post_id){
        $post = $this->postModel->getPostById($post_id);
        $user = $this->userModel->getUserById($post->user_id);
        $comments = $this->commentModel->getCommentsByPostId($post_id);
        $data = [
            "post" => $post,
            "user" => $user,
            "comments" => $comments
        ];
        $this->view("posts/show", $data);
    }

    public function add(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "title" => trim($_POST["title"]),
                "body" => trim($_POST["body"]),
                "user_id" => $_SESSION["user_id"],
                "title_error" => "",
                "body_error" => ""
            ];

            if(empty($data["title"])){
                $data["title_error"] = "Please enter title";
            }

            if(empty($data["body"])){
                $data["body_error"] = "Please enter body";
            }

            if(empty($data["title_error"]) && empty($data["body_error"])){
                if($this->postModel->addPost($data)){
                    flash("post_message","Post added");
                    redirect("posts");
                }else {
                    die("alles kapott!");
                }
            } else {
                $this->view("posts/add",$data);
            }
        }else {
            $data = [
                "title" => "",
                "body" => "",
                "title_error" => "",
                "body_error" => ""
            ];
    
            $this->view("posts/add", $data);
        }
    }

    public function edit($post_id){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "title" => trim($_POST["title"]),
                "body" => trim($_POST["body"]),
                "user_id" => $_SESSION["user_id"],
                "post_id" => $post_id,
                "title_error" => "",
                "body_error" => ""
            ];

            if(empty($data["title"])){
                $data["title_error"] = "Please enter title";
            }

            if(empty($data["body"])){
                $data["body_error"] = "Please enter body";
            }

            if(empty($data["title_error"]) && empty($data["body_error"])){
                if($this->postModel->updatePost($data)){
                    flash("post_message","Post updated");
                    redirect("posts");
                }else {
                    die("alles kapott!");
                }
            } else {
                $this->view("posts/edit",$data);
            }
        }else {
            $post = $this->postModel->getPostById($post_id);

            if($post->user_id != $_SESSION["user_id"]){
                redirect("posts");
            }

            $data = [
                "post_id" => $post_id,
                "title" => $post->title,
                "body" => $post->body,
                "title_error" => "",
                "body_error" => ""
            ];

            $this->view("posts/edit", $data);
        }

    }

    public function delete($post_id){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $post = $this->postModel->getPostById($post_id);

            if($post->user_id != $_SESSION["user_id"]){
                redirect("posts");
            }

            if($this->postModel->deletePostById($post_id)){
                flash("post_message","Post removed!");
                redirect("posts");
            } else {
                die("something went wrong!");
            }

            redirect("posts");
        }else {
            redirect("posts");
        }
    }

}