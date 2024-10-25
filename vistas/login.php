<?php
session_start();
include 'db_connection.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM administradores WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            header("Location: administradores.php");
            exit();
        } else {
            $error_message = "Usuario o contraseña incorrecta";
        }
    } else {
        $error_message = "Usuario o contraseña incorrecta";
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
    <title>Login - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1a202c;
            font-family: Arial, sans-serif;
        }

        .ring {
            position: relative;
            width: 500px;
            height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ring i {
            position: absolute;
            inset: 0;
            border: 2px solid #fff;
            transition: border 0.5s, filter 0.5s;
        }

        .ring i:nth-child(1) {
            border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
            animation: animate 6s linear infinite;
        }

        .ring i:nth-child(2) {
            border-radius: 41% 44% 56% 59% / 38% 62% 63% 37%;
            animation: animate2 4s linear infinite;
        }

        .ring i:nth-child(3) {
            border-radius: 41% 44% 56% 59% / 38% 62% 63% 37%;
            animation: animate 10s linear infinite;
        }

        .ring:hover i {
            border: 6px solid var(--clr);
            filter: drop-shadow(0 0 20px var(--clr));
        }

        .login {
            position: absolute;
            width: 300px;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
            background-color: rgba(0, 0, 0, 0);
            padding: 30px;
            border-radius: 10px;
        }

        .login h2 {
            font-size: 2em;
            color: #fff;
            margin-bottom: 20px;
        }

        .login .inputBx {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .login .inputBx input {
            width: 100%;
            padding: 12px 20px;
            background: transparent;
            border: 2px solid #fff;
            border-radius: 40px;
            font-size: 1em;
            color: #fff;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .login .inputBx input:focus {
            border-color: #f472b6;
        }

        .login .inputBx input[type="submit"] {
            background: linear-gradient(45deg, #db2777, #f472b6);
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: opacity 0.3s ease;
        }

        .login .inputBx input[type="submit"]:hover {
            opacity: 0.9;
        }

        .login .inputBx input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login .links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-top: 20px;
            gap: 15px;
        }

        .login .links a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .login .links a:hover {
            color: #f472b6;
        }

        .error-message {
            color: #ff0000;
            text-align: center;
            margin-bottom: 15px;
        }

        @keyframes animate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes animate2 {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }

        @media (max-width: 600px) {
            .ring {
                width: 300px;
                height: 300px;
            }

            .login {
                width: 250px;
                padding: 20px;
            }

            .login h2 {
                font-size: 1.5em;
            }

            .login .inputBx input {
                font-size: 0.9em;
            }

            .login .links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="ring">
        <i style="--clr:#2afc00;"></i>
        <i style="--clr:#fc00d2;"></i>
        <i style="--clr:#d0ff00;"></i>
        <div class="login">
            <h2>Iniciar Sesión</h2>
            <?php
            if (!empty($error_message)) {
                echo "<p class='error-message'>{$error_message}</p>";
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="inputBx">
                    <input type="text" placeholder="Usuario" name="username" required> 
                </div>
                <div class="inputBx">
                    <input type="password" placeholder="Contraseña" name="password" required>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Ingresar">
                </div>
            </form>
            <div class="links">
                <a href="#">¿Olvidaste tu contraseña?</a>
                <a href="sigup.php">Registrarse</a>
                <a href="dashboard.php">Inicio</a> 
            </div>
        </div>
    </div>
</body>
</html>