<?php
class Api extends Controller{

    public function __construct(){
        $this->userModel = $this->model("User");
        $this->chatModel = $this->model("Chat");
    }

    public function index(){
        echo "For further instructions on how to use the API contact the site owner: puxn@gmx.de";
    }

    public function get_online_users(){
        $res = $this->userModel->get_all_online_users();
        header('Content-Type: application/json');
        echo json_encode($res);
    }

    public function get_messages(){
        if(isLoggedIn()){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $sender = $_POST["sender"];
            $receiver = $_POST["receiver"];
    
            $messages = $this->chatModel->getChatLog($sender,$receiver);
            header('Content-Type: application/json');
            echo json_encode($messages);
        }else {
            echo "please login to use chat features!";
        }

    }

    public function send_message(){
        if(isLoggedIn()){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $sender = $_POST["sender"];
            $receiver = $_POST["receiver"];
            $msg = $_POST["msg"];
    
            if($this->chatModel->storeMessage($sender,$receiver,$msg)){
                echo "hat geklappt :)"; //TODO: EDIT!
            }else {
                die("something went wrong!");
            }
        }

    }
}