<?php
session_start();

require_once '../modelo/conexion.php';
require_once '../modelo/admin.php';

class AdminController {
    private $conn;
    private $admin;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConnection();
        $this->admin = new Admin($this->conn);
    }

    public function login($usuario, $password) {
        if (empty($usuario) || empty($password)) {
            return ['success' => false, 'message' => 'Por favor, complete todos los campos.'];
        }

        $this->admin->usuario = $usuario;
        $this->admin->password = $password;

        $resultado = $this->admin->validarUsuario();

        if ($resultado) {
            $_SESSION['usuario'] = htmlspecialchars($resultado['nombre']);
            $_SESSION['id_admin'] = $resultado['ID_Admin'];
            return ['success' => true, 'message' => 'Login exitoso'];
        } else {
            return ['success' => false, 'message' => 'Credenciales incorrectas'];
        }
    }

    public function registrarAdmin($datos) {
        if (empty($datos['usuario']) || empty($datos['password'])) {
            return ['success' => false, 'message' => 'Por favor, complete todos los campos.'];
        }

        $this->admin->usuario = $datos['usuario'];
        $this->admin->password = password_hash($datos['password'], PASSWORD_DEFAULT);

        if ($this->admin->registrarUsuario()) {
            return ['success' => true, 'message' => 'Administrador registrado con éxito'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el administrador'];
        }
    }

    public function obtenerAdmins() {
        $admins = $this->admin->obtenerTodos();
        if ($admins) {
            return ['success' => true, 'data' => $admins];
        } else {
            return ['success' => false, 'message' => 'Error al obtener los administradores'];
        }
    }

    public function obtenerAdmin($id) {
        $admin = $this->admin->obtenerPorId($id);
        if ($admin) {
            return ['success' => true, 'data' => $admin];
        } else {
            return ['success' => false, 'message' => 'Administrador no encontrado'];
        }
    }

    public function actualizarAdmin($id, $datos) {
        if (empty($datos['usuario'])) {
            return ['success' => false, 'message' => 'El nombre de usuario no puede estar vacío.'];
        }

        $this->admin->id = $id;
        $this->admin->usuario = $datos['usuario'];
        if (!empty($datos['password'])) {
            $this->admin->password = password_hash($datos['password'], PASSWORD_DEFAULT);
        }

        if ($this->admin->actualizar()) {
            return ['success' => true, 'message' => 'Administrador actualizado con éxito'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el administrador'];
        }
    }
}

// Manejo de solicitudes
$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($action) {
        case 'login':
            if (isset($_POST['usuario']) && isset($_POST['password'])) {
                $response = $controller->login($_POST['usuario'], $_POST['password']);
            }
            break;
        case 'registrar':
            if (isset($_POST['datos']) && is_array($_POST['datos'])) {
                $response = $controller->registrarAdmin($_POST['datos']);
            }
            break;
        case 'actualizar':
            if (isset($_POST['id']) && isset($_POST['datos']) && is_array($_POST['datos'])) {
                $response = $controller->actualizarAdmin($_POST['id'], $_POST['datos']);
            }
            break;
    }

    echo json_encode($response);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($action) {
        case 'obtenerTodos':
            $response = $controller->obtenerAdmins();
            break;
        case 'obtenerUno':
            if (isset($_GET['id'])) {
                $response = $controller->obtenerAdmin($_GET['id']);
            }
            break;
    }

    echo json_encode($response);
}
?>