<?php
    //PDO DB Class handling all Database connectivity
    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $name = DB_NAME;

        private $db_handler;
        private $stmt;
        private $error;

        public function __construct(){
            $dns = "mysql:host=".$this->host.";dbname=".$this->name;

            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try{
                $this->db_handler = new PDO($dns,$this->user, $this->pass, $options);
            } catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        public function query($sql){
            $this->stmt = $this->db_handler->prepare($sql);
        }

        public function bind($param, $value, $type = NULL){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                    case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                    case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                    default:
                    $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param,$value,$type);
        }

        public function execute(){
            return $this->stmt->execute();
        }

        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function result(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }
?>