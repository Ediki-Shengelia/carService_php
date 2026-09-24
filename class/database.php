<?php


date_default_timezone_set("Asia/Tbilisi");

require_once __DIR__ . '/../includes/config.php';

class Database
{
    public $conn;
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $name = DB_NAME;
    private $port = DB_PORT;
    public function open_db_connection()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->name};port={$this->port}";
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Connection Failed " . $exception->getMessage());
        }
    }
    public function __construct()
    {
        $this->open_db_connection();
    }
    public function prepare($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    public function the_insert_id()
    {
        return $this->conn->lastInsertId();
    }
}
$database = new Database();
