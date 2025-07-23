<?php
// config/koneksi.php

class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $database = 'sistem_jadwal';
    private $charset = 'utf8mb4';

    private function __construct() {
        $this->connect();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            die(json_encode([
                'success' => false,
                'message' => 'Database connection failed'
            ]));
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}

// Create connection instance
$database = Database::getInstance();
$conn = $database->getConnection(); // Now $conn is available globally
?>