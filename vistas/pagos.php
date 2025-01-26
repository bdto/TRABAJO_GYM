<?php
session_start();
require_once '../controlador/pagoscontroller.php';

// Agregar encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Función para registrar errores
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, '../logs/error.log');
}

$controller = new PagosController();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener pagos para las estadísticas
try {
    $estadisticas = $controller->obtenerEstadisticasPagos();
} catch (Exception $e) {
    logError('Error al obtener estadísticas: ' . $e->getMessage());
    $estadisticas = ['total_recaudado' => 0, 'pagos_mes' => 0, 'pagos_pendientes' => 0];
}

// Verificar si estamos en modo de edición
$isEditing = isset($_GET['editar']) && $_GET['editar'] === 'true';
$pagoToEdit = null;
if ($isEditing && isset($_GET['id'])) {
    try {
        $pagoToEdit = $controller->obtenerPago($_GET['id']);
    } catch (Exception $e) {
        logError('Error al obtener pago para editar: ' . $e->getMessage());
    }
}

$mensaje = '';
$accion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('POST data recibida en pagos.php: ' . print_r($_POST, true));
    $action = $_POST['action'];
    $datos = [
        'id_cliente' => $_POST['id_cliente'],
        'id_admin' => $_POST['id_admin'],
        'tipo_subscripcion' => $_POST['tipo_subscripcion'],
        'precio' => $_POST['precio'],
        'duracion' => $_POST['duracion'],
        'estado' => $_POST['estado'],
        'fecha_pago' => $_POST['fecha_pago']
    ];

    try {
        if ($action === 'registrar') {
            $resultado = $controller->registrarPago($datos);
        } elseif ($action === 'actualizar') {
            $id_pagos = $_POST['id_pagos'];
            $resultado = $controller->actualizarPago($id_pagos, $datos);
        }

        error_log('Resultado de la operación: ' . print_r($resultado, true));

        if ($resultado['success']) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $resultado['message'],
                'redirect' => 'tablapagos.php'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode($resultado);
        }
    } catch (Exception $e) {
        logError('Error al procesar pago: ' . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Error interno del servidor: ' . $e->getMessage()
        ]);
    }
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Fitness Gym-Tina</title>
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

        .bg-orange {
            background-color: var(--warning-color);
            color: #fff;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .success-message {
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--card-background);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: center;
        }

        .popup-content {
            margin-bottom: 20px;
        }

        .popup-close {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
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
                        <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
                        <li><a href="tablapagos.php"><i class="fas fa-table"></i> Tabla Pagos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-money-bill-wave fa-2x"></i>
                <h2 class="card-title"><?php echo $isEditing ? 'Editar Pago' : 'Registrar Pago'; ?></h2>
            </div>
            <div class="card-content">
                <form id="paymentForm" method="POST">
                    <input type="hidden" name="action" value="<?php echo $isEditing ? 'actualizar' : 'registrar'; ?>">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id_pagos" value="<?php echo $pagoToEdit['id_pagos']; ?>">
                    <?php endif; ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="id_cliente">ID Cliente:</label>
                            <input type="text" id="id_cliente" name="id_cliente" required value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['id_cliente']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_admin">ID Admin:</label>
                            <input type="text" id="id_admin" name="id_admin" required value="<?php echo $_SESSION['id_admin']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tipo_subscripcion">Tipo de Subscripción:</label>
                            <select id="tipo_subscripcion" name="tipo_subscripcion" required>
                                <option value="">Seleccionar</option>
                                <option value="mensualidad" <?php echo ($isEditing && $pagoToEdit['tipo_subscripcion'] === 'mensualidad') ? 'selected' : ''; ?>>Mensualidad</option>
                                <option value="rutina" <?php echo ($isEditing && $pagoToEdit['tipo_subscripcion'] === 'rutina') ? 'selected' : ''; ?>>Rutina</option>
                                <option value="semanal" <?php echo ($isEditing && $pagoToEdit['tipo_subscripcion'] === 'semanal') ? 'selected' : ''; ?>>Semanal</option>
                                <option value="quincenal" <?php echo ($isEditing && $pagoToEdit['tipo_subscripcion'] === 'quincenal') ? 'selected' : ''; ?>>Quincenal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" id="precio" name="precio" required value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['precio']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="duracion">Duración:</label>
                            <input type="number" id="duracion" name="duracion" required value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['duracion']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="pendiente" <?php echo ($isEditing && $pagoToEdit['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="pagado" <?php echo ($isEditing && $pagoToEdit['estado'] === 'pagado') ? 'selected' : ''; ?>>Pagado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_pago">Fecha de Pago:</label>
                            <input type="date" id="fecha_pago" name="fecha_pago" required value="<?php echo $isEditing ? date('Y-m-d', strtotime($pagoToEdit['fecha_pago'])) : date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <button type="submit">
                        <i class="fas fa-save"></i> <?php echo $isEditing ? 'Actualizar Pago' : 'Registrar Pago'; ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header bg-blue">
                    <i class="fas fa-dollar-sign fa-lg"></i>
                    <span>Total Recaudado</span>
                </div>
                <div class="stat-content" id="totalRecaudado">
                    $<?php echo number_format($estadisticas['total_recaudado'], 2); ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-green">
                    <i class="fas fa-chart-line fa-lg"></i>
                    <span>Pagos del Mes</span>
                </div>
                <div class="stat-content" id="pagosMes">
                    <?php echo $estadisticas['pagos_mes']; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-orange">
                    <i class="fas fa-clock fa-lg"></i>
                    <span>Pagos Pendientes</span>
                </div>
                <div class="stat-content" id="pagosPendientes">
                    <?php echo $estadisticas['pagos_pendientes']; ?>
                </div>
            </div>
        </div>
    </main>

    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <div class="popup-content" id="popupMessage"></div>
        <button class="popup-close" onclick="closePopup()">Cerrar</button>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paymentForm');
        const tipoSubscripcionSelect = document.getElementById('tipo_subscripcion');
        const precioInput = document.getElementById('precio');
        const duracionInput = document.getElementById('duracion');

        const subscriptionData = {
            mensualidad: {
                precio: 60000,
                duracion: 30
            },
            rutina: {
                precio: 10000,
                duracion: 1 
            },
            semanal: {
                precio: 30000,
                duracion: 7
            },
            quincenal: {
                precio: 40000,
                duracion: 15
            }
        };

        tipoSubscripcionSelect.addEventListener('change', function() {
            const selectedType = this.value;
            const data = subscriptionData[selectedType];
            if (data) {
                precioInput.value = data.precio;
                duracionInput.value = data.duracion;
            } else {
                precioInput.value = '';
                duracionInput.value = '';
            }
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();
    
            const formData = new FormData(form);
            
            // Log form data before sending
            console.log('Form data before sending:', Object.fromEntries(formData));

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showPopup(data.message);
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 2000);
                    } else {
                        clearForm();
                    }
                } else {
                    showPopup("Error: " + (data.message || "Ocurrió un error desconocido."));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showPopup("Ocurrió un error al procesar la solicitud: " + error.message);
            });
        });

        function clearForm() {
            form.reset();
            document.getElementById('id_cliente').value = '';
            document.getElementById('tipo_subscripcion').value = '';
            document.getElementById('precio').value = '';
            document.getElementById('duracion').value = '';
            document.getElementById('estado').value = 'pendiente';
            document.getElementById('fecha_pago').value = new Date().toISOString().split('T')[0];
        }

        <?php if (!empty($mensaje)): ?>
            showPopup("<?php echo $mensaje; ?>");
        <?php endif; ?>
    });

    function showPopup(message) {
        document.getElementById('popupMessage').textContent = message;
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>
</body>

</html>

