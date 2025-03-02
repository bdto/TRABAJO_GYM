<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../controlador/usuarioscontroller.php';

$controller = new UsuariosController();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener usuarios para las estadísticas
$usuarios = $controller->obtenerUsuarios();
$totalUsuarios = count($usuarios);
$usuariosActivos = count(array_filter($usuarios, function ($u) {
    return $u['estado'] === 'activo';
}));
$usuariosInactivos = $totalUsuarios - $usuariosActivos;

// Verificar si estamos en modo de edición
$isEditing = isset($_GET['editar']) && $_GET['editar'] === 'true';
$userToEdit = null;
if ($isEditing && isset($_GET['id'])) {
    $userToEdit = $controller->obtenerUsuario($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #db2777;
            --accent-color: #f472b6;
            --text-color: #333;
            --background-color: #f5f5f5;
            --card-background: #ffffff;
            --border-color: #e5e7eb;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --danger-color: #ef4444;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        header {
            background-color: var(--primary-color);
            color: #fff;
            padding: 1rem 0;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-color);
            transition: var(--transition);
        }

        .logo img:hover {
            transform: scale(1.1);
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--accent-color);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 1rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        nav a:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        main {
            padding: 2rem 0;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 1rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: bold;
        }

        .card-content {
            padding: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        input,
        select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: var(--transition);
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.2);
        }

        button {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin: 2rem auto 0;
            width: 100%;
            max-width: 300px;
        }

        button:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-card {
            background-color: var(--card-background);
            border-radius: 1rem;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .stat-header {
            padding: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-size: 1.25rem;
        }

        .stat-content {
            padding: 2rem;
            text-align: center;
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .bg-blue {
            background-color: var(--secondary-color);
            color: #fff;
        }

        .bg-green {
            background-color: var(--success-color);
            color: #fff;
        }

        .bg-red {
            background-color: var(--danger-color);
            color: #fff;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                min-height: 200px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="../imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">
                    <h1>FITNESS GYM-TINA</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="administradores.php"><i class="fas fa-user-shield"></i> Inicio</a></li>
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> Pagos</a></li>
                        <li><a href="tablausuarios.php"><i class="fas fa-table"></i> Tabla Usuarios</a></li>
                        <li><a href="estadisticas.php"><i class="fas fa-chart-bar"></i> Contabilidad</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-plus fa-2x"></i>
                <h2 class="card-title" id="formTitle"><?php echo $isEditing ? 'Editar Usuario' : 'Registrar Usuario'; ?></h2>
            </div>
            <div class="card-content">
                <form id="userForm">
                    <input type="hidden" name="action" value="<?php echo $isEditing ? 'actualizar' : 'registrar'; ?>">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?php echo $userToEdit['id_cliente']; ?>">
                    <?php endif; ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios" value="<?php echo $isEditing ? htmlspecialchars($userToEdit['nombre']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios" value="<?php echo $isEditing ? htmlspecialchars($userToEdit['apellido']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono" required pattern="[0-9]{10}" title="Debe contener exactamente 10 dígitos numéricos" maxlength="10" value="<?php echo $isEditing ? htmlspecialchars($userToEdit['telefono']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="genero">Género:</label>
                            <select id="genero" name="genero" required>
                                <option value="">Seleccionar</option>
                                <option value="masculino" <?php echo ($isEditing && $userToEdit['genero'] === 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="femenino" <?php echo ($isEditing && $userToEdit['genero'] === 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="otro" <?php echo ($isEditing && $userToEdit['genero'] === 'otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                        <?php if (!$isEditing): ?>
                            <div class="form-group">
                                <label for="f_registro">Fecha de Registro:</label>
                                <input type="date" id="f_registro" name="f_registro" required>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="">Seleccionar</option>
                                <option value="activo" <?php echo ($isEditing && $userToEdit['estado'] === 'activo') ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactivo" <?php echo ($isEditing && $userToEdit['estado'] === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required value="<?php echo $isEditing ? htmlspecialchars($userToEdit['email']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" required value="<?php echo $isEditing ? htmlspecialchars($userToEdit['direccion']) : ''; ?>">
                        </div>
                    </div>
                    <button type="submit" id="submitBtn">
                        <i class="fas fa-save"></i> <?php echo $isEditing ? 'Actualizar Usuario' : 'Registrar Usuario'; ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header bg-blue">
                    <i class="fas fa-users fa-lg"></i>
                    <span>Total Usuarios</span>
                </div>
                <div class="stat-content" id="totalUsuarios">
                    <?php echo $totalUsuarios; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-green">
                    <i class="fas fa-user-check fa-lg"></i>
                    <span>Usuarios Activos</span>
                </div>
                <div class="stat-content" id="usuariosActivos">
                    <?php echo $usuariosActivos; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-red">
                    <i class="fas fa-user-times fa-lg"></i>
                    <span>Usuarios Inactivos</span>
                </div>
                <div class="stat-content" id="usuariosInactivos">
                    <?php echo $usuariosInactivos; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;

                const formData = new FormData(form);
                const action = formData.get('action');
                const url = '../controlador/usuarioscontroller.php';

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            if (action === 'registrar') {
                                form.reset();
                            } else {
                                window.location.href = 'tablausuarios.php';
                            }
                            actualizarEstadisticas();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                    });
            });

            function actualizarEstadisticas() {
                fetch('../controlador/usuarioscontroller.php?action=obtenerEstadisticas')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('totalUsuarios').textContent = data.data.total;
                            document.getElementById('usuariosActivos').textContent = data.data.activos;
                            document.getElementById('usuariosInactivos').textContent = data.data.inactivos;
                        }
                    })
                    .catch(error => console.error('Error al actualizar estadísticas:', error));
            }
        });
    </script>
</body>

</html>

