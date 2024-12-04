<?php
require_once '../modelo/pagos.php';

class PagosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Pagos();
    }

    public function obtenerPagos() {
        return $this->modelo->obtenerPagos();
    }


    public function obtenerNombreCliente($id_cliente) {
        return $this->modelo->obtenerNombreCliente($id_cliente);
    }


    public function obtenerPago($id) {
        return $this->modelo->obtenerPago($id);
    }

    public function registrarPago($datos) {
        // Validación de datos
        if (empty($datos['id_cliente']) || empty($datos['id_admin']) || empty($datos['tipo_subscripcion']) || 
            empty($datos['precio']) || empty($datos['duracion']) || empty($datos['estado'])) {
            return $this->respuestaJSON(false, 'Todos los campos son requeridos.');
        }

        $resultado = $this->modelo->registrarPago($datos);
        if ($resultado) {
            return $this->respuestaJSON(true, 'Pago registrado con éxito.', ['id' => $resultado]);
        } else {
            return $this->respuestaJSON(false, 'Error al registrar el pago.');
        }
    }

    public function actualizarPago($id, $datos) {
        // Validación de datos
        if (empty($id) || empty($datos['id_cliente']) || empty($datos['id_admin']) || empty($datos['tipo_subscripcion']) || 
            empty($datos['precio']) || empty($datos['duracion']) || empty($datos['estado'])) {
            return $this->respuestaJSON(false, 'Todos los campos son requeridos.');
        }

        $resultado = $this->modelo->actualizarPago($id, $datos);
        if ($resultado) {
            return $this->respuestaJSON(true, 'Pago actualizado con éxito.');
        } else {
            return $this->respuestaJSON(false, 'Error al actualizar el pago.');
        }
    }

    public function obtenerEstadisticasPagos() {
        $pagos = $this->obtenerPagos();
        $totalRecaudado = array_sum(array_column($pagos, 'precio'));
        $pagosMes = count(array_filter($pagos, function($p) {
            return date('Y-m', strtotime($p['fecha_pago'])) === date('Y-m');
        }));
        $pagosPendientes = count(array_filter($pagos, function($p) {
            return $p['estado'] === 'pendiente';
        }));

        return [
            'total_recaudado' => $totalRecaudado,
            'pagos_mes' => $pagosMes,
            'pagos_pendientes' => $pagosPendientes
        ];
    }

    // Changed from private to public
    public function respuestaJSON($success, $message, $data = null) {
        $response = [
            'success' => $success,
            'message' => $message
        ];
        if ($data !== null) {
            $response['data'] = $data;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new PagosController();
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'registrar':
                $controller->registrarPago($_POST);
                break;
            case 'actualizar':
                if (isset($_POST['id_pagos'])) {
                    $controller->actualizarPago($_POST['id_pagos'], $_POST);
                } else {
                    $controller->respuestaJSON(false, 'ID de pago no proporcionado.');
                }
                break;
            default:
                $controller->respuestaJSON(false, 'Acción no válida.');
        }
    } else {
        $controller->respuestaJSON(false, 'Acción no especificada.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtenerEstadisticas') {
    $controller = new PagosController();
    $estadisticas = $controller->obtenerEstadisticasPagos();
    $controller->respuestaJSON(true, 'Estadísticas obtenidas con éxito.', $estadisticas);
}