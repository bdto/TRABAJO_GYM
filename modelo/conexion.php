<?php
class Conexion {
    private $host = 'localhost';
    private $dbname = 'gym2';
    private $username = 'root';
    private $password = '12345678';
    private $conn = null;

    public function getConnection() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $exception) {
            throw new Exception("Error de conexión: " . $exception->getMessage());
        }
    }

    public function query($sql) {
        if ($this->conn === null) {
            throw new Exception("No se puede ejecutar la consulta: conexión no establecida.");
        }

        try {
            return $this->conn->query($sql);
        } catch (PDOException $exception) {
            throw new Exception("Error al ejecutar la consulta: " . $exception->getMessage());
        }
    }

    public function close() {
        $this->conn = null;
    }
}
?>