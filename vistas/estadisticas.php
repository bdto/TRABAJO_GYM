<?php
session_start();
require_once '../controlador/pagoscontroller.php';

$controller = new PagosController();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
$mesActual = date('n');
$añoActual = date('Y');

// Si se envía el formulario, actualizar las estadísticas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mes = isset($_POST['mes']) ? intval($_POST['mes']) : $mesActual;
    $año = isset($_POST['año']) ? intval($_POST['año']) : $añoActual;
} else {
    $mes = isset($_GET['mes']) ? intval($_GET['mes']) : $mesActual;
    $año = isset($_GET['año']) ? intval($_GET['año']) : $añoActual;
}

// Obtener estadísticas reales usando el controlador
$estadisticas = $controller->obtenerEstadisticasPorMes($mes, $año);
$totalRecaudado = $estadisticas['total_recaudado'] ?? 0;
$pagosMes = $estadisticas['pagos_mes'] ?? 0;
$pagosPendientes = $estadisticas['pagos_pendientes'] ?? 0;

// Agregar depuración
error_log("Mes: $mes, Año: $año");
error_log("Estadísticas: " . print_r($estadisticas, true));

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - Fitness Gym-Tina</title>
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

        .month-year-selector {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .selector-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .month-year-selector select {
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: var(--transition);
            width: 150px;
        }

        .month-year-selector select:focus {
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
            margin: 1rem auto;
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

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .selector-container {
                flex-direction: column;
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
                        <li><a href="estadisticas.php"><i class="fas fa-chart-bar"></i> Contabilidad</a></li>
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> Pagos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar fa-2x"></i>
                <h2 class="card-title">Estadísticas Mensuales</h2>
            </div>
            <div class="card-content">
                <?php echo $mensaje; ?>
                <form id="statsForm" method="POST" class="month-year-selector">
                    <div class="selector-container">
                        <select name="mes" id="mes">
                            <?php
                            $meses = [
                                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                            ];
                            foreach ($meses as $num => $nombre) {
                                echo "<option value=\"$num\"" . ($num == $mes ? ' selected' : '') . ">$nombre</option>";
                            }
                            ?>
                        </select>
                        <select name="año" id="año">
                            <?php
                            $añoInicio = 2020;
                            for ($i = $añoActual; $i >= $añoInicio; $i--) {
                                echo "<option value=\"$i\"" . ($i == $año ? ' selected' : '') . ">$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit">
                        <i class="fas fa-search"></i> Ver Estadísticas
                    </button>
                </form>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header bg-blue">
                            <i class="fas fa-dollar-sign fa-lg"></i>
                            <span>Total Recaudado</span>
                        </div>
                        <div class="stat-content" id="totalRecaudado">
                            $<?php echo number_format($totalRecaudado, 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header bg-green">
                            <i class="fas fa-chart-line fa-lg"></i>
                            <span>Pagos del Mes</span>
                        </div>
                        <div class="stat-content" id="pagosMes">
                            <?php echo $pagosMes; ?>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header bg-orange">
                            <i class="fas fa-clock fa-lg"></i>
                            <span>Pagos Pendientes</span>
                        </div>
                        <div class="stat-content" id="pagosPendientes">
                            <?php echo $pagosPendientes; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statsForm = document.getElementById('statsForm');
            statsForm.addEventListener('submit', function(event) {
                // El formulario se enviará normalmente, no necesitamos prevenir el comportamiento por defecto
            });
        });
    </script>
</body>
</html>