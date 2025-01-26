<?php
session_start();
require_once __DIR__ . '/../controlador/pagoscontroller.php';

$message = '';
$adminIdError = '';
$controller = new PagosController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    // Check if the admin ID already exists
    if ($controller->adminIdExists($id)) {
        $adminIdError = "ID NO DISPONIBLE";
    } else {
        // Existing registration logic
        $usuario = $_POST['usuario'];
        $plain_password = $_POST['password'];

        $datos = [
            'id' => $id,
            'usuario' => $usuario,
            'password' => $plain_password
        ];

        $result = $controller->registrarPago($datos);

        if ($result['success']) {
            $message = "<p class='success'>{$result['message']} <a href='login.php'>Iniciar sesión</a></p>";
        } else {
            $message = "<p class='error'>{$result['message']}</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM-TINA - Registro</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #e91e63;
            --primary-dark: #c2185b;
            --secondary-color: #ff4081;
            --background-color: #f5f5f5;
            --text-color: #333;
            --header-bg: #1a202c;
            --card-bg: #ffffff;
            --input-bg: #f0f0f0;
            --input-border: #d1d1d1;
            --input-focus: #ff4081;
            --button-hover: #ad1457;
            --success-bg: #d4edda;
            --success-color: #155724;
            --error-bg: #f8d7da;
            --error-color: #721c24;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Roboto', 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: var(--header-bg);
            color: #fff;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
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
            border: 2px solid var(--secondary-color);
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.1);
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
            position: relative;
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--secondary-color);
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        .login-btn {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .login-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .signup-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .signup-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .signup-card h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--input-border);
            border-radius: 25px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--input-bg);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(255, 64, 129, 0.2);
        }

        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .submit-btn:hover {
            background-color: var(--button-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
        }

        footer {
            background-color: var(--header-bg);
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .success {
            background-color: var(--success-bg);
            color: var(--success-color);
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: var(--error-bg);
            color: var(--error-color);
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            nav.active ul {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--header-bg);
                padding: 1rem;
                z-index: 1000;
            }

            .login-btn {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .signup-card {
                padding: 2rem;
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
                    <h1>GYM-TINA</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="../index.php"><i class="fas fa-home"></i> Inicio</a></li>
                        <li><a href="informacion.php"><i class="fas fa-info-circle"></i> Sobre Nosotros</a></li>
                        <li><a href="servicios.php"><i class="fas fa-dumbbell"></i> Servicios</a></li>
                        <li><a href="contacto.php"><i class="fas fa-envelope"></i> Contacto</a></li>
                    </ul>
                </nav>
                <a href="login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
                <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </header>

    <main>
        <div class="signup-card">
            <h2><i class="fas fa-user-plus"></i> Registro</h2>
            <?php
            if (!empty($message)) {
                echo $message;
            }
            ?>
            <form method="POST" action="procesar_registro.php">
                <input type="hidden" name="action" value="registrar">
                <div class="form-group">
                    <label for="id"><i class="fas fa-id-card"></i> ID de Administrador</label>
                    <input type="text" id="id" name="id" required value="<?php echo isset($_POST['id']) ? htmlspecialchars($_POST['id']) : ''; ?>">
                    <?php if (!empty($adminIdError)): ?>
                        <p class="error-message"><?php echo $adminIdError; ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="usuario"><i class="fas fa-user"></i> Nombre Usuario</label>
                    <input type="text" id="usuario" name="usuario" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Crear cuenta</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 GYM-TINA. Todos los derechos reservados.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const nav = document.querySelector('nav');
            menuToggle.addEventListener('click', () => {
                nav.classList.toggle('active');
            });

            // Validación del campo ID de administrador
            const idInput = document.getElementById('id');
            const errorMessage = document.createElement('p');
            errorMessage.className = 'error-message';
            idInput.parentNode.appendChild(errorMessage);
    
            idInput.addEventListener('input', function() {
                if (!/^\d*$/.test(this.value)) {
                    errorMessage.textContent = 'Dato inválido para introducir';
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

