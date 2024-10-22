<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Fitness Gym-Tina</title>
    <link rel="icon" href="imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #db2777;
            --accent-color: #f472b6;
            --text-color: #333;
            --background-color: #f5f5f5;
            --white: #fff;
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
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1rem;
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
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
            color: var(--accent-color);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
        }

        .login-btn {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: all 0.3s;
        }

        .login-btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding-top: 80px;
        }

        .hero {
            min-height: calc(100vh - 80px);
            position: relative;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 4rem 0;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .gym-info {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .gym-details h3 {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .contact-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact-item h4 {
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .contact-item p {
            margin-bottom: 0.5rem;
        }

        .contact-item a {
            color: var(--white);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-item a:hover {
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--primary-color);
                padding: 1rem;
            }

            nav.active {
                display: block;
            }

            nav ul {
                flex-direction: column;
                gap: 1rem;
            }

            .gym-details h3 {
                font-size: 1.75rem;
            }

            .gym-info {
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
                <img src="../imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">                    <h1>GYM-TINA</h1>
                </div>
                <nav id="main-nav">
                    <ul>
                        <li><a href="dashboard.php">Inicio</a></li>
                        <li><a href="informacion.php">Nosotros</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                        <li><a href="login.php" class="login-btn">Login</a></li>
                    </ul>
                </nav>
                <button class="menu-toggle" id="menu-toggle">☰</button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="gym-info">
                        <div class="gym-details">
                            <h3>Información de Contacto</h3>
                        </div>
                        <div class="contact-item">
                            <h4>Ubicación</h4>
                            <p>Calle Fitness 123, Ciudad Deportiva</p>
                        </div>
                        <div class="contact-item">
                            <h4>Teléfonos</h4>
                            <p>Tina: (310) 334-1089</p>
                            <p>Entrenador Brayhan: (313) 424-8541</p>
                            <p>Entrenador Lenin: (300) 752-9192</p>
                            <p>Señora Marina: (320) 455-9859</p>
                            <p>Celador: (57+) 456-7890</p>
                        </div>
                        <div class="contact-item">
                            <h4>Email</h4>
                            <p><a href="mailto:info@gymtina.com">info@gymtina.com</a></p>
                        </div>
                        <div class="contact-item">
                            <h4>Horario</h4>
                            <p>Lunes a Viernes: 5:00 AM - 10:00 PM</p>
                            <p>Sábados: 8:00 AM - 10:00 PM</p>
                            <p>Domingos: 8:00 AM - 10:00 PM</p>
                        </div>
                        <div class="contact-item">
                            <h4>Propietaria</h4>
                            <p>Tina Andersen</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mainNav = document.getElementById('main-nav');
            menuToggle.addEventListener('click', () => mainNav.classList.toggle('active'));
        });
    </script>
</body>
</html>