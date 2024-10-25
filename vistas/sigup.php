<?php
// Use __DIR__ to get the current directory and construct the path to db_connection.php
$db_connection_path = __DIR__ . '/../db_connection.php';

// Check if the file exists before including it
if (file_exists($db_connection_path)) {
    include $db_connection_path;
} else {
    die("Error: db_connection.php file not found. Path: " . $db_connection_path);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $nombre = $_POST['nombre'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO administradores (admin_id, nombre, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $admin_id, $nombre, $password);

    if ($stmt->execute()) {
        $message = "Registro exitoso";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM-TINA - Registro</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <style>
        :root {
            --primary-color: #ff007398;
            --primary-dark: #be185d;
            --secondary-color: #f472b6;
            --background-color: #f5f5f5;
            --text-color: #333;
            --header-bg: #1a202c;
            --card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Arial', sans-serif;
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
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
        }

        nav a:hover {
            color: var(--secondary-color);
        }

        .login-btn {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: background-color 0.3s;
            font-weight: 500;
        }

        .login-btn:hover {
            background-color: var(--primary-dark);
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
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .signup-card:hover {
            transform: translateY(-5px);
        }

        .signup-card h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
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
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(219, 39, 119, 0.2);
        }

        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .submit-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        footer {
            background-color: var(--header-bg);
            color: #fff;
            text-align: center;
            padding: 1rem;
        }

        .menu-toggle {
            display: none;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            }

            .login-btn {
                display: none;
            }

            .menu-toggle {
                display: block;
                background: none;
                border: none;
                color: #fff;
                font-size: 1.5rem;
                cursor: pointer;
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
                        <li><a href="dashboard.php">Inicio</a></li>
                        <li><a href="informacion.php">Sobre Nosotros</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </nav>
                <a href="login.php" class="login-btn">Login</a>
                <button class="menu-toggle" id="menu-toggle">☰</button>
            </div>
        </div>
    </header>

    <main>
        <div class="signup-card">
            <h2>Registro</h2>
            <?php
            if (!empty($message)) {
                $messageClass = strpos($message, 'Error') !== false ? 'error' : 'success';
                echo "<div class='message {$messageClass}'>{$message}</div>";
            }
            ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="admin_id">ID de Administrador</label>
                    <input type="text" id="admin_id" name="admin_id" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">Crear cuenta</button>
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
        });
    </script>
</body>
</html>