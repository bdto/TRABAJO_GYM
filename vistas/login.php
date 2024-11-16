<?php
session_start();

$error_message = '';

// Solo se muestra el formulario de login si ya se ingresó el código de acceso correctamente
$show_login_form = isset($_SESSION['access_granted']) && $_SESSION['access_granted'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$show_login_form && isset($_POST['access_password'])) {
        // Verificación del código de acceso
        if ($_POST['access_password'] === '010203') {
            $_SESSION['access_granted'] = true; // Guardar en sesión que se ha ingresado el código
            $show_login_form = true;
        } else {
            $error_message = "Contraseña de acceso incorrecta";
        }
    } elseif ($show_login_form) {
        // Verificación de usuario y contraseña
        $username = $_POST['username'];
        $password = $_POST['password'];

        $authenticated = false;
        $user_exists = false;

        if (isset($_SESSION['administrators'])) {
            foreach ($_SESSION['administrators'] as $admin) {
                if ($admin['nombre'] === $username) {
                    $user_exists = true;
                    if (password_verify($password, $admin['password'])) {
                        $authenticated = true;
                        break;
                    } else {
                        $error_message = "Contraseña Incorrecta";
                        break;
                    }
                }
            }
            if (!$user_exists) {
                $error_message = "Usuario Incorrecto";
            }
        }

        if ($authenticated) {
            header("Location: administradores.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #db2777;
            --accent-color: #f472b6;
            --background-color: #f3f4f6;
            --text-color: #333;
            --white: #fff;
            --error-color: #ef4444;
            --success-color: #10b981;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--primary-color);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .login-container {
            position: relative;
            width: 400px;
            height: 500px;
            perspective: 2000px;
        }

        .background-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.2;
            animation: float 15s infinite;
        }

        .shape:nth-child(1) {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background-color: var(--secondary-color);
            border-radius: 50%;
        }

        .shape:nth-child(2) {
            top: 70%;
            right: 15%;
            width: 150px;
            height: 150px;
            background-color: var(--accent-color);
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }

        .shape:nth-child(3) {
            top: 40%;
            left: 20%;
            width: 80px;
            height: 80px;
            background-color: var(--success-color);
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        .ring {
            position: absolute;
            width: 200%;
            height: 200%;
            left: -50%;
            top: -50%;
            transform-style: preserve-3d;
            animation: rotate 20s infinite linear;
        }

        @keyframes rotate {
            0% { transform: rotateY(0deg) rotateX(0deg); }
            100% { transform: rotateY(360deg) rotateX(360deg); }
        }

        .ring i {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px solid var(--accent-color);
            border-radius: 50%;
            transition: var(--transition);
            opacity: 0.1;
        }

        .ring i:nth-child(1) { transform: rotateY(0deg) translateZ(300px); }
        .ring i:nth-child(2) { transform: rotateY(120deg) translateZ(300px); }
        .ring i:nth-child(3) { transform: rotateY(240deg) translateZ(300px); }

        .login-form {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transform-style: preserve-3d;
            animation: formFloat 6s ease-in-out infinite;
        }

        @keyframes formFloat {
            0%, 100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
            50% { transform: translateY(-20px) rotateX(5deg) rotateY(5deg); }
        }

        .login-form h2 {
            font-size: 2.5em;
            color: var(--white);
            margin-bottom: 30px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateZ(50px);
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 30px;
            transform: translateZ(30px);
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid var(--accent-color);
            border-radius: 40px;
            font-size: 1em;
            color: var(--white);
            outline: none;
            transition: var(--transition);
        }

        .input-group input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 15px rgba(219, 39, 119, 0.3);
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            transition: var(--transition);
        }

        .input-group input:focus + i {
            color: var(--secondary-color);
            transform: translateY(-50%) scale(1.2);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, var(--secondary-color), var(--accent-color));
            border: none;
            border-radius: 40px;
            color: var(--white);
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            transform: translateZ(40px);
        }

        .submit-btn:hover {
            transform: translateZ(40px) translateY(-3px);
            box-shadow: 0 5px 15px rgba(219, 39, 119, 0.4);
        }

        .links {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 20px;
            transform: translateZ(20px);
        }

        .links a {
            color: var(--accent-color);
            font-size: 0.9em;
            text-decoration: none;
            transition: var(--transition);
        }

        .links a:hover {
            color: var(--secondary-color);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.9em;
            margin-bottom: 20px;
            transform: translateZ(20px);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="login-container">
        <div class="ring">
            <i></i>
            <i></i>
            <i></i>
        </div>
        <div class="login-form">
            <h2><?php echo $show_login_form ? 'Iniciar Sesión' : 'Acceso'; ?></h2>
            <?php
            if (!empty($error_message)) {
                echo "<p class='error-message'>{$error_message}</p>";
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <?php if (!$show_login_form): ?>
                    <!-- Formulario para el código de acceso -->
                    <div class="input-group">
                        <input type="password" placeholder="Contraseña de acceso" name="access_password" required>
                        <i class="fas fa-key"></i>
                    </div>
                    <button type="submit" class="submit-btn">Acceder</button>
                <?php else: ?>
                    <!-- Formulario de login (usuario y contraseña) -->
                    <div class="input-group">
                        <input type="text" placeholder="Usuario" name="username" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-group">
                        <input type="password" placeholder="Contraseña" name="password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <button type="submit" class="submit-btn">Ingresar</button>
                <?php endif; ?>
            </form>
            <div class="links">
                <a href="sigup.php">Registrarse</a>
                <a href="index.php">Inicio</a> 
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('mousemove', (e) => {
            const loginForm = document.querySelector('.login-form');
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            loginForm.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg) translateZ(50px)`;
        });
    </script>
</body>
</html>
