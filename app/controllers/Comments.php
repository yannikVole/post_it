<?php
class Comments extends Controller{

    public function __construct(){
        $this->commentModel = $this->model("Comment");
    }

    public function add(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isLoggedIn()){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

                $post_id = $_GET["post_id"];
                $body = $_POST["comment_body"];
                $user_id = $_SESSION["user_id"];

                if($this->commentModel->addComment($post_id, $user_id, $body)){
                    redirect("posts/show/".$post_id);
                } else {
                    die("something went wrong!");
                }
            } else {
                redirect("posts/show");
            }
        }
    }
}