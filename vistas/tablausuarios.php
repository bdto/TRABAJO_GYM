<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Usuarios - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 1rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-content {
            padding: 1rem;
        }

        .search-container {
            display: flex;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 1rem;
        }

        .btn {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
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

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            nav ul {
                margin-top: 1rem;
                flex-wrap: wrap;
            }

            nav li {
                flex: 1 0 50%;
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
                        <li><a href="usuarios.php">Usuarios</a></li>
                        <li><a href="pagos.php">Pagos</a></li>
                        <li><a href="administradores.php">Administradores</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Lista de Usuarios</h2>
            </div>
            <div class="card-content">
                <div class="search-container">
                    <input type="text" id="filtro" class="search-input" placeholder="Buscar por nombre...">
                    <button onclick="filtrarTabla()" class="btn">Buscar</button>
                    <button onclick="exportarExcel()" class="btn">Exportar a Excel</button>
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
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los registros se agregarán aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
    let usuarios = [];
    let usuariosFiltrados = [];

    window.onload = function() {
        usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
        usuariosFiltrados = [...usuarios];
        mostrarUsuarios();
    };

    function mostrarUsuarios() {
        let tbody = document.querySelector('#tablaUsuarios tbody');
        tbody.innerHTML = '';
        usuariosFiltrados.forEach(function(usuario) {
            let tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${usuario.id_cliente}</td>
                <td>${usuario.nombre}</td>
                <td>${usuario.apellido}</td>
                <td>${usuario.telefono}</td>
                <td>${usuario.genero}</td>
                <td>${usuario.f_registro}</td>
                <td>${usuario.estado}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function filtrarTabla() {
        let filtro = document.getElementById('filtro').value.toLowerCase();
        usuariosFiltrados = usuarios.filter(usuario => 
            usuario.nombre.toLowerCase().includes(filtro) ||
            usuario.apellido.toLowerCase().includes(filtro)
        );
        mostrarUsuarios();
    }

    function exportarExcel() {
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
    }

    document.getElementById('filtro').addEventListener('input', filtrarTabla);
    </script>
</body>
</html>