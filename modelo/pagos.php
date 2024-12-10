<?php
require_once 'conexion.php';

class Pagos {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConnection();
    }

    public function registrarPago($datos) {
        try {
            $query = "INSERT INTO pagos (id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado, fecha_pago) 
                      VALUES (:id_cliente, :id_admin, :tipo_subscripcion, :precio, :duracion, :estado, :fecha_pago)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_admin', $datos['id_admin'], PDO::PARAM_INT);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':duracion', $datos['duracion'], PDO::PARAM_INT);
            $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_pago', $datos['fecha_pago'], PDO::PARAM_STR);

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al registrar el pago: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarPago($id, $datos) {
    try {
        $query = "UPDATE pagos SET id_cliente = :id_cliente, id_admin = :id_admin, 
                  tipo_subscripcion = :tipo_subscripcion, precio = :precio, 
                  duracion = :duracion, estado = :estado, fecha_pago = :fecha_pago 
                  WHERE id_pagos = :id_pagos";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_pagos', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
        $stmt->bindParam(':id_admin', $datos['id_admin'], PDO::PARAM_INT);
        $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
        $stmt->bindParam(':duracion', $datos['duracion'], PDO::PARAM_INT);
        $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_pago', $datos['fecha_pago'], PDO::PARAM_STR);

        $result = $stmt->execute();
        
        if ($result) {
            return ['success' => true, 'message' => 'Pago actualizado correctamente'];
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Error SQL al actualizar el pago: " . $errorInfo[2]);
            return ['success' => false, 'message' => 'Error al actualizar el pago: ' . $errorInfo[2]];
        }
    } catch (PDOException $e) {
        error_log("Excepción al actualizar el pago: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error al actualizar el pago: ' . $e->getMessage()];
    }
}

    public function obtenerPagos() {
        try {
            $query = "SELECT * FROM pagos ORDER BY fecha_pago DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener pagos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPagosPorMes($month, $year) {
        try {
            $query = "SELECT * FROM pagos WHERE MONTH(fecha_pago) = :month AND YEAR(fecha_pago) = :year ORDER BY fecha_pago DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener pagos por mes: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerNombreCliente($id_cliente) {
        try {
            $query = "SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuarios WHERE id_cliente = :id_cliente";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado['nombre_completo'];
            } else {
                error_log("Cliente no encontrado para ID: " . $id_cliente);
                return 'Cliente no encontrado';
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el nombre del cliente: " . $e->getMessage());
            return 'Error al obtener el nombre';
        }
    }

    public function obtenerPago($id) {
        try {
            $query = "SELECT * FROM pagos WHERE id_pagos = :id_pagos";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_pagos', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener el pago: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerTotalRecaudado() {
        try {
            $query = "SELECT SUM(precio) as total FROM pagos";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error al obtener el total recaudado: " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerPagosMes() {
        try {
            $query = "SELECT COUNT(*) as total FROM pagos WHERE MONTH(fecha_pago) = MONTH(CURRENT_DATE()) AND YEAR(fecha_pago) = YEAR(CURRENT_DATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error al obtener los pagos del mes: " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerPagosPendientes() {
        try {
            $query = "SELECT COUNT(*) as total FROM pagos WHERE estado = 'pendiente'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error al obtener los pagos pendientes: " . $e->getMessage());
            return 0;
        }
    }
}
?>

