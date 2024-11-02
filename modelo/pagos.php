<?php
$conexion = new mysqli('localhost', 'root', '12345678', 'gym2');

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

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
    $consulta = $conexion->prepare("INSERT INTO pagos (id_pagos, id_cliente, id_admin, tipo_subscripcion, precio, duracion, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $consulta->bind_param("iiisdis", $id_pagos, $id_cliente, $id_admin, $tipo_subscripcion, $precio, $duracion, $estado);

    // Ejecutar la consulta y verificar el resultado
    if ($consulta->execute()) {
        echo "Datos registrados exitosamente.";
    } else {
        echo "Error al registrar los datos: " . $consulta->error;
    }

    // Cerrar la consulta
    $consulta->close();
} else {
    echo "Por favor, complete todos los campos requeridos.";
}

// Cerrar la conexión
$conexion->close();
?>