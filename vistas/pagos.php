<?php
session_start();
require_once '../controlador/pagoscontroller.php';

$controller = new PagosController();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si estamos en modo de edición
$isEditing = isset($_GET['editar']) && $_GET['editar'] === 'true';
$pagoToEdit = null;
if ($isEditing && isset($_GET['id'])) {
    $resultado = $controller->obtenerPago($_GET['id']);
    if ($resultado['success']) {
        $pagoToEdit = $resultado['pago'];
    } else {
        $mensaje = "<p class='error-message'>{$resultado['message']}</p>";
    }
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $datos = [
        'id_cliente' => $_POST['id_cliente'] ?? '',
        'id_admin' => $_POST['id_admin'] ?? '',
        'tipo_subscripcion' => $_POST['tipo_subscripcion'] ?? '',
        'precio' => $_POST['precio'] ?? '',
        'duracion' => $_POST['duracion'] ?? '',
        'estado' => $_POST['estado'] ?? '',
        'fecha_pago' => $_POST['fecha_pago'] ?? '',
        'medio_pago' => $_POST['medio_pago'] ?? '',
        'id_cliente_adicional' => $_POST['id_cliente_adicional'] ?? null
    ];

    // Procesar el pago
    if ($action === 'registrar') {
        $resultado = $controller->registrarPago($datos);
    } elseif ($action === 'actualizar') {
        $id_pagos = $_POST['id_pagos'] ?? '';
        $resultado = $controller->actualizarPago($id_pagos, $datos);
    }

    if (isset($resultado['success']) && $resultado['success']) {
        $mensaje = "<p class='success-message'>{$resultado['message']}</p>";
        // Redirect to tablapagos.php with the correct month and year
        $selectedDate = new DateTime($datos['fecha_pago']);
        $month = $selectedDate->format('n');
        $year = $selectedDate->format('Y');
        header("Location: tablapagos.php?month=$month&year=$year");
        exit();
    } else {
        $mensaje = "<p class='error-message'>{$resultado['message']}</p>";
    }
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

        .hidden {
            display: none;
        }

        .cliente-adicional-container {
            background-color: var(--background-color);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 2px dashed var(--secondary-color);
        }

        .cliente-adicional-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .cliente-info {
            margin-top: 0.5rem;
            padding: 0.5rem;
            background-color: var(--card-background);
            border-radius: 0.25rem;
            border-left: 3px solid var(--secondary-color);
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
                        <li><a href="estadisticas.php"><i class="fas fa-chart-bar"></i> Contabilidad</a></li>
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
                <?php echo $mensaje; ?>
                <form id="paymentForm" method="POST">
                    <input type="hidden" name="action" value="<?php echo $isEditing ? 'actualizar' : 'registrar'; ?>">
                    <?php if ($isEditing && isset($pagoToEdit['id_pagos'])): ?>
                        <input type="hidden" name="id_pagos" value="<?php echo htmlspecialchars($pagoToEdit['id_pagos']); ?>">
                    <?php endif; ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="id_cliente">ID Cliente:</label>
                            <input type="text" id="id_cliente" name="id_cliente" required value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['id_cliente'] ?? '') : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_admin">ID Admin:</label>
                            <input type="text" id="id_admin" name="id_admin" required value="<?php echo $_SESSION['id_admin'] ?? ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tipo_subscripcion">Tipo de Subscripción:</label>
                            <select id="tipo_subscripcion" name="tipo_subscripcion" required>
                                <option value="">Seleccionar</option>
                                <option value="mensualidad" <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'mensualidad') ? 'selected' : ''; ?>>Mensualidad</option>
                                <option value="rutina" <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'rutina') ? 'selected' : ''; ?>>Rutina</option>
                                <option value="semanal" <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'semanal') ? 'selected' : ''; ?>>Semanal</option>
                                <option value="quincenal" <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'quincenal') ? 'selected' : ''; ?>>Quincenal</option>
                                <option value="duo_combo_x1" <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'duo_combo_x1') ? 'selected' : ''; ?>>Duo Combo X1</option>
                                <option value="duo_combo_x2" <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'duo_combo_x2') ? 'selected' : ''; ?>>Duo Combo X2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" id="precio" name="precio" required value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['precio'] ?? '') : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="duracion">Duración:</label>
                            <input type="number" id="duracion" name="duracion" required value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['duracion'] ?? '') : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="pendiente" <?php echo ($isEditing && ($pagoToEdit['estado'] ?? '') === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="pagado" <?php echo ($isEditing && ($pagoToEdit['estado'] ?? '') === 'pagado') ? 'selected' : ''; ?>>Pagado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="medio_pago">Medio de Pago:</label>
                            <select id="medio_pago" name="medio_pago" required>
                                <option value="">Seleccionar</option>
                                <option value="Efectivo" <?php echo ($isEditing && ($pagoToEdit['medio_pago'] ?? '') === 'Efectivo') ? 'selected' : ''; ?>>Efectivo</option>
                                <option value="Nequi" <?php echo ($isEditing && ($pagoToEdit['medio_pago'] ?? '') === 'Nequi') ? 'selected' : ''; ?>>Nequi</option>
                                <option value="Bancolombia" <?php echo ($isEditing && ($pagoToEdit['medio_pago'] ?? '') === 'Bancolombia') ? 'selected' : ''; ?>>Bancolombia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_pago">Fecha de Pago:</label>
                            <input type="date" id="fecha_pago" name="fecha_pago" required value="<?php echo $isEditing ? date('Y-m-d', strtotime($pagoToEdit['fecha_pago'] ?? '')) : ''; ?>">
                        </div>
                    </div>

                    <!-- Sección para cliente adicional (solo visible cuando se selecciona duo_combo_x2) -->
                    <div id="cliente_adicional_section" class="cliente-adicional-container <?php echo ($isEditing && ($pagoToEdit['tipo_subscripcion'] ?? '') === 'duo_combo_x2') ? '' : 'hidden'; ?>">
                        <div class="cliente-adicional-title">
                            <i class="fas fa-user-plus"></i> Información del Cliente Adicional
                        </div>
                        <div class="form-group">
                            <label for="id_cliente_adicional">ID Cliente Adicional:</label>
                            <input type="text" id="id_cliente_adicional" name="id_cliente_adicional" value="<?php echo $isEditing ? htmlspecialchars($pagoToEdit['id_cliente_adicional'] ?? '') : ''; ?>">
                            <button type="button" id="verificar_cliente" class="btn" style="margin-top: 0.5rem; max-width: 200px;">
                                <i class="fas fa-search"></i> Verificar Cliente
                            </button>
                        </div>
                        <div id="cliente_info" class="cliente-info hidden">
                            <!-- Aquí se mostrará la información del cliente adicional -->
                        </div>
                    </div>

                    <button type="submit">
                        <i class="fas fa-save"></i> <?php echo $isEditing ? 'Actualizar Pago' : 'Registrar Pago'; ?>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('paymentForm');
            const tipoSubscripcionSelect = document.getElementById('tipo_subscripcion');
            const precioInput = document.getElementById('precio');
            const duracionInput = document.getElementById('duracion');
            const clienteAdicionalSection = document.getElementById('cliente_adicional_section');
            const idClienteAdicionalInput = document.getElementById('id_cliente_adicional');
            const clienteInfoDiv = document.getElementById('cliente_info');
            const verificarClienteBtn = document.getElementById('verificar_cliente');

            const subscriptionData = {
                mensualidad: { precio: 60000, duracion: 30 },
                rutina: { precio: 10000, duracion: 1 },
                semanal: { precio: 30000, duracion: 7 },
                quincenal: { precio: 40000, duracion: 15 },
                duo_combo_x1: { precio: 100000, duracion: 60 },
                duo_combo_x2: { precio: 100000, duracion: 30 }
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
                
                if (selectedType === 'duo_combo_x2') {
                    clienteAdicionalSection.classList.remove('hidden');
                } else {
                    clienteAdicionalSection.classList.add('hidden');
                    idClienteAdicionalInput.value = '';
                    clienteInfoDiv.classList.add('hidden');
                    clienteInfoDiv.innerHTML = '';
                }
            });

            verificarClienteBtn.addEventListener('click', function() {
                const idClienteAdicional = idClienteAdicionalInput.value.trim();
                
                if (!idClienteAdicional) {
                    clienteInfoDiv.innerHTML = '<p style="color: var(--danger-color);">Por favor, ingrese un ID de cliente válido.</p>';
                    clienteInfoDiv.classList.remove('hidden');
                    return;
                }
                
                fetch(`verificar_cliente.php?id=${idClienteAdicional}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            clienteInfoDiv.innerHTML = `
                                <p><strong>Nombre:</strong> ${data.nombre}</p>
                                <p><strong>Apellido:</strong> ${data.apellido}</p>
                                <p><strong>Email:</strong> ${data.email}</p>
                            `;
                            clienteInfoDiv.classList.remove('hidden');
                        } else {
                            clienteInfoDiv.innerHTML = `<p style="color: var(--danger-color);">${data.message}</p>`;
                            clienteInfoDiv.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        clienteInfoDiv.innerHTML = '<p style="color: var(--danger-color);">Error al verificar el cliente. Por favor, inténtelo de nuevo.</p>';
                        clienteInfoDiv.classList.remove('hidden');
                    });
            });

            form.addEventListener('submit', function(event) {
                const tipoSubscripcion = tipoSubscripcionSelect.value;
                
                if (tipoSubscripcion === 'duo_combo_x2') {
                    const idClienteAdicional = idClienteAdicionalInput.value.trim();
                    
                    if (!idClienteAdicional) {
                        event.preventDefault();
                        alert('Por favor, ingrese el ID del cliente adicional para la suscripción Duo Combo X2.');
                        idClienteAdicionalInput.focus();
                    }
                } else {
                    idClienteAdicionalInput.value = '';
                }
            });
        });
    </script>
</body>
</html>

