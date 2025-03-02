<?php
require_once 'conexion.php';

class Pagos {
    private $conn;
    private $lastError;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConnection();
    }

    public function obtenerPagosPorMes($month, $year) {
        try {
            $query = "SELECT p.id_pagos, p.id_cliente, p.id_admin, p.tipo_subscripcion, p.precio, p.duracion, 
                             p.estado, p.fecha_pago, p.medio_pago, p.id_cliente_adicional,
                             u1.nombre AS nombre_cliente, u1.apellido AS apellido_cliente,
                             u2.nombre AS nombre_cliente_adicional, u2.apellido AS apellido_cliente_adicional
                      FROM pagos p
                      LEFT JOIN usuarios u1 ON p.id_cliente = u1.id_cliente
                      LEFT JOIN usuarios u2 ON p.id_cliente_adicional = u2.id_cliente
                      WHERE MONTH(p.fecha_pago) = :month AND YEAR(p.fecha_pago) = :year 
                      ORDER BY p.fecha_pago DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Pagos obtenidos para $month/$year: " . count($result));
            return $result;
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

    public function obtenerInfoCliente($id_cliente) {
        try {
            $query = "SELECT id_cliente, nombre, apellido, email FROM usuarios WHERE id_cliente = :id_cliente";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener información del cliente: " . $e->getMessage());
            return null;
        }
    }

    public function registrarPago($datos) {
        try {
            // Start a transaction
            $this->conn->beginTransaction();

            // Check if id_cliente exists
            if (!$this->clienteExists($datos['id_cliente'])) {
                throw new Exception("El cliente principal no existe.");
            }

            // Check if id_cliente_adicional exists (if provided)
            if (!empty($datos['id_cliente_adicional'])) {
                if (!$this->clienteExists($datos['id_cliente_adicional'])) {
                    throw new Exception("El cliente adicional no existe.");
                }
            } else {
                // Set id_cliente_adicional to NULL if not provided
                $datos['id_cliente_adicional'] = null;
            }

            $query = "INSERT INTO pagos (id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado, fecha_pago, medio_pago, id_cliente_adicional) 
                      VALUES (:id_cliente, :id_admin, :tipo_subscripcion, :precio, :duracion, :estado, :fecha_pago, :medio_pago, :id_cliente_adicional)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id_cliente', $datos['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':id_admin', $datos['id_admin'], PDO::PARAM_INT);
            $stmt->bindParam(':tipo_subscripcion', $datos['tipo_subscripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':duracion', $datos['duracion'], PDO::PARAM_INT);
            $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_pago', $datos['fecha_pago'], PDO::PARAM_STR);
            $stmt->bindParam(':medio_pago', $datos['medio_pago'], PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente_adicional', $datos['id_cliente_adicional'], PDO::PARAM_INT);

            $stmt->execute();
            $lastInsertId = $this->conn->lastInsertId();

            // Commit the transaction
            $this->conn->commit();

            error_log("Pago registrado con éxito. ID: " . $lastInsertId);
            return $lastInsertId;
        } catch (Exception $e) {
            // Rollback the transaction on error
            $this->conn->rollBack();
            $this->lastError = $e->getMessage();
            error_log("Error al registrar el pago: " . $this->lastError);
            return false;
        }
    }

    public function actualizarPago($id, $datos) {
        try {
            $query = "UPDATE pagos SET id_cliente = :id_cliente, id_admin = :id_admin, 
                      tipo_subscripcion = :tipo_subscripcion, precio = :precio, 
                      duracion = :duracion, estado = :estado, fecha_pago = :fecha_pago, 
                      medio_pago = :medio_pago, id_cliente_adicional = :id_cliente_adicional 
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
            $stmt->bindParam(':medio_pago', $datos['medio_pago'], PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente_adicional', $datos['id_cliente_adicional'], PDO::PARAM_INT);

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

    public function obtenerPago($id) {
        try {
            $query = "SELECT p.*, u1.nombre AS nombre_cliente, u1.apellido AS apellido_cliente,
                             u2.nombre AS nombre_cliente_adicional, u2.apellido AS apellido_cliente_adicional
                      FROM pagos p
                      LEFT JOIN usuarios u1 ON p.id_cliente = u1.id_cliente
                      LEFT JOIN usuarios u2 ON p.id_cliente_adicional = u2.id_cliente
                      WHERE p.id_pagos = :id_pagos";
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
            $query = "SELECT SUM(precio) as total FROM pagos WHERE estado = 'pagado'";
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

    public function buscarPagos($termino) {
        try {
            $query = "SELECT p.*, u1.nombre AS nombre_cliente, u1.apellido AS apellido_cliente,
                             u2.nombre AS nombre_cliente_adicional, u2.apellido AS apellido_cliente_adicional
                      FROM pagos p
                      LEFT JOIN usuarios u1 ON p.id_cliente = u1.id_cliente
                      LEFT JOIN usuarios u2 ON p.id_cliente_adicional = u2.id_cliente
                      WHERE p.id_cliente LIKE :termino OR 
                            p.tipo_subscripcion LIKE :termino OR 
                            p.estado LIKE :termino OR 
                            p.medio_pago LIKE :termino OR 
                            p.fecha_pago LIKE :termino OR
                            u1.nombre LIKE :termino OR
                            u1.apellido LIKE :termino OR
                            u2.nombre LIKE :termino OR
                            u2.apellido LIKE :termino";
            $stmt = $this->conn->prepare($query);
            $terminoBusqueda = "%$termino%";
            $stmt->bindParam(':termino', $terminoBusqueda, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Error en buscarPagos: " . $e->getMessage());
            return [];
        }
    }

    public function adminIdExists($id) {
        try {
            $query = "SELECT COUNT(*) FROM admins WHERE ID_Admin = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar si existe el ID de admin: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerEstadisticasPorMes($mes, $anio) {
        try {
            $query = "SELECT 
                        COALESCE(SUM(CASE WHEN estado = 'pagado' THEN precio ELSE 0 END), 0) as total_recaudado,
                        COUNT(*) as pagos_mes,
                        COALESCE(SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END), 0) as pagos_pendientes
                      FROM pagos 
                      WHERE MONTH(fecha_pago) = :mes AND YEAR(fecha_pago) = :anio";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            error_log("Modelo - Query ejecutada: " . $query);
            error_log("Modelo - Parámetros: Mes=$mes, Año=$anio");
            error_log("Modelo - Resultado: " . print_r($result, true));
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas por mes: " . $e->getMessage());
            return [
                'total_recaudado' => 0,
                'pagos_mes' => 0,
                'pagos_pendientes' => 0
            ];
        }
    }

    public function getLastError() {
        return $this->lastError;
    }

    public function clienteExists($id_cliente) {
        try {
            $query = "SELECT COUNT(*) FROM usuarios WHERE id_cliente = :id_cliente";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al verificar si existe el cliente: " . $this->lastError);
            return false;
        }
    }
}
?>

