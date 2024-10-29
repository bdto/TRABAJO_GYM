<?php
class Usuario {
    private $conn;
    public $id;
    public $usuario;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function validarUsuario() {
        $query = "SELECT * FROM admins WHERE ID_Admin = :ID_Admin AND password = :password LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ID_Admin', $this->usuario);
        $stmt->bindParam(':nombre', $this->usuario);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarUsuario() {
        $query = "INSERT INTO admins (ID_Admin, nombre , password) VALUES (:ID_Admin, :nombre, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':ID_Admin', $this->id);
        $stmt->bindParam(':nombre', $this->usuario);
        $stmt->bindParam(':password', $this->password);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>