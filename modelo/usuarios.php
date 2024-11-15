<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
require_once 'conexion.php';

$conexion = new Conexion();
$conn = $conexion->getConnection();

if (isset($_POST['id_cliente'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['genero'], $_POST['f_registro'], $_POST['estado'])) {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $f_registro = $_POST['f_registro'];
    $estado = $_POST['estado'];

    $consulta = $conn->prepare("INSERT INTO usuarios (id_cliente, nombre, apellido, telefono, genero, f_registro, estado) VALUES (:id_cliente, :nombre, :apellido, :telefono, :genero, :f_registro, :estado)");
    
    $consulta->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $consulta->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $consulta->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $consulta->bindParam(':genero', $genero, PDO::PARAM_STR);
    $consulta->bindParam(':f_registro', $f_registro, PDO::PARAM_STR);
    $consulta->bindParam(':estado', $estado, PDO::PARAM_STR);

    try {
        if ($consulta->execute()) {
            echo "Datos registrados exitosamente en la base de datos.";
        } else {
            echo "Error al registrar los datos: " . print_r($consulta->errorInfo(), true);
        }
    } catch (PDOException $e) {
        echo "Excepción capturada: " . $e->getMessage();
    }
} else {
    echo "Por favor, complete todos los campos requeridos.";
}
?>