<?php
require_once '../modelo/pagos.php';

class PagosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Pagos();
    }

    public function obtenerPagosPorMes($month, $year) {
        $pagos = $this->modelo->obtenerPagosPorMes($month, $year);
        if (empty($pagos)) {
            error_log("No se encontraron pagos para el mes $month y año $year");
        } else {
            error_log("Se encontraron " . count($pagos) . " pagos para el mes $month y año $year");
            foreach ($pagos as $pago) {
                error_log("Pago ID: {$pago['id_pagos']}, Estado: " . ($pago['estado'] ?? 'N/A'));
            }
        }
        return $pagos;
    }

    public function obtenerNombreCliente($id_cliente) {
        return $this->modelo->obtenerNombreCliente($id_cliente);
    }

    public function obtenerPago($id) {
        return $this->modelo->obtenerPago($id);
    }

    public function registrarPago($datos) {
        error_log("Datos recibidos en el controlador: " . print_r($datos, true));
        if (empty($datos['id_cliente']) || empty($datos['id_admin']) || empty($datos['tipo_subscripcion']) || 
            empty($datos['precio']) || empty($datos['duracion']) || !isset($datos['estado']) || empty($datos['fecha_pago'])) {
            error_log("Faltan campos requeridos en registrarPago");
            return ['success' => false, 'message' => 'Todos los campos son requeridos.'];
        }

        // Asegurarse de que el estado sea 'pendiente' o 'pagado'
        $datos['estado'] = in_array($datos['estado'], ['pendiente', 'pagado']) ? $datos['estado'] : 'pendiente';

        $resultado = $this->modelo->registrarPago($datos);
        if ($resultado) {
            error_log("Pago registrado con éxito en el controlador. ID: $resultado");
            return ['success' => true, 'message' => 'Pago registrado con éxito.'];
        } else {
            error_log("Error al registrar el pago en el controlador");
            return ['success' => false, 'message' => 'Error al registrar el pago.'];
        }
    }

    public function actualizarPago($id, $datos) {
        if (empty($id) || empty($datos['id_cliente']) || empty($datos['id_admin']) || empty($datos['tipo_subscripcion']) || 
            empty($datos['precio']) || empty($datos['duracion']) || empty($datos['estado']) || empty($datos['fecha_pago'])) {
            return ['success' => false, 'message' => 'Todos los campos son requeridos.'];
        }

        $resultado = $this->modelo->actualizarPago($id, $datos);
        if ($resultado['success']) {
            return ['success' => true, 'message' => 'Pago actualizado con éxito.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el pago: ' . $resultado['message']];
        }
    }

    public function obtenerEstadisticasPagos() {
        return [
            'total_recaudado' => $this->modelo->obtenerTotalRecaudado(),
            'pagos_mes' => $this->modelo->obtenerPagosMes(),
            'pagos_pendientes' => $this->modelo->obtenerPagosPendientes()
        ];
    }

    public function adminIdExists($id) {
        return $this->modelo->adminIdExists($id);
    }
}
?>
