<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Fitness Gym-Tina</title>
    <link rel="icon" href="imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #f472b6;
            --text-color: #333;
            --background-color: #f5f5f5;
            --card-background: #ffffff;
            --border-color: #e5e7eb;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --info-color: #4299e1;
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
            padding: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
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
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--secondary-color);
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
            gap: 1.5rem;
        }

        .stat-card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            padding: 1.5rem;
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .bg-blue { background-color: var(--info-color); color: #fff; }
        .bg-green { background-color: var(--success-color); color: #fff; }
        .bg-orange { background-color: var(--warning-color); color: #fff; }

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
                        <li><a href="tablapagos.php">Tabla Pagos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Registrar Pago</h2>
            </div>
            <div class="card-content">
                <form id="paymentForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="id_pago">ID Pago:</label>
                            <input type="text" id="id_pago" name="id_pago" required readonly value="AUTO_INCREMENT">
                        </div>
                        <div class="form-group">
                            <label for="tipo_subscripcion">Tipo de Subscripción:</label>
                            <select id="tipo_subscripcion" name="tipo_subscripcion" required>
                                <option value="">Seleccionar</option>
                                <option value="mensualidad">Mensualidad</option>
                                <option value="rutina">Rutina</option>
                                <option value="semanal">Semanal</option>
                                <option value="quincenal">Quincenal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" id="precio" name="precio" readonly>
                        </div>
                        <div class="form-group">
                            <label for="duracion">Duración:</label>
                            <input type="text" id="duracion" name="duracion" readonly>
                        </div>
                        <div class="form-group">
                            <label for="medio_pago">Medio de Pago:</label>
                            <select id="medio_pago" name="medio_pago" required>
                                <option value="">Seleccionar</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="">Seleccionar</option>
                                <option value="pagado">Pagado</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" required>
                        </div>
                    </div>
                    <button type="submit">Registrar Pago</button>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header bg-blue">
                    <span>💰 Total Recaudado</span>
                </div>
                <div class="stat-content" id="totalRecaudado">
                    $0
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-green">
                    <span>📊 Pagos del Mes</span>
                </div>
                <div class="stat-content" id="pagosMes">
                    0
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-orange">
                    <span>⏳ Pagos Pendientes</span>
                </div>
                <div class="stat-content" id="pagosPendientes">
                    0
                </div>
            </div>
        </div>
    </main>

    <script>
        const subscriptionData = {
            mensualidad: { precio: 60000, duracion: '30 días' },
            rutina: { precio: 10000, duracion: '24 horas' },
            semanal: { precio: 30000, duracion: '7 días' },
            quincenal: { precio: 40000, duracion: '15 días' }
        };

        document.getElementById('tipo_subscripcion').addEventListener('change', function() {
            const selectedType = this.value;
            const data = subscriptionData[selectedType];
            if (data) {
                document.getElementById('precio').value = data.precio;
                document.getElementById('duracion').value = data.duracion;
            } else {
                document.getElementById('precio').value = '';
                document.getElementById('duracion').value = '';
            }
        });

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const payment = Object.fromEntries(formData.entries());
            payment.id_pago = Date.now().toString(); 
            payment.fecha = new Date().toISOString().split('T')[0]; 

            let pagos = JSON.parse(localStorage.getItem('pagos')) || [];
            pagos.push(payment);
            localStorage.setItem('pagos', JSON.stringify(pagos));

            alert('Pago registrado con éxito');
            this.reset();
            updateStats();
        });

        function updateStats() {
            const pagos = JSON.parse(localStorage.getItem('pagos')) || [];
            const currentDate = new Date();
            const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

            const totalRecaudado = pagos.reduce((total, pago) => total + Number(pago.precio), 0);
            const pagosMes = pagos.filter(pago => new Date(pago.fecha) >= firstDayOfMonth).length;
            const pagosPendientes = pagos.filter(pago => pago.estado === 'pendiente').length;

            document.getElementById('totalRecaudado').textContent = `$${totalRecaudado.toLocaleString()}`;
            document.getElementById('pagosMes').textContent = pagosMes;
            document.getElementById('pagosPendientes').textContent = pagosPendientes;
        }

        
        document.getElementById('fecha').valueAsDate = new Date();

        
        window.onload = updateStats;
    </script>
</body>
</html>