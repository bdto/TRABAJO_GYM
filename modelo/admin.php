<?php
require_once 'conexion.php';  // Incluye el archivo de conexión

class Admin {
    private $conn;
    public $id;
    public $usuario;
    public $password;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar el usuario
    public function validarUsuario() {
        $query = "SELECT * FROM admins WHERE ID_Admin = :ID_Admin LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ID_Admin', $this->id);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifica la contraseña
        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario() {
        $query = "INSERT INTO admins (ID_Admin, nombre, password) VALUES (:ID_Admin, :nombre, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind de los parámetros
        $stmt->bindParam(':ID_Admin', $this->id);
        $stmt->bindParam(':nombre', $this->usuario);
        $stmt->bindParam(':password', $this->password);
        
        // Ejecuta la inserción
        return $stmt->execute();
    }
}

// Ejemplo de uso:
$database = new Conexion();  // Instancia la conexión
$db = $database->getConnection();  // Obtiene la conexión

$admin = new Admin($db);  // Instancia Admin con la conexión

// Configura los datos del usuario
$admin->id = 1;
$admin->password = 'contraseña123';

// Llama al método para validar el usuario
if ($admin->validarUsuario()) {
    echo "Usuario válido.";
} else {
    echo "Credenciales incorrectas.";
}
?>