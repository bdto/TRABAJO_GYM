<?php
class Admin {
    private $conn;
    public $id;
    public $usuario;
    public $password;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validarUsuario() {
        $query = "SELECT * FROM admins WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarUsuario() {
        $query = "INSERT INTO admins (ID_Admin, usuario, password) VALUES (:id, :usuario, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM admins";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM admins WHERE ID_Admin = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar() {
        $query = "UPDATE admins SET usuario = :usuario" .
                 (!empty($this->password) ? ", password = :password" : "") .
                 " WHERE ID_Admin = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':id', $this->id);
        if (!empty($this->password)) {
            $stmt->bindParam(':password', $this->password);
        }
        return $stmt->execute();
    }
}
?>