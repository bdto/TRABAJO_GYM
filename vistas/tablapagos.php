<?php
session_start();
require_once '../controlador/pagoscontroller.php';

$controller = new PagosController();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

function obtenerNombreMesEspanol($numeroMes) {
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    return $meses[$numeroMes] ?? '';
}

// Obtener el mes y año actual si no se especifica
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Manejar la navegación de meses
if (isset($_GET['nav_month'])) {
    if ($_GET['nav_month'] === 'prev') {
        $month--;
        if ($month < 1) {
            $month = 12;
            $year--;
        }
    } elseif ($_GET['nav_month'] === 'next') {
        $month++;
        if ($month > 12) {
            $month = 1;
            $year++;
        }
    }
}

// Obtener pagos del mes seleccionado
$pagos = $controller->obtenerPagosPorMes($month, $year);

// Manejar la búsqueda
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Pagos - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            max-width: 1500px;
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

        .month-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background-color: var(--background-color);
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .month-navigation a {
            background-color: var(--secondary-color);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .month-navigation a:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .search-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.2);
        }

        .btn {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #38a169;
        }

        .table-container {
            max-width: 100%;
            overflow-x: auto;
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
        }

        table {
            min-width: 1200px;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:nth-child(even) {
            background-color: var(--background-color);
        }

        tr:hover {
            background-color: var(--border-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #dd6b20;
        }

        .cliente-adicional {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            margin-left: 0.5rem;
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

            .search-container {
                flex-direction: column;
            }

            .search-input, .btn {
                width: 100%;
            }

            .month-navigation {
                flex-direction: column;
                gap: 1rem;
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
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> Pagos</a></li>
                        <li><a href="estadisticas.php"><i class="fas fa-chart-bar"></i> Contabilidad</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table fa-2x"></i>
                <h2 class="card-title">Tabla de Pagos</h2>
            </div>
            <div class="card-content">
                <div class="month-navigation">
                    <a href="?nav_month=prev&month=<?php echo $month; ?>&year=<?php echo $year; ?>&filtro=<?php echo urlencode($filtro); ?>" class="btn"><i class="fas fa-chevron-left"></i> Mes Anterior</a>
                    <span id="currentMonth"><?php echo obtenerNombreMesEspanol($month) . ' ' . $year; ?></span>
                    <a href="?nav_month=next&month=<?php echo $month; ?>&year=<?php echo $year; ?>&filtro=<?php echo urlencode($filtro); ?>" class="btn">Mes Siguiente <i class="fas fa-chevron-right"></i></a>
                </div>
                <form method="get" class="search-container">
                    <input type="hidden" name="month" value="<?php echo $month; ?>">
                    <input type="hidden" name="year" value="<?php echo $year; ?>">
                    <input type="text" id="filtro" name="filtro" class="search-input" placeholder="Buscar por tipo de subscripción..." value="<?php echo htmlspecialchars($filtro); ?>">
                    <button type="submit" class="btn"><i class="fas fa-search"></i> Buscar</button>
                    <button type="button" onclick="exportarExcel()" class="btn btn-success"><i class="fas fa-file-excel"></i> Exportar a Excel</button>
                </form>
                <div class="table-container">
                    <table id="tablaPagos">
                        <thead>
                            <tr>
                                <th>ID Cliente</th>
                                <th>Nombre Cliente</th>
                                <th>ID Admin</th>
                                <th>Tipo de Subscripción</th>
                                <th>Precio</th>
                                <th>Duración</th>
                                <th>Estado</th>
                                <th>Fecha de Pago</th>
                                <th>Medio de Pago</th>
                                <th>Cliente Adicional</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagos as $pago): 
                                if (empty($filtro) || stripos($pago['tipo_subscripcion'] ?? '', $filtro) !== false):
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pago['id_cliente'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($pago['nombre_cliente'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($pago['id_admin'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($pago['tipo_subscripcion'] ?? 'N/A'); ?></td>
                                    <td>$<?php echo number_format($pago['precio'] ?? 0, 2); ?></td>
                                    <td><?php echo htmlspecialchars($pago['duracion'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($pago['estado'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($pago['fecha_pago']) ? date('Y-m-d', strtotime($pago['fecha_pago'])) : 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($pago['medio_pago'] ?? 'N/A'); ?></td>
                                    <td>
                                        <?php if (!empty($pago['id_cliente_adicional'])): ?>
                                            <span class="cliente-adicional">
                                                <?php echo htmlspecialchars($pago['nombre_cliente_adicional'] ?? 'N/A') . ' ' . htmlspecialchars($pago['apellido_cliente_adicional'] ?? ''); ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="pagos.php?editar=true&id=<?php echo htmlspecialchars($pago['id_pagos'] ?? ''); ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
    function exportarExcel() {
        let tabla = document.getElementById('tablaPagos');
        
        let html = tabla.outerHTML;
        let url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        let downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        downloadLink.href = url;
        downloadLink.download = 'pagos_gym_tina_<?php echo $month ?>_<?php echo $year ?>.xls';
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    </script>
</body>
</html>

