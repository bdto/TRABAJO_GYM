<?php
session_start();

require_once '../modelo/conexion.php';
require_once '../modelo/usuarios.php';

class UsuariosController {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConnection();
    }

    public function login($usuario, $password) {
        try {
            $query = "SELECT * FROM administradores WHERE usuario = :usuario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['usuario'] = $row['usuario'];
                    $_SESSION['id_admin'] = $row['id_admin'];
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }

    public function registrarUsuario($datos) {
        try {
            $query = "INSERT INTO usuarios (nombre, apellido, telefono, genero, f_registro, estado) 
                      VALUES (:nombre, :apellido, :telefono, :genero, :f_registro, :estado)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':nombre', $datos['nombre']);
            $stmt->bindParam(':apellido', $datos['apellido']);
            $stmt->bindParam(':telefono', $datos['telefono']);
            $stmt->bindParam(':genero', $datos['genero']);
            $stmt->bindParam(':f_registro', $datos['f_registro']);
            $stmt->bindParam(':estado', $datos['estado']);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUsuarios() {
        try {
            $query = "SELECT * FROM usuarios";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUsuario($id) {
        try {
            $query = "SELECT * FROM usuarios WHERE id_cliente = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarUsuario($id, $datos) {
        try {
            $query = "UPDATE usuarios SET 
                      nombre = :nombre, 
                      apellido = :apellido, 
                      telefono = :telefono, 
                      genero = :genero, 
                      estado = :estado 
                      WHERE id_cliente = :id";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':nombre', $datos['nombre']);
            $stmt->bindParam(':apellido', $datos['apellido']);
            $stmt->bindParam(':telefono', $datos['telefono']);
            $stmt->bindParam(':genero', $datos['genero']);
            $stmt->bindParam(':estado', $datos['estado']);
            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }
}

// Manejo de solicitudes
$controller = new UsuariosController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($action) {
        case 'login':
            if (isset($_POST['usuario']) && isset($_POST['password'])) {
                $result = $controller->login($_POST['usuario'], $_POST['password']);
                $response = ['success' => $result, 'message' => $result ? 'Login exitoso' : 'Credenciales incorrectas'];
            }
            break;
        case 'registrar':
            if (isset($_POST['datos']) && is_array($_POST['datos'])) {
                $result = $controller->registrarUsuario($_POST['datos']);
                $response = ['success' => $result !== false, 'id' => $result, 'message' => $result ? 'Usuario registrado con éxito' : 'Error al registrar usuario'];
            }
            break;
        case 'actualizar':
            if (isset($_POST['id']) && isset($_POST['datos']) && is_array($_POST['datos'])) {
                $result = $controller->actualizarUsuario($_POST['id'], $_POST['datos']);
                $response = ['success' => $result, 'message' => $result ? 'Usuario actualizado con éxito' : 'Error al actualizar usuario'];
            }
            break;
    }

    echo json_encode($response);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($action) {
        case 'obtenerTodos':
            $usuarios = $controller->obtenerUsuarios();
            $response = ['success' => $usuarios !== false, 'data' => $usuarios, 'message' => $usuarios ? 'Usuarios obtenidos con éxito' : 'Error al obtener usuarios'];
            break;
        case 'obtenerUno':
            if (isset($_GET['id'])) {
                $usuario = $controller->obtenerUsuario($_GET['id']);
                $response = ['success' => $usuario !== false, 'data' => $usuario, 'message' => $usuario ? 'Usuario obtenido con éxito' : 'Error al obtener usuario'];
            }
            break;
    }

    echo json_encode($response);
}
?>