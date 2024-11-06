<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Fitness Gym-Tina</title>
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
            --info-color: #4299e1;
            --error-color: #f56565;
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
            object-fit: cover;
            border: 2px solid var(--accent-color);
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
            gap: 1.5rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
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
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }

        .card-header {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 50%);
            transform: rotate(30deg);
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: bold;
            position: relative;
            z-index: 1;
        }

        .card-content {
            padding: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.2);
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
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            max-width: 300px;
            margin: 2rem auto 0;
        }

        button:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-card {
            background-color: var(--card-background);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
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

        .bg-blue { background-color: var(--info-color); color: #fff; }
        .bg-green { background-color: var(--success-color); color: #fff; }
        .bg-orange { background-color: var(--warning-color); color: #fff; }

        .error-message {
            color: var(--error-color);
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

            .form-grid {
                grid-template-columns: 1fr;
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
                        <li><a href="usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> Pagos</a></li>
                        <li><a href="administradores.php"><i class="fas fa-user-shield"></i> Administradores</a></li>
                        <li><a href="tablapagos.php"><i class="fas fa-table"></i> Tabla Pagos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-money-bill-wave"></i> <span id="formTitle">Registrar Pago</span></h2>
            </div>
            <div class="card-content">
                <form id="paymentForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="id_pagos">ID Pagos:</label>
                            <input type="text" id="id_pagos" name="id_pagos" required>
                        </div>
                        <div class="form-group">
                            <label for="id_cliente">ID Cliente:</label>
                            <input type="text" id="id_cliente" name="id_cliente" required>
                            <span class="error-message" id="id_cliente_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="id_admin">ID Admin:</label>
                            <input type="text" id="id_admin" name="id_admin" required>
                            <span class="error-message" id="id_admin_error"></span>
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
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="">Seleccionar</option>
                                <option value="pagado">Pagado</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="submitBtn"><i class="fas fa-save"></i> <span id="submitBtnText">Registrar Pago</span></button>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header bg-blue">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Total Recaudado</span>
                </div>
                <div class="stat-content" id="totalRecaudado">
                    $0
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-green">
                    <i class="fas fa-chart-line"></i>
                    <span>Pagos del Mes</span>
                </div>
                <div class="stat-content" id="pagosMes">
                    0
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header bg-orange">
                    <i class="fas fa-clock"></i>
                    <span>Pagos Pendientes</span>
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

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('paymentForm');
            const idPagosInput = document.getElementById('id_pagos');
            const tipoSubscripcionSelect = document.getElementById('tipo_subscripcion');
            const precioInput = document.getElementById('precio');
            const duracionInput = document.getElementById('duracion');
            const idClienteInput = document.getElementById('id_cliente');
            const idAdminInput = document.getElementById('id_admin');
            const idClienteError =   document.getElementById('id_cliente_error');
            const idAdminError = document.getElementById('id_admin_error');
            const formTitle = document.getElementById('formTitle');
            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');

            let pagos = JSON.parse(localStorage.getItem('pagos')) || [];
            let editingPaymentId = null;

            // Check if we're in edit mode
            const urlParams = new URLSearchParams(window.location.search);
            const isEditing = urlParams.get('editar') === 'true';

            if (isEditing) {
                const paymentToEdit = JSON.parse(localStorage.getItem('pagoEditar'));
                if (paymentToEdit) {
                    fillFormWithPaymentData(paymentToEdit);
                    editingPaymentId = paymentToEdit.id_pagos;
                    formTitle.textContent = 'Editar Pago';
                    submitBtnText.textContent = 'Actualizar Pago';
                    idPagosInput.removeAttribute('readonly');
                }
            } else {
                idPagosInput.value = pagos.length > 0 ? Math.max(...pagos.map(p => parseInt(p.id_pagos))) + 1 : 1;
                idPagosInput.setAttribute('readonly', true);
            }

            updateStats();

            tipoSubscripcionSelect.addEventListener('change', function() {
                const selectedType = this.value;
                const data = subscriptionData[selectedType];
                if (data) {
                    precioInput.value = data.precio;
                    duracionInput.value = data.duracion;
                } else {
                    precioInput.value = '';
                    duracionInput.value = '';
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate ID Cliente
                if (!/^\d+$/.test(idClienteInput.value)) {
                    idClienteError.textContent = 'ID Cliente debe ser un número';
                    return;
                } else {
                    idClienteError.textContent = '';
                }

                // Validate ID Admin
                if (!/^\d+$/.test(idAdminInput.value)) {
                    idAdminError.textContent = 'ID Admin debe ser un número';
                    return;
                } else {
                    idAdminError.textContent = '';
                }

                const formData = new FormData(form);
                const paymentData = Object.fromEntries(formData.entries());

                if (isEditing) {
                    // Update existing payment
                    const index = pagos.findIndex(p => p.id_pagos == editingPaymentId);
                    if (index !== -1) {
                        pagos[index] = paymentData;
                    }
                } else {
                    // Add new payment
                    pagos.push(paymentData);
                }

                localStorage.setItem('pagos', JSON.stringify(pagos));

                // Update stats
                updateStats();

                // Reset form and redirect
                alert(isEditing ? 'Pago actualizado exitosamente.' : 'Pago registrado exitosamente.');
                window.location.href = 'tablapagos.php';
            });

            function fillFormWithPaymentData(payment) {
                for (const [key, value] of Object.entries(payment)) {
                    const input = document.getElementById(key);
                    if (input) {
                        input.value = value;
                    }
                }
            }

            function updateStats() {
                const totalRecaudado = pagos.reduce((total, pago) => total + Number(pago.precio), 0);
                const currentDate = new Date();
                const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                const pagosMes = pagos.filter(pago => new Date(pago.fecha) >= firstDayOfMonth).length;
                const pagosPendientes = pagos.filter(pago => pago.estado === 'pendiente').length;

                document.getElementById('totalRecaudado').textContent = `$${totalRecaudado.toLocaleString()}`;
                document.getElementById('pagosMes').textContent = pagosMes;
                document.getElementById('pagosPendientes').textContent = pagosPendientes;
            }
        });
    </script>
</body>
</html>