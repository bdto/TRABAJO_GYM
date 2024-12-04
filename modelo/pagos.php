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
            $query = "INSERT INTO pagos (id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado) 
                      VALUES (:id_cliente, :id_admin, :tipo_subscripcion, :precio, :duracion, :estado)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_admin', $datos['id_admin'], PDO::PARAM_INT);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':duracion', $datos['duracion'], PDO::PARAM_STR);
            $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);

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
                      duracion = :duracion, estado = :estado WHERE id_pagos = :id_pagos";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id_pagos', $id, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_admin', $datos['id_admin'], PDO::PARAM_INT);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':duracion', $datos['duracion'], PDO::PARAM_STR);
            $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar el pago: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPagos() {
        try {
            $query = "SELECT * FROM pagos ORDER BY id_pagos DESC";
            $result = $this->conn->query($query);
            return $result->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener pagos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerNombreCliente($id_cliente) {
        try {
            $query = "SELECT nombre FROM usuarios WHERE id = :id_cliente";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado['nombre'];
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
}