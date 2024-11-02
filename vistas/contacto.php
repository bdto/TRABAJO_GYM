<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Fitness Gym-Tina</title>
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

        /* Scrollbar Styles */
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
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: var(--shadow-md);
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
            z-index: 1;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .gym-info {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gym-details h3 {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .contact-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 1.5rem;
            border-radius: 15px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            background: rgba(255, 255, 255, 0.05);
        }

        .contact-item h4 {
            color: var(--accent-color);
            margin-bottom: 1rem;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .contact-item h4 i {
            font-size: 1.5rem;
        }

        .contact-item p {
            margin-bottom: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        .contact-item a {
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .contact-item a:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }

        @media (max-width: 1024px) {
            .gym-info {
                padding: 2rem;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

            .gym-info {
                padding: 1.5rem;
                grid-template-columns: 1fr;
            }

            .gym-details h3 {
                font-size: 2rem;
            }

            .contact-item {
                padding: 1.25rem;
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
                        <li><a href="informacion.php"><i class="fas fa-info-circle"></i> Nosotros</a></li>
                        <li><a href="servicios.php"><i class="fas fa-dumbbell"></i> Servicios</a></li>
                        <li><a href="contacto.php"><i class="fas fa-envelope"></i> Contacto</a></li>
                        <li><a href="login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
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
                    <div class="gym-info">
                        <div class="gym-details" style="grid-column: 1 / -1;">
                            <h3>Información de Contacto</h3>
                        </div>
                        <div class="contact-item">
                            <h4><i class="fas fa-map-marker-alt"></i> Ubicación</h4>
                            <p>Calle Fitness 123, Ciudad Deportiva</p>
                        </div>
                        <div class="contact-item">
                            <h4><i class="fas fa-phone-alt"></i> Teléfonos</h4>
                            <p>Tina: (310) 334-1089</p>
                            <p>Entrenador Brayhan: (313) 424-8541</p>
                            <p>Entrenador Lenin: (300) 752-9192</p>
                            <p>Señora Marina: (320) 455-9859</p>
                            <p>Celador: (57+) 456-7890</p>
                        </div>
                        <div class="contact-item">
                            <h4><i class="fas fa-envelope"></i> Email</h4>
                            <p><a href="mailto:GYMTINA2000@gmail.com">
                                <i class="fas fa-envelope"></i>
                                GYMTINA2000@gmail.com
                            </a></p>
                        </div>
                        <div class="contact-item">
                            <h4><i class="fas fa-clock"></i> Horario</h4>
                            <p>Lunes a Viernes: 5:00 AM - 10:00 PM</p>
                            <p>Sábados: 8:00 AM - 10:00 PM</p>
                            <p>Domingos: 8:00 AM - 10:00 PM</p>
                        </div>
                        <div class="contact-item">
                            <h4><i class="fas fa-user"></i> Propietaria</h4>
                            <p>Tina Andersen</p>
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

            // efectos de diseño del header
            window.addEventListener('scroll', () => {
                if (window.scrollY > 

 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // menu mobile 
            menuToggle.addEventListener('click', () => {
                mainNav.classList.toggle('active');
            });

            // cerrar el menu mobil cuando le de click afuera
            document.addEventListener('click', (e) => {
                if (!menuToggle.contains(e.target) && !mainNav.contains(e.target)) {
                    mainNav.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
