<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
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

        body,
        html {
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

        /* Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background-color);
        }

        ::-webkit-scrollbar-thumb {
            background-color: var(--secondary-color);
            border-radius: 6px;
            border: 3px solid var(--background-color);
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: var(--accent-color);
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1rem;
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
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
        }

        .hero {
            flex-grow: 1;
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
            background-image: url('background_image.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 4rem;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h2 {
            font-size: 3.5rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .hero-text p {
            font-size: 1.2rem;
            max-width: 600px;
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .btn-secondary:hover {
            background-color: var(--white);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image-container {
            width: 100%;
            max-width: 600px;
            aspect-ratio: 4 / 3;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .hero-image-cut {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .hero-image-container:hover .hero-image-cut {
            transform: scale(1.05);
        }

        .hero-image-stripe {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(219, 39, 119, 0.7);
            clip-path: polygon(0 0, 30% 0, 0 100%);
            z-index: 1;
        }

        @media (max-width: 1200px) {
            .hero-image-container {
                max-width: 500px;
            }
        }

        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text, .hero-image {
                flex: none;
            }

            .hero-image-container {
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

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

            .hero-text h2 {
                font-size: 2.5rem;
            }

            .hero-image-container {
                max-width: 300px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                <img src="../imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">                    <h1>FITNESS GYM-TINA</h1>
                </div>
                <nav id="main-nav">
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
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
                    <div class="hero-text">
                        <h2>REALIZA TU CAMBIO CON NOSOTROS</h2>
                        <p>Transforma tu cuerpo y alcanza tu máximo potencial. Entrena con nosotros para lograr fuerza,
                            resistencia y bienestar, todo mientras disfrutas de un estilo de vida saludable y activo.
                        </p>
                        <div class="hero-buttons">
                            <a href="login.php" class="btn btn-primary">Unirse Ahora →</a>
                            <a href="#" class="btn btn-secondary">Leer Más →</a>
                        </div>
                    </div>
                    <div class="hero-image">
                        <div class="hero-image-container">
                            <img src="https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg?cs=srgb&dl=pexels-pixabay-414029.jpg&fm=jpg"
                                alt="Pareja entrenando" class="hero-image-cut">
                            <div class="hero-image-stripe"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const mainNav = document.getElementById('main-nav');
            menuToggle.addEventListener('click', () => mainNav.classList.toggle('active'));
        });
    </script>
</body>

</html>