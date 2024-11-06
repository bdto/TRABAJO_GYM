<?php
session_start();

require_once '../modelo/conexion.php';
require_once '../modelo/pagos.php';

class PagosController {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConnection();
    }

    public function registrarPago($datos) {
        try {
            $query = "INSERT INTO pagos (id_pagos, id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado) 
                      VALUES (:id_pagos, :id_cliente, :id_admin, :tipo_subscripcion, :precio, :duracion, :estado)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id_pagos', $datos['id_pagos']);
            $stmt->bindParam(':id_cliente', $datos['id_cliente']);
            $stmt->bindParam(':id_admin', $datos['id_admin']);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion']);
            $stmt->bindParam(':precio', $datos['precio']);
            $stmt->bindParam(':duracion', $datos['duracion']);
            $stmt->bindParam(':estado', $datos['estado']);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al registrar pago: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPagos() {
        try {
            $query = "SELECT * FROM pagos";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener pagos: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPago($id) {
        try {
            $query = "SELECT * FROM pagos WHERE id_pagos = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener pago: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarPago($id, $datos) {
        try {
            $query = "UPDATE pagos SET 
                      id_cliente = :id_cliente, 
                      id_admin = :id_admin, 
                      tipo_subscripcion = :tipo_subscripcion, 
                      precio = :precio, 
                      duracion = :duracion, 
                      estado = :estado 
                      WHERE id_pagos = :id";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id_cliente', $datos['id_cliente']);
            $stmt->bindParam(':id_admin', $datos['id_admin']);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion']);
            $stmt->bindParam(':precio', $datos['precio']);
            $stmt->bindParam(':duracion', $datos['duracion']);
            $stmt->bindParam(':estado', $datos['estado']);
            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar pago: " . $e->getMessage());
            return false;
        }
    }
}

// Manejo de solicitudes
$controller = new PagosController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($action) {
        case 'registrar':
            if (isset($_POST['datos']) && is_array($_POST['datos'])) {
                $result = $controller->registrarPago($_POST['datos']);
                $response = ['success' => $result !== false, 'id' => $result, 'message' => $result ? 'Pago registrado con éxito' : 'Error al registrar pago'];
            }
            break;
        case 'actualizar':
            if (isset($_POST['id']) && isset($_POST['datos']) && is_array($_POST['datos'])) {
                $result = $controller->actualizarPago($_POST['id'], $_POST['datos']);
                $response = ['success' => $result, 'message' => $result ? 'Pago actualizado con éxito' : 'Error al actualizar pago'];
            }
            break;
    }

    echo json_encode($response);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($action) {
        case 'obtenerTodos':
            $pagos = $controller->obtenerPagos();
            $response = ['success' => $pagos !== false, 'data' => $pagos, 'message' => $pagos ? 'Pagos obtenidos con éxito' : 'Error al obtener pagos'];
            break;
        case 'obtenerUno':
            if (isset($_GET['id'])) {
                $pago = $controller->obtenerPago($_GET['id']);
                $response = ['success' => $pago !== false, 'data' => $pago, 'message' => $pago ? 'Pago obtenido con éxito' : 'Error al obtener pago'];
            }
            break;
    }

    echo json_encode($response);
}
?>