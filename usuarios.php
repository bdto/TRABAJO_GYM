<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Fitness Gym-Tina</title>
    <link rel="icon" href="imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">

    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #f472b6;
            --text-color: #333;
            --background-color: #f5f5f5;
            --card-background: #ffffff;
            --border-color: #e5e7eb;
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
            background-color: var(--secondary-color);
            color: var(--primary-color);
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
            color: var(--primary-color);
            padding: 1rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-content {
            padding: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 1rem;
        }

        button {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.25rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            display: block;
            margin: 1rem auto 0;
        }

        button:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .stat-card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            padding: 1rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-content {
            padding: 1rem;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
        }

        .bg-blue { background-color: #3498db; color: #fff; }
        .bg-green { background-color: #2ecc71; color: #fff; }
        .bg-red { background-color: #e74c3c; color: #fff; }

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
                    <img src="imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">
                    <h1>FITNESS GYM-TINA</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="usuarios.php">Usuarios</a></li>
                        <li><a href="pagos.php">Pagos</a></li>
                        <li><a href="administradores.php">Administradores</a></li>
                        <li><a href="tablausuarios.php">Tabla Usuarios</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Registrar Usuario</h2>
            </div>
            <div class="card-content">
                <form id="userForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="id_cliente">ID Cliente:</label>
                            <input type="text" id="id_cliente" name="id_cliente" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="id_admin">ID Admin:</label>
                            <input type="text" id="id_admin" name="id_admin" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="genero">Género:</label>
                            <select id="genero" name="genero" required>
                                <option value="">Seleccionar</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_registro">Fecha de Registro:</label>
                            <input type="date" id="fecha_registro" name="fecha_registro" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="">Seleccionar</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit">Registrar Usuario</button>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header bg-blue">
                    <span>👥 Total Usuarios</span>
                </div>
                <div class="stat-content" id="totalUsuarios">
                    0
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-green">
                    <span>💳 Pagos al Día</span>
                </div>
                <div class="stat-content" id="pagosAlDia">
                    0
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-red">
                    <span>⚠️ Pagos Pendientes</span>
                </div>
                <div class="stat-content" id="pagosPendientes">
                    0
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userForm');
            const idClienteInput = document.getElementById('id_cliente');
            const totalUsuariosElement = document.getElementById('totalUsuarios');

            // Load existing users and set initial ID
            let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
            idClienteInput.value = usuarios.length > 0 ? Math.max(...usuarios.map(u => parseInt(u.id_cliente))) + 1 : 1;

            totalUsuariosElement.textContent = usuarios.length;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const newUser = Object.fromEntries(formData.entries());

               
                const isDuplicate = usuarios.some(usuario => 
                    usuario.nombre === newUser.nombre &&
                    usuario.apellido === newUser.apellido &&
                    usuario.telefono === newUser.telefono &&
                    usuario.genero === newUser.genero
                );

                if (isDuplicate) {
                    alert('Ya existe un registro con estos datos.');
                    return;
                }

              
                usuarios.push(newUser);
                localStorage.setItem('usuarios', JSON.stringify(usuarios));

                
                totalUsuariosElement.textContent = usuarios.length;

             
                form.reset();
                idClienteInput.value = parseInt(idClienteInput.value) + 1;

                alert('Usuario registrado exitosamente.');
            });
        });
    </script>
</body>
</html>