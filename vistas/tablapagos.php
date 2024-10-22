<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Pagos - Fitness Gym-Tina</title>
    <link rel="icon" href="imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">

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
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: var(--primary-color);
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
            transition: background-color 0.3s;
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
                    <img src="imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">
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
            <h2 class="card-title">Tabla de Pagos</h2>
            <div class="search-container">
                <input type="text" id="filtro" class="search-input" placeholder="Buscar por tipo de subscripción...">
                <button onclick="filtrarTabla()" class="btn">Buscar</button>
                <button onclick="exportarExcel()" class="btn">Exportar a Excel</button>
            </div>
            <div class="table-container">
                <table id="tablaPagos">
                    <thead>
                        <tr>
                            <th>ID Pago</th>
                            <th>Tipo de Subscripción</th>
                            <th>Precio</th>
                            <th>Duración</th>
                            <th>Medio de Pago</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
            <div class="pagination" id="pagination">
               
            </div>
        </div>
    </main>

    <script>
        let pagos = JSON.parse(localStorage.getItem('pagos')) || [];
        let pagosFiltrados = [...pagos];
        const itemsPerPage = 10;

        const mostrarPagos = (page = 1) => {
            const tbody = document.querySelector('#tablaPagos tbody');
            tbody.innerHTML = '';
            const start = (page - 1) * itemsPerPage;
            const end = page * itemsPerPage;
            const paginatedItems = pagosFiltrados.slice(start, end);
            paginatedItems.forEach(pago => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${pago.id_pago}</td>
                    <td>${pago.tipo_subscripcion}</td>
                    <td>${pago.precio}</td>
                    <td>${pago.duracion}</td>
                    <td>${pago.medio_pago}</td>
                    <td>${pago.estado}</td>
                    <td>${pago.fecha}</td>
                `;
                tbody.appendChild(tr);
            });
            mostrarPaginacion(page);
        };

        const mostrarPaginacion = (currentPage) => {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const totalPages = Math.ceil(pagosFiltrados.length / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                let btn = document.createElement('button');
                btn.textContent = i;
                btn.classList.toggle('active', i === currentPage);
                btn.onclick = () => mostrarPagos(i);
                pagination.appendChild(btn);
            }
        };

        const filtrarTabla = () => {
            const filtro = document.getElementById('filtro').value.toLowerCase();
            pagosFiltrados = pagos.filter(pago => 
                pago.tipo_subscripcion.toLowerCase().includes(filtro) ||
                pago.medio_pago.toLowerCase().includes(filtro) ||
                pago.estado.toLowerCase().includes(filtro)
            );
            mostrarPagos(1);
        };

        const exportarExcel = () => {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "ID Pago,Tipo de Subscripción,Precio,Duración,Medio de Pago,Estado,Fecha\n";
            pagosFiltrados.forEach(pago => {
                csvContent += `${pago.id_pago},${pago.tipo_subscripcion},${pago.precio},${pago.duracion},${pago.medio_pago},${pago.estado},${pago.fecha}\n`;
            });
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "pagos_gym_tina.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        mostrarPagos();

     
        document.getElementById('filtro').addEventListener('input', filtrarTabla);
    </script>
</body>
</html>