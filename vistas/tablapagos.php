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
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --background-color: #ecf0f1;
            --text-color: #34495e;
            --card-background: #ffffff;
            --border-color: #bdc3c7;
            --hover-color: #f5f6fa;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            transition: transform 0.3s ease;
            border: 2px solid var(--accent-color);
        }

        .logo img:hover {
            transform: scale(1.1);
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--accent-color);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        nav a:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        main {
            padding: 2rem 0;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.5rem;
        }

        .search-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 1rem;
            min-width: 200px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background-color: var(--secondary-color);
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: var(--text-color);
        }

        .btn-warning:hover {
            background-color: #f1c40f;
        }

        .table-container {
            overflow-x: auto;
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 600px;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--primary-color);
            font-weight: bold;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:hover {
            background-color: var(--hover-color);
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
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
            border-radius: 0.25rem;
        }

        .pagination button:hover, .pagination button.active {
            background-color: var(--secondary-color);
            color: #fff;
            transform: translateY(-2px);
        }

        .month-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background-color: var(--hover-color);
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .month-navigation button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 0.25rem;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: 500;
        }

        .month-navigation button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .month-navigation span {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            nav ul {
                margin-top: 1rem;
                flex-wrap: wrap;
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
                        <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> Pagos</a></li>
                        <li><a href="administradores.php"><i class="fas fa-user-shield"></i> Inicio</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <h2 class="card-title"><i class="fas fa-table"></i> Tabla de Pagos</h2>
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
                            <th>ID Pagos</th>
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
                                <td><?php echo htmlspecialchars($pago['id_pagos']); ?></td>
                                <td><?php echo htmlspecialchars($pago['id_cliente']); ?></td>
                                <td>
                                    <?php
                                    $nombreCliente = $controller->obtenerNombreCliente($pago['id_cliente']);
                                    echo htmlspecialchars($nombreCliente);
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
            <div class="pagination" id="pagination">
                <!-- Pagination will be added here by JavaScript -->
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
            window.location.href = `tablapagos.php?month=${currentMonth}&year=${currentYear}`;
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

        // Inicializar la tabla
        document.addEventListener('DOMContentLoaded', function() {
            updateMonthDisplay();
            filteredPagos = Array.from(document.getElementById('tablaPagos').getElementsByTagName('tr')).slice(1);
            mostrarPagina(1);
        });
    </script>
</body>
</html>