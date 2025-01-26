<?php
require_once __DIR__ . '/../modelo/conexion.php';

class PagosController {
    private $db;

    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->getConnection();
    }

    public function registrarPago($datos) {
        $query = "INSERT INTO pagos (id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado, fecha_pago, medio_pago) 
                  VALUES (:id_cliente, :id_admin, :tipo_subscripcion, :precio, :duracion, :estado, :fecha_pago, :medio_pago)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_cliente', $datos['id_cliente']);
            $stmt->bindParam(':id_admin', $datos['id_admin']);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion']);
            $stmt->bindParam(':precio', $datos['precio']);
            $stmt->bindParam(':duracion', $datos['duracion']);
            $stmt->bindParam(':estado', $datos['estado']);
            $stmt->bindParam(':fecha_pago', $datos['fecha_pago']);
            $stmt->bindParam(':medio_pago', $datos['medio_pago']);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Pago registrado con éxito'];
            } else {
                return ['success' => false, 'message' => 'Error al registrar el pago'];
            }
        } catch (PDOException $e) {
            error_log('Error en registrarPago: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error al registrar el pago: ' . $e->getMessage()];
        }
    }

    public function actualizarPago($id_pagos, $datos) {
        $query = "UPDATE pagos SET id_cliente = :id_cliente, id_admin = :id_admin, tipo_subscripcion = :tipo_subscripcion, 
                  precio = :precio, duracion = :duracion, estado = :estado, fecha_pago = :fecha_pago, medio_pago = :medio_pago 
                  WHERE id_pagos = :id_pagos";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_pagos', $id_pagos);
            $stmt->bindParam(':id_cliente', $datos['id_cliente']);
            $stmt->bindParam(':id_admin', $datos['id_admin']);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion']);
            $stmt->bindParam(':precio', $datos['precio']);
            $stmt->bindParam(':duracion', $datos['duracion']);
            $stmt->bindParam(':estado', $datos['estado']);
            $stmt->bindParam(':fecha_pago', $datos['fecha_pago']);
            $stmt->bindParam(':medio_pago', $datos['medio_pago']);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Pago actualizado con éxito'];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar el pago'];
            }
        } catch (PDOException $e) {
            error_log('Error en actualizarPago: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar el pago: ' . $e->getMessage()];
        }
    }

    public function obtenerPago($id_pagos) {
        $query = "SELECT * FROM pagos WHERE id_pagos = :id_pagos";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_pagos', $id_pagos);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error en obtenerPago: ' . $e->getMessage());
            return null;
        }
    }

    public function obtenerPagosPorMes($month, $year) {
        $query = "SELECT * FROM pagos WHERE MONTH(fecha_pago) = :month AND YEAR(fecha_pago) = :year";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error en obtenerPagosPorMes: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerEstadisticasPagos() {
        try {
            // Total recaudado
            $queryTotal = "SELECT SUM(precio) as total FROM pagos WHERE estado = 'pagado'";
            $stmtTotal = $this->db->query($queryTotal);
            $totalRecaudado = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // Pagos del mes actual
            $currentMonth = date('m');
            $currentYear = date('Y');
            $queryMes = "SELECT COUNT(*) as count FROM pagos WHERE MONTH(fecha_pago) = :month AND YEAR(fecha_pago) = :year";
            $stmtMes = $this->db->prepare($queryMes);
            $stmtMes->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $stmtMes->bindParam(':year', $currentYear, PDO::PARAM_INT);
            $stmtMes->execute();
            $pagosMes = $stmtMes->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            // Pagos pendientes
            $queryPendientes = "SELECT COUNT(*) as count FROM pagos WHERE estado = 'pendiente'";
            $stmtPendientes = $this->db->query($queryPendientes);
            $pagosPendientes = $stmtPendientes->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            return [
                'total_recaudado' => $totalRecaudado,
                'pagos_mes' => $pagosMes,
                'pagos_pendientes' => $pagosPendientes
            ];
        } catch (PDOException $e) {
            error_log('Error en obtenerEstadisticasPagos: ' . $e->getMessage());
            return [
                'total_recaudado' => 0,
                'pagos_mes' => 0,
                'pagos_pendientes' => 0
            ];
        }
    }

    public function obtenerNombreCliente($id_cliente) {
        $query = "SELECT CONCAT(nombre, ' ', apellido) as nombre_completo FROM usuarios WHERE id_cliente = :id_cliente";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['nombre_completo'] ?? 'Cliente no encontrado';
        } catch (PDOException $e) {
            error_log('Error en obtenerNombreCliente: ' . $e->getMessage());
            return 'Error al obtener el nombre del cliente';
        }
    }
}
?>

