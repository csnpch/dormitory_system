<?php 

    abstract class Database {
        
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "db_dormitory_kmutnb_pri";
        protected $db; // is database connected -> for use short name

        public function __construct() {
            
            try {

                $this->db = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connection Success";
            } catch(PDOException $error) {
                echo "Connection Failed : " . $error->getMessage();
            }
            
        }
        
    }

?>
