<?php
require_once 'conexion.php';

$conexion = new Conexion();
$conn = $conexion->getConnection();

// Verificación de que todos los campos estén definidos y se han enviado
if (isset($_POST['id_pagos'], $_POST['id_cliente'], $_POST['id_admin'], $_POST['tipo_subscripcion'], $_POST['precio'], $_POST['duracion'], $_POST['estado'])) {
    // Recibir los datos del formulario
    $id_pagos = $_POST['id_pagos'];
    $id_cliente = $_POST['id_cliente'];
    $id_admin = $_POST['id_admin'];
    $tipo_subscripcion = $_POST['tipo_subscripcion'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];
    $estado = $_POST['estado'];
    
    // Preparar la consulta de inserción con todos los campos
    $consulta = $conn->prepare("INSERT INTO pagos (id_pagos, id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado) VALUES (:id_pagos, :id_cliente, :id_admin, :tipo_subscripcion, :precio, :duracion, :estado)");
    
    // Bind parameters
    $consulta->bindParam(':id_pagos', $id_pagos, PDO::PARAM_INT);
    $consulta->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $consulta->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);
    $consulta->bindParam(':tipo_subscripcion', $tipo_subscripcion, PDO::PARAM_STR);
    $consulta->bindParam(':precio', $precio, PDO::PARAM_STR);
    $consulta->bindParam(':duracion', $duracion, PDO::PARAM_INT);
    $consulta->bindParam(':estado', $estado, PDO::PARAM_STR);

    // Ejecutar la consulta y verificar el resultado
    if ($consulta->execute()) {
        echo "Datos registrados exitosamente.";
    } else {
        echo "Error al registrar los datos: " . $consulta->errorInfo()[2];
    }
} else {
    echo "Por favor, complete todos los campos requeridos.";
}
?>