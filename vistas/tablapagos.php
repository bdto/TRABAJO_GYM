<?php
session_start();
require_once '../controlador/pagoscontroller.php';

$controller = new PagosController();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

// Obtener el mes y año actual si no se especifica
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Obtener pagos del mes seleccionado
$pagos = $controller->obtenerPagosPorMes($month, $year);

// Si es una solicitud AJAX, devolver solo los datos de la tabla
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $html = '';
    foreach ($pagos as $pago) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($pago['id_cliente']) . '</td>';
        $html .= '<td>' . htmlspecialchars($controller->obtenerNombreCliente($pago['id_cliente'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($pago['id_admin']) . '</td>';
        $html .= '<td>' . htmlspecialchars($pago['tipo_subscripcion']) . '</td>';
        $html .= '<td>$' . number_format($pago['precio'], 2) . '</td>';
        $html .= '<td>' . htmlspecialchars($pago['duracion']) . '</td>';
        $html .= '<td>' . htmlspecialchars($pago['estado']) . '</td>';
        $html .= '<td>' . htmlspecialchars(date('Y-m-d', strtotime($pago['fecha_pago']))) . '</td>';
        $html .= '<td><button onclick="editarPago(' . $pago['id_pagos'] . ')" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</button></td>';
        $html .= '</tr>';
    }
    echo $html;
    exit;
}
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

        .month-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background-color: var(--background-color);
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .month-navigation button {
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
        }

        .month-navigation button:hover {
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
            overflow-x: auto;
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
        }

        table {
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

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .pagination button {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            background-color: var(--card-background);
            cursor: pointer;
            transition: var(--transition);
            border-radius: 0.25rem;
        }

        .pagination button:hover, .pagination button.active {
            background-color: var(--secondary-color);
            color: #fff;
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
                    <button onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i> Mes Anterior</button>
                    <span id="currentMonth"></span>
                    <button onclick="changeMonth(1)">Mes Siguiente <i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="search-container">
                    <input type="text" id="filtro" class="search-input" placeholder="Buscar por tipo de subscripción...">
                    <button onclick="filtrarTabla()" class="btn"><i class="fas fa-search"></i> Buscar</button>
                    <button onclick="exportarExcel()" class="btn btn-success"><i class="fas fa-file-excel"></i> Exportar a Excel</button>
                </div>
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagos as $pago): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pago['id_cliente']); ?></td>
                                    <td>
                                        <?php
                                        $nombreCliente = $controller->obtenerNombreCliente($pago['id_cliente']);
                                        echo htmlspecialchars($nombreCliente !== 'Error al obtener el nombre' ? $nombreCliente : 'Nombre no disponible');
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($pago['id_admin']); ?></td>
                                    <td><?php echo htmlspecialchars($pago['tipo_subscripcion']); ?></td>
                                    <td>$<?php echo number_format($pago['precio'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($pago['duracion']); ?></td>
                                    <td><?php echo htmlspecialchars($pago['estado']); ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($pago['fecha_pago']))); ?></td>
                                    <td>
                                        <button onclick="editarPago(<?php echo $pago['id_pagos']; ?>)" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination" class="pagination">
                    <!-- Pagination will be added here by JavaScript -->
                </div>
            </div>
        </div>
    </main>

    <script>
        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredPagos = [];
        let currentMonth = <?php echo $month; ?>;
        let currentYear = <?php echo $year; ?>;

        function updateMonthDisplay() {
            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            document.getElementById('currentMonth').textContent = `${monthNames[currentMonth - 1]} ${currentYear}`;
        }

        function changeMonth(delta) {
            currentMonth += delta;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            } else if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            updateMonthDisplay();
            refreshTableData();
        }

        function filtrarTabla() {
            const filtro = document.getElementById('filtro').value.toLowerCase();
            const tabla = document.getElementById('tablaPagos');
            const filas = tabla.getElementsByTagName('tr');

            filteredPagos = [];

            for (let i = 1; i < filas.length; i++) {
                const fila = filas[i];
                const celdas = fila.getElementsByTagName('td');
                let mostrar = false;

                for (let j = 0; j < celdas.length; j++) {
                    const texto = celdas[j].textContent.toLowerCase();
                    if (texto.indexOf(filtro) > -1) {
                        mostrar = true;
                        break;
                    }
                }

                if (mostrar) {
                    filteredPagos.push(fila);
                }
            }

            mostrarPagina(1);
        }

        function mostrarPagina(pagina) {
            const tabla = document.getElementById('tablaPagos');
            const filas = tabla.getElementsByTagName('tr');
            const inicio = (pagina - 1) * itemsPerPage;
            const fin = inicio + itemsPerPage;

            for (let i = 1; i < filas.length; i++) {
                filas[i].style.display = 'none';
            }

            for (let i = inicio; i < fin && i < filteredPagos.length; i++) {
                filteredPagos[i].style.display = '';
            }

            actualizarPaginacion(pagina);
        }

        function actualizarPaginacion(paginaActual) {
            const totalPaginas = Math.ceil(filteredPagos.length / itemsPerPage);
            const paginacion = document.getElementById('pagination');
            paginacion.innerHTML = '';

            for (let i = 1; i <= totalPaginas; i++) {
                const boton = document.createElement('button');
                boton.textContent = i;
                boton.onclick = function() { mostrarPagina(i); };
                if (i === paginaActual) {
                    boton.classList.add('active');
                }
                paginacion.appendChild(boton);
            }
        }

        function editarPago(id) {
            window.location.href = `pagos.php?editar=true&id=${id}`;
        }

        function exportarExcel() {
            let tabla = document.getElementById('tablaPagos');
            let html = tabla.outerHTML;
            let url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            let downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            downloadLink.href = url;
            downloadLink.download = `pagos_gym_tina_${currentMonth}_${currentYear}.xls`;
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        function refreshTableData() {
            fetch(`tablapagos.php?month=${currentMonth}&year=${currentYear}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const tbody = document.querySelector('#tablaPagos tbody');
                tbody.innerHTML = html;
                filtrarTabla();
            })
            .catch(error => console.error('Error refreshing table data:', error));
        }

        // Inicializar la tabla
        document.addEventListener('DOMContentLoaded', function() {
            updateMonthDisplay();
            filteredPagos = Array.from(document.getElementById('tablaPagos').getElementsByTagName('tr')).slice(1);
            mostrarPagina(1);
        });
    </script>
</body>
</html>

