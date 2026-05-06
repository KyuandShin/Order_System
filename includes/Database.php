<?php
class Database {
    // LOCAL XAMPP MYSQL CONFIG
    private $host = 'localhost';
    private $db_name = 'order_system';
    private $username = 'root';
    private $password = '';
    private $port = 3306;
    private $driver = 'mysql';

    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Auto-detect Render production environment
            if (isset($_SERVER['RENDER'])) {
                // RENDER POSTGRESQL CONFIG
                $this->host = getenv('DB_HOST');
                $this->db_name = getenv('DB_NAME');
                $this->username = getenv('DB_USER');
                $this->password = getenv('DB_PASS');
                $this->port = getenv('DB_PORT');
                $this->driver = 'pgsql';
            }

            $dsn = $this->driver . ":host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($this->driver === 'mysql') {
                $this->conn->exec("set names utf8");
            }
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
