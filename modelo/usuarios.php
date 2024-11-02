<?php
$conexion = new mysqli('localhost', 'root', '12345678', 'gym2');

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Verificación de que todos los campos estén definidos y se han enviado
if (isset($_POST['id_cliente'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['genero'], $_POST['f_registro'], $_POST['estado'])) {
    // Recibir los datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $f_registro = $_POST['f_registro'];
    $estado = $_POST['estado'];

    // Preparar la consulta de inserción con todos los campos
    $consulta = $conexion->prepare("INSERT INTO usuarios (id_cliente, nombre, apellido, telefono, genero, f_registro, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $consulta->bind_param("issssss", $id_cliente, $nombre, $apellido, $telefono, $genero, $f_registro, $estado);

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