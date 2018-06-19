<?php
class User{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function findUserByEmail($email){
        $this->db->query("SELECT email,password FROM users WHERE email=:email");
        $this->db->bind(":email",$email);

        $row = $this->db->result();

        if($this->db->rowCount() > 0){
            return true;
        }else {
            return false;
        }
    }

    public function getUserById($user_id){
        $this->db->query("SELECT * FROM users WHERE id=:user_id");
        $this->db->bind(":user_id",$user_id);

        $row = $this->db->result();

        return $row;
    }

    public function register($data){
        $this->db->query("INSERT INTO users (name, email, password) VALUES(:name, :email, :password)");

        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":password", $data["password"]);

        if($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function login($email,$password){

        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(":email",$email);
        $row = $this->db->result();

        $hashed_password = $row->password;

        if(password_verify($password,$hashed_password)){
            $this->set_user_online($row->id);
            return $row;
        } else {
            return false;
        }
    }

    private function set_user_online($user_id){
        $this->db->query("INSERT INTO online_users (user_id) VALUES(:user_id)");
        $this->db->bind(":user_id", $user_id);
        $this->db->execute();
    }

    public function set_user_offline($user_id){
        $this->db->query("DELETE FROM online_users WHERE user_id = :user_id");
        $this->db->bind(":user_id", $user_id);
        $this->db->execute();
    }

    public function get_all_online_users(){
        $this->db->query("SELECT users.name,users.id FROM users,online_users WHERE users.id = online_users.user_id");
        $resultSet = $this->db->resultSet();
        return $resultSet;
    }


}