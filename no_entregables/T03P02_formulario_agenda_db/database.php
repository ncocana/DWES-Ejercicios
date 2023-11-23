<?php
// used to get postgresql database connection
class Database {
    private const HOST = "randion.es";
    private const DB_NAME = "ncocana_db_agenda";
    private const USERNAME = "ncocana";
    private const PASSWORD = "Secretos.2023";
    private static $conn;

    // Protected construct.
    protected function __construct() {}

    // Singletons should not be clonable.
    private function __clone() {}

    // get the database connection
    public static function getConnection() {
        if (!isset(self::$conn)){
            try{
                self::$conn = new PDO("pgsql:host=" . self::HOST . ";dbname=" . self::DB_NAME, self::USERNAME, self::PASSWORD);
            } catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            } catch(Exception $exception){
                echo "Unknown exception: " . $exception->getMessage();
            }
        }
        return self::$conn;
    }
}
?>
