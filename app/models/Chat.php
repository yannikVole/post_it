<?php

class Chat {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getChatLog($sender,$receiver){
        $this->db->query("SELECT 
        (SELECT
                name
            FROM 
                users
            WHERE
                id = chat_messages.sender
        ) AS Sender,
        (SELECT
                name
            FROM 
                users
            WHERE
                id = chat_messages.receiver
        ) AS Receiver,
        message AS Message, id
    FROM
        chat_messages
    WHERE 
    (chat_messages.sender = :sender
    AND chat_messages.receiver = :receiver)
    OR (chat_messages.sender = :receiver
    AND chat_messages.receiver = :sender)
    ORDER BY chat_messages.created_at DESC
    LIMIT 15");

        $this->db->bind(":sender",$sender);
        $this->db->bind(":receiver",$receiver);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function storeMessage($sender,$receiver,$msg){
        $this->db->query("INSERT INTO chat_messages (sender,receiver,message) VALUES (:sender,:receiver,:message)");

        $this->db->bind(":sender",$sender);
        $this->db->bind(":receiver",$receiver);
        $this->db->bind(":message",$msg);
        
        if($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}