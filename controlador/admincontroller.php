<?php
session_start();

include_once '../modelo/conexion.php';
include_once '../modelo/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que ambos campos están llenos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        $error = "Por favor, complete todos los campos.";
        header("Location: ../vistas/index.php?error=" . urlencode($error));
        exit;
    }

    // Conexión a la base de datos
    $conexion = new Conexion();
    $db = $conexion->getConnection();

    // Verificar si se obtuvo la conexión
    if (!$db) {
        $error = "Error de conexión a la base de datos.";
        header("Location: ../vistas/index.php?error=" . urlencode($error));
        exit;
    }

    // Crear la instancia de usuario y asignar los datos
    $usuario = new Admin($db);
    $usuario->usuario = $_POST['usuario'];
    $usuario->password = $_POST['password'];
    
    // Validar el usuario
    $resultado = $usuario->validarUsuario();

    if ($resultado) {
        $_SESSION['usuario'] = htmlspecialchars($resultado['usuario']);
        header("Location: ../vistas/administradores.php");
        exit;
    } else {
        $error = "Credenciales incorrectas";
        header("Location: ../vistas/index.php?error=" . urlencode($error));
        exit;
    }
}
?>