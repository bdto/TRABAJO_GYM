<?php
class Conexion {
    private $host = 'localhost';
    private $dbname = 'gym2';
    private $username = 'root';
    private $password = '12345678';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Llamada al método para ejecutar la migración
            $this->runMigration();
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }

    // Método para ejecutar la migración
    private function runMigration() {
        $filePath = __DIR__ . '../modelo/migracion.sql';
        if (file_exists($filePath)) {
            $sql = file_get_contents($filePath);
            try {
                $this->conn->exec($sql);
                echo "Migración ejecutada correctamente.";
            } catch (PDOException $exception) {
                echo "Error al ejecutar la migración: " . $exception->getMessage();
            }
        } else {
            echo "Archivo de migración no encontrado.";
        }
    }
}
?>