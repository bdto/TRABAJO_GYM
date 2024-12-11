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

    public function obtenerPagosPorMes($month, $year) {
        return $this->modelo->obtenerPagosPorMes($month, $year);
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
            empty($datos['precio']) || empty($datos['duracion']) || empty($datos['estado']) || empty($datos['fecha_pago'])) {
            return ['success' => false, 'message' => 'Todos los campos son requeridos.'];
        }

        $resultado = $this->modelo->registrarPago($datos);
        if ($resultado) {
            return ['success' => true, 'message' => 'Pago registrado con éxito.'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el pago.'];
        }
    }

    public function actualizarPago($id, $datos) {
        // Validación de datos
        if (empty($id) || empty($datos['id_cliente']) || empty($datos['id_admin']) || empty($datos['tipo_subscripcion']) || 
            empty($datos['precio']) || empty($datos['duracion']) || empty($datos['estado']) || empty($datos['fecha_pago'])) {
            return ['success' => false, 'message' => 'Todos los campos son requeridos.'];
        }

        $resultado = $this->modelo->actualizarPago($id, $datos);
        if ($resultado) {
            return ['success' => true, 'message' => 'Pago actualizado con éxito.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el pago.'];
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
}

