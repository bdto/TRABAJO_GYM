<?php
class UsuariosController {
    private $db;

    public function __construct() {
        require_once '../modelo/conexion.php';
        $this->db = (new Conexion())->getConnection();
    }

    public function obtenerUsuarios() {
        $query = "SELECT * FROM usuarios";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function obtenerUsuario($id) {
        $query = "SELECT * FROM usuarios WHERE id_cliente = :id_cliente";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuario: " . $e->getMessage());
        }
    }

    public function registrarUsuario($nombre, $apellido, $telefono, $genero, $f_registro, $estado, $email, $direccion) {
        $query = "INSERT INTO usuarios (nombre, apellido, telefono, genero, f_registro, estado, email, direccion) VALUES (:nombre, :apellido, :telefono, :genero, :f_registro, :estado, :email, :direccion)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':f_registro', $f_registro);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':direccion', $direccion);

            if ($stmt->execute()) {
                return json_encode(['success' => true, 'message' => 'Usuario registrado con éxito']);
            } else {
                return json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
            }
        } catch (PDOException $e) {
            throw new Exception("Error al registrar usuario: " . $e->getMessage());
        }
    }

    public function actualizarUsuario($id, $nombre, $apellido, $telefono, $genero, $estado, $email, $direccion) {
        $query = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, telefono = :telefono, genero = :genero, estado = :estado, email = :email, direccion = :direccion WHERE id_cliente = :id_cliente";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':direccion', $direccion);

            if ($stmt->execute()) {
                return json_encode(['success' => true, 'message' => 'Usuario actualizado con éxito']);
            } else {
                return json_encode(['success' => false, 'message' => 'Error al actualizar usuario']);
            }
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar usuario: " . $e->getMessage());
        }
    }

    public function procesarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            try {
                switch ($action) {
                    case 'registrar':
                        echo $this->registrarUsuario(
                            $_POST['nombre'],
                            $_POST['apellido'],
                            $_POST['telefono'],
                            $_POST['genero'],
                            $_POST['f_registro'],
                            $_POST['estado'],
                            $_POST['email'],
                            $_POST['direccion']
                        );
                        break;
                    case 'actualizar':
                        echo $this->actualizarUsuario(
                            $_POST['id'],
                            $_POST['nombre'],
                            $_POST['apellido'],
                            $_POST['telefono'],
                            $_POST['genero'],
                            $_POST['estado'],
                            $_POST['email'],
                            $_POST['direccion']
                        );
                        break;
                    default:
                        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }
}

// Procesar la solicitud si se accede directamente a este archivo
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    $controller = new UsuariosController();
    $controller->procesarSolicitud();
}

