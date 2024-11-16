<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #db2777;
            --accent-color: #f472b6;
            --text-color: #333;
            --background-color: #f5f5f5;
            --white: #fff;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Segoe UI', 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        body {
            display: flex;
            flex-direction: column;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background-color);
        }

        ::-webkit-scrollbar-thumb {
            background-color: var(--secondary-color);
            border-radius: 6px;
            border: 2px solid var(--background-color);
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: var(--accent-color);
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1.25rem;
            box-shadow: var(--shadow-md);
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: var(--transition);
        }

        header.scrolled {
            padding: 1rem;
            background-color: rgba(26, 32, 44, 0.95);
            backdrop-filter: blur(10px);
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
            gap: 1.5rem;
        }

        .logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            transition: var(--transition);
            border: 2px solid var(--accent-color);
        }

        .logo img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(244, 114, 182, 0.3);
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent-color);
            letter-spacing: 0.5px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        nav a i {
            font-size: 1.1rem;
        }

        nav a:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .login-btn {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            transition: var(--transition);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            border: none;
            font-size: 1rem;
            text-decoration: none;
        }

        .login-btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding-top: 92px;
        }

        .hero {
            min-height: calc(100vh - 92px);
            position: relative;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 6rem 0;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 32, 44, 0.95), rgba(26, 32, 44, 0.8));
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
            max-width: 600px;
        }

        .hero-text h2 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero-text p {
            font-size: 1.25rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
        }

        .btn i {
            transition: var(--transition);
        }

        .btn:hover i {
            transform: translateX(4px);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
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
            max-width: 600px;
        }

        .hero-image-container {
            width: 100%;
            aspect-ratio: 16/9;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        .hero-image-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        .hero-image-cut {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .hero-image-container:hover .hero-image-cut {
            transform: scale(1.05);
        }

        .hero-image-stripe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(219, 39, 119, 0.7), rgba(244, 114, 182, 0.7));
            clip-path: polygon(0 0, 40% 0, 0 100%);
            transition: var(--transition);
        }

        .hero-image-container:hover .hero-image-stripe {
            clip-path: polygon(0 0, 50% 0, 0 100%);
        }

        @media (max-width: 1200px) {
            .container {
                padding: 0 1.5rem;
            }

            .hero-text h2 {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text {
                max-width: 800px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image {
                max-width: 500px;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem;
            }

            .logo img {
                width: 50px;
                height: 50px;
            }

            .logo h1 {
                font-size: 1.5rem;
            }

            nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--primary-color);
                padding: 1rem;
                box-shadow: var(--shadow-md);
            }

            nav.active {
                display: block;
            }

            nav ul {
                flex-direction: column;
                gap: 0.5rem;
            }

            nav a {
                padding: 1rem;
                border-radius: 8px;
            }

            .menu-toggle {
                display: block;
                background: none;
                border: none;
                color: var(--white);
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0.5rem;
            }

            .hero {
                padding: 4rem 0;
            }

            .hero-text h2 {
                font-size: 2.5rem;
            }

            .hero-text p {
                font-size: 1.1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header id="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="../imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">
                    <h1>FITNESS GYM-TINA</h1>
                </div>
                <nav id="main-nav">
                    <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
                        <li><a href="../vistas/informacion.php"><i class="fas fa-info-circle"></i> Nosotros</a></li>
                        <li><a href="../vistas/servicios.php"><i class="fas fa-dumbbell"></i> Servicios</a></li>
                        <li><a href="../vistas/contacto.php"><i class="fas fa-envelope"></i> Contacto</a></li>
                        <li><a href="../vistas/login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    </ul>
                </nav>
                <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
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
                            resistencia y bienestar, todo mientras disfrutas de un estilo de vida saludable y activo.</p>
                        <div class="hero-buttons">
                            <a href="../vistas/login.php" class="btn btn-primary">
                                <span>Unirse Ahora</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="../vistas/informacion.php" class="btn btn-secondary">
                                <span>Leer Más</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="hero-image">
                        <div class="hero-image-container">
                            <img src="https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg?cs=srgb&dl=pexels-pixabay-414029.jpg&fm=jpg"
                                alt="Pareja entrenando" 
                                class="hero-image-cut">
                            <div class="hero-image-stripe"></div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const menuToggle = document.getElementById('menu-toggle');
            const mainNav = document.getElementById('main-nav');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            menuToggle.addEventListener('click', () => {
                mainNav.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!menuToggle.contains(e.target) && !mainNav.contains(e.target)) {
                    mainNav.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>