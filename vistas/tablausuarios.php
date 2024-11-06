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
            --primary-color: #db2777;
            --primary-dark: #be185d;
            --secondary-color: #f472b6;
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
            background-color: var(--primary-dark);
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
            color: var(--primary-color);
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
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(219, 39, 119, 0.2);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-warning {
            background-color: var(--warning-color);
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .btn-danger {
            background-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            color: var(--primary-color);
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
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination button:hover, .pagination button.active {
            background-color: var(--primary-color);
            color: #fff;
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
                        <li><a href="administradores.php"><i class="fas fa-user-shield"></i> Administradores</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <h2 class="card-title"><i class="fas fa-table"></i> Tabla de Usuarios</h2>
            <div class="search-container">
                <input type="text" id="filtro" class="search-input" placeholder="Buscar usuario...">
                <button onclick="filtrarTabla()" class="btn"><i class="fas fa-search"></i> Buscar</button>
                <button onclick="exportarExcel()" class="btn btn-success"><i class="fas fa-file-excel"></i> Exportar a Excel</button>
            </div>
            <div class="table-container">
                <table id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Teléfono</th>
                            <th>Género</th>
                            <th>Fecha de Registro</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- contenido de la tabla -->
                    </tbody>
                </table>
            </div>
            <div class="pagination" id="pagination">
                <!-- paginacion -->
            </div>
        </div>
    </main>

    <script>
        let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
        let usuariosFiltrados = [...usuarios];
        const itemsPerPage = 10;

        const mostrarUsuarios = (page = 1) => {
            const tbody = document.querySelector('#tablaUsuarios tbody');
            tbody.innerHTML = '';
            const start = (page - 1) * itemsPerPage;
            const end = page * itemsPerPage;
            const paginatedItems = usuariosFiltrados.slice(start, end);
            paginatedItems.forEach(usuario => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${usuario.id_cliente}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.apellido}</td>
                    <td>${usuario.telefono}</td>
                    <td>${usuario.genero}</td>
                    <td>${usuario.f_registro}</td>
                    <td>${usuario.estado}</td>
                    <td>
                        <button onclick="editarUsuario(${usuario.id_cliente})" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            mostrarPaginacion(page);
        };

        const mostrarPaginacion = (currentPage) => {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const totalPages = Math.ceil(usuariosFiltrados.length / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                let btn = document.createElement('button');
                btn.textContent = i;
                btn.classList.toggle('active', i === currentPage);
                btn.onclick = () => mostrarUsuarios(i);
                pagination.appendChild(btn);
            }
        };

        const filtrarTabla = () => {
            const filtro = document.getElementById('filtro').value.toLowerCase();
            usuariosFiltrados = usuarios.filter(usuario => 
                usuario.nombre.toLowerCase().includes(filtro) ||
                usuario.apellido.toLowerCase().includes(filtro) ||
                usuario.telefono.includes(filtro)
            );
            mostrarUsuarios(1);
        };

        const exportarExcel = () => {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "ID Cliente,Nombre,Apellido,Teléfono,Género,Fecha de Registro,Estado\n";
            usuariosFiltrados.forEach(usuario => {
                csvContent += `${usuario.id_cliente},${usuario.nombre},${usuario.apellido},${usuario.telefono},${usuario.genero},${usuario.f_registro},${usuario.estado}\n`;
            });
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "usuarios_gym_tina.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        const editarUsuario = (id) => {
            const usuario = usuarios.find(u => u.id_cliente == id);
            if (usuario) {
                localStorage.setItem('usuarioEditar', JSON.stringify(usuario));
                window.location.href = 'usuarios.php?editar=true';
            }
        };

        mostrarUsuarios();

        document.getElementById('filtro').addEventListener('input', filtrarTabla);
    </script>
</body>
</html>