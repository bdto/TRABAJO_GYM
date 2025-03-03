<?php
require_once __DIR__ . '/../modelo/pagos.php';

class PagosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Pagos();
    }

    public function registrarPago($datos) {
        if (!$this->validarDatosPago($datos)) {
            return ['success' => false, 'message' => 'Datos de pago inválidos'];
        }

        $resultado = $this->modelo->registrarPago($datos);
        if ($resultado) {
            return ['success' => true, 'message' => 'Pago registrado con éxito', 'id' => $resultado];
        } else {
            $error = $this->modelo->getLastError();
            return ['success' => false, 'message' => 'Error al registrar el pago: ' . $error];
        }
    }

    public function actualizarPago($id_pagos, $datos) {
        if (!$this->validarDatosPago($datos)) {
            return ['success' => false, 'message' => 'Datos de pago inválidos'];
        }

        // Si el tipo de suscripción no es duo_combo_x2, asegurarse de que id_cliente_adicional sea null
        if ($datos['tipo_subscripcion'] !== 'duo_combo_x2') {
            $datos['id_cliente_adicional'] = null;
        }

        $resultado = $this->modelo->actualizarPago($id_pagos, $datos);
        return $resultado;
    }

    public function obtenerPago($id_pagos) {
        $pago = $this->modelo->obtenerPago($id_pagos);
        if ($pago) {
            return ['success' => true, 'pago' => $pago];
        } else {
            return ['success' => false, 'message' => 'Pago no encontrado'];
        }
    }

    public function obtenerPagosPorMes($month, $year) {
        return $this->modelo->obtenerPagosPorMes($month, $year);
    }

    public function obtenerEstadisticasPagos() {
        return [
            'total_recaudado' => $this->modelo->obtenerTotalRecaudado(),
            'pagos_mes' => $this->modelo->obtenerPagosMes(),
            'pagos_pendientes' => $this->modelo->obtenerPagosPendientes()
        ];
    }

    public function obtenerEstadisticasPorMes($mes, $año) {
        $estadisticas = $this->modelo->obtenerEstadisticasPorMes($mes, $año);
        
        error_log("Controlador - Estadísticas para $mes/$año: " . print_r($estadisticas, true));
        
        return $estadisticas;
    }

    public function obtenerNombreCliente($id_cliente) {
        return $this->modelo->obtenerNombreCliente($id_cliente);
    }

    public function obtenerInfoCliente($id_cliente) {
        return $this->modelo->obtenerInfoCliente($id_cliente);
    }

    public function exportarPagosExcel($month, $year) {
        $pagos = $this->obtenerPagosPorMes($month, $year);
        // Aquí iría la lógica para generar el archivo Excel
        // Por ahora, solo retornamos los datos
        return [
            'success' => true,
            'data' => $pagos,
            'filename' => "pagos_$year-$month.xlsx"
        ];
    }

    public function buscarPagos($termino) {
        return $this->modelo->buscarPagos($termino);
    }

    private function validarDatosPago($datos) {
        $camposRequeridos = ['id_cliente', 'id_admin', 'tipo_subscripcion', 'precio', 'duracion', 'estado', 'fecha_pago', 'medio_pago'];
        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo]) || empty($datos[$campo])) {
                return false;
            }
        }

        if (!is_numeric($datos['precio']) || $datos['precio'] <= 0) {
            return false;
        }

        if (!in_array($datos['estado'], ['pendiente', 'pagado'])) {
            return false;
        }

        if (!$this->modelo->adminIdExists($datos['id_admin'])) {
            return false;
        }

        if (!$this->modelo->clienteExists($datos['id_cliente'])) {
            return false;
        }

        // Validar cliente adicional solo si es duo_combo_x2
        if ($datos['tipo_subscripcion'] === 'duo_combo_x2') {
            if (empty($datos['id_cliente_adicional'])) {
                return false;
            }
            if (!$this->modelo->clienteExists($datos['id_cliente_adicional'])) {
                return false;
            }
        } else {
            // Para otros tipos de suscripción, asegurarse de que id_cliente_adicional sea null
            $datos['id_cliente_adicional'] = null;
        }

        return true;
    }

    public function generarReporteMensual($month, $year) {
        $pagos = $this->obtenerPagosPorMes($month, $year);
        $totalRecaudado = array_sum(array_column($pagos, 'precio'));
        $pagosPendientes = count(array_filter($pagos, function($pago) {
            return $pago['estado'] == 'pendiente';
        }));

        return [
            'mes' => $month,
            'anio' => $year,
            'total_pagos' => count($pagos),
            'total_recaudado' => $totalRecaudado,
            'pagos_pendientes' => $pagosPendientes,
            'detalle_pagos' => $pagos
        ];
    }

    public function obtenerTendenciasPagos($meses = 6) {
        $tendencias = [];
        $mesActual = date('n');
        $anioActual = date('Y');

        for ($i = 0; $i < $meses; $i++) {
            $mes = $mesActual - $i;
            $anio = $anioActual;
            if ($mes <= 0) {
                $mes += 12;
                $anio--;
            }
            $pagos = $this->obtenerPagosPorMes($mes, $anio);
            $totalMes = array_sum(array_column($pagos, 'precio'));
            $tendencias[] = [
                'mes' => $mes,
                'anio' => $anio,
                'total' => $totalMes,
                'cantidad_pagos' => count($pagos)
            ];
        }

        return array_reverse($tendencias);
    }

    public function notificarPagosPendientes() {
        $pagosPendientes = $this->modelo->obtenerPagosPendientes();
        foreach ($pagosPendientes as $pago) {
            // Aquí iría la lógica para enviar notificaciones
            // Por ejemplo, enviar un email al cliente
            $this->enviarNotificacionPago($pago);
        }
        return count($pagosPendientes);
    }

    private function enviarNotificacionPago($pago) {
        // Simulación de envío de notificación
        $nombreCliente = $this->obtenerNombreCliente($pago['id_cliente']);
        $mensaje = "Estimado/a $nombreCliente, le recordamos que tiene un pago pendiente de $" . $pago['precio'];
        error_log("Notificación enviada a " . $pago['id_cliente'] . ": " . $mensaje);
        // Aquí iría el código real para enviar un email o SMS
    }
}
?>

