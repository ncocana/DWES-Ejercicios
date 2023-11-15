<?php
// used to get postgresql database connection
class Database{
    private $host = "randion.es";
    private $db_name = "ncocana_db_agenda";
    private $username = "ncocana";
    private $password = "Secretos.2023";
    public $conn;
    // get the database connection
    public function getConnection(){
        if ($this->conn == null){
            try{
                $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
        }
        return $this->conn;
    }
}
?>
