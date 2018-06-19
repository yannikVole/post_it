<?php
class Comment{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function addComment($post_id, $user_id, $body){

        $this->db->query("INSERT INTO comments (user_id,post_id,body) VALUES(:user_id, :post_id, :body)");

        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":post_id", $post_id);
        $this->db->bind(":body", $body);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getCommentsByPostId($post_id){

        $this->db->query("SELECT comments.body,comments.created_at,users.name
                          FROM users,comments 
                          WHERE comments.post_id = :post_id
                          AND comments.user_id = users.id
                          ORDER BY comments.created_at DESC");

        $this->db->bind(":post_id", $post_id);

        $rows = $this->db->resultSet();
        
        return $rows;
    }
}