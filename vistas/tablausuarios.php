<?php
// Configuración para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Ajusta según tus credenciales
$password = "12345678"; // Ajusta según tus credenciales
$database = "gym2";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta a la tabla usuarios
$sql = "SELECT id_cliente, nombre, apellido, telefono, genero, f_registro, estado, email, direccion FROM usuarios";
$result = $conn->query($sql);
$usuarios = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    } else {
        echo "No hay usuarios disponibles.";
    }
} else {
    echo "Error en la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Usuarios - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #db2777;
            --accent-color: #f472b6;
            --background-color: #f3f4f6;
            --text-color: #1f2937;
            --card-background: #ffffff;
            --border-color: #e5e7eb;
            --hover-color: #f9fafb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            transition: transform 0.3s ease;
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
            transition: background-color 0.3s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(219, 39, 119, 0.2);
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
            background-color: #059669;
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
            background-color: var(--hover-color);
            font-weight: bold;
            color: var(--secondary-color);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:hover {
            background-color: var(--hover-color);
        }

        .edit-btn {
            padding: 0.5rem 1rem;
            background-color: var(--warning-color);
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
        }

        .edit-btn:hover {
            background-color: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" alt="Logo Gym">
                    <h1>Fitness Gym - Tina</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="administradores.php"><i class="fas fa-home"></i> Inicio</a></li>
                        <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> Pagos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-users"></i>
                    <span>Usuarios Registrados</span>
                </div>
                <div class="search-container">
                    <input id="searchInput" class="search-input" type="text" placeholder="Buscar usuarios" />
                    <button class="btn" onclick="searchUsers()"><i class="fas fa-search"></i> Buscar</button>
                    <button class="btn btn-success" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> Exportar a Excel</button>
                </div>
                <div class="table-container">
                    <table id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Teléfono</th>
                                <th>Género</th>
                                <th>Fecha Registro</th>
                                <th>Estado</th>
                                <th>Email</th>
                                <th>Dirección</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id_cliente']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                    <td><?= htmlspecialchars($usuario['apellido']) ?></td>
                                    <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                    <td><?= htmlspecialchars($usuario['genero']) ?></td>
                                    <td><?= htmlspecialchars($usuario['f_registro']) ?></td>
                                    <td><?= htmlspecialchars($usuario['estado']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= htmlspecialchars($usuario['direccion']) ?></td>
                                    <td><button class="edit-btn" onclick="editUser(<?= $usuario['id_cliente'] ?>)"><i class="fas fa-edit"></i> Editar</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination" class="pagination">
                    <!-- Pagination buttons will be added here by JavaScript -->
                </div>
            </div>
        </div>
    </main>

    <script>
        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredUsers = [];

        function searchUsers() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');

            filteredUsers = [];

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let shouldShow = false;

                for (let j = 0; j < cells.length -1; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                        shouldShow = true;
                        break;
                    }
                }

                if (shouldShow) {
                    filteredUsers.push(row);
                }
            }

            showPage(1);
        }

        function showPage(page) {
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = 'none';
            }

            for (let i = startIndex; i < endIndex && i < filteredUsers.length; i++) {
                filteredUsers[i].style.display = '';
            }

            updatePagination(page);
        }

        function updatePagination(currentPage) {
            const totalPages = Math.ceil(filteredUsers.length / itemsPerPage);
            const paginationElement = document.getElementById('pagination');
            paginationElement.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.onclick = function() { showPage(i); };
                if (i === currentPage) {
                    button.classList.add('active');
                }
                paginationElement.appendChild(button);
            }
        }

        function editUser(userId) {
            window.location.href = `usuarios.php?editar=true&id=${userId}`;
        }

        function exportToExcel() {
            const table = document.getElementById('usersTable');
            const html = table.outerHTML;
            const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            const downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            downloadLink.href = url;
            downloadLink.download = 'usuarios_gym_tina.xls';
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Initialize the table
        document.addEventListener('DOMContentLoaded', function() {
            filteredUsers = Array.from(document.getElementById('usersTable').getElementsByTagName('tr')).slice(1);
            showPage(1);
        });
    </script>
</body>
</html>

