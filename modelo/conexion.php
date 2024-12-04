<?php
class Conexion {
    private $host = 'localhost';
    private $dbname = 'gym2';
    private $username = 'root';
    private $password = '12345678';
    private $conn = null;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                error_log("Error de conexión: " . $exception->getMessage());
                throw new Exception("Error de conexión a la base de datos");
            }
        }
        return $this->conn;
    }

    public function query($sql, $params = []) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function close() {
        $this->conn = null;
    }
}

