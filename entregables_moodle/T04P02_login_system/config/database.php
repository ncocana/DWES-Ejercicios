<?php
// used to get postgresql database connection
class Database{
    private $host = "localhost";
    private $db_name = "ncocana_db_loginsystem";
    private $username = "ncocana";
    private $password = "Secretos.2023";
    public $conn;
    // get the database connection
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("postgresql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
