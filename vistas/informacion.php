<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información - Fitness Gym-Tina</title>
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
            display: flex;
            justify-content: space-between;
            gap: 4rem;
            align-items: stretch;
        }

        .gym-info {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gym-bio h3 {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 2rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .gym-bio p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
        }

        .image-gallery {
            flex: 1;
            max-width: 600px;
            height: 600px;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out, transform 0.3s ease-in-out;
            object-fit: cover;
        }

        .gallery-image.active {
            opacity: 1;
        }

        .image-gallery:hover .gallery-image.active {
            transform: scale(1.05);
        }

        @media (max-width: 1200px) {
            .hero-content {
                flex-direction: column;
                align-items: center;
            }

            .gym-info {
                max-width: 800px;
                width: 100%;
            }

            .image-gallery {
                width: 100%;
                height: 400px;
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

            .gym-bio h3 {
                font-size: 2.5rem;
            }

            .gym-bio p {
                font-size: 1rem;
            }

            .hero {
                padding: 3rem 0;
            }

            .gym-info {
                padding: 2rem;
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
                        <div class="gym-bio">
                            <h3><i class="fas fa-history"></i> Nuestra Historia</h3>
                            <p>Tina Andersen, nacida en Dinamarca el 14 de julio de 1967, se trasladó a Colombia a los 19 años. Con una formación en ballet, jazz y danza contemporánea, decidió abrir su primer gimnasio, "Gimnasio Tina's", a los 20 años, impulsada por su pasión por el movimiento y la salud.</p>
                            <p>En 2004, fundó "Gym Tina", comenzando con solo cinco máquinas, pero logrando un crecimiento constante gracias a su dedicación y al apoyo de la comunidad de Honda, Tolima.</p>
                            <p>A lo largo de los años, Tina ha construido fuertes lazos con sus clientes, incluidos turistas y extranjeros, convirtiéndose en una figura clave en el ámbito fitness local. Orgullosa de contribuir al bienestar físico de las generaciones presentes y futuras, Tina sigue comprometida con su gimnasio, siendo un referente en la ciudad y promoviendo un estilo de vida saludable para todos.</p>
                        </div>
                    </div>
                    <div class="image-gallery">
                        <img src="../imagenes/WhatsApp Image 2024-10-16 at 3.40.24 PM.jpeg" 
                             alt="Gym Image 1" 
                             class="gallery-image active"
                             src='../imagenes/default-gym.jpg'>
                        <img src="../imagenes/WhatsApp Image 2024-10-16 at 8.02.46 PM (2).jpeg" 
                             alt="Gym Image 2" 
                             class="gallery-image"
                            src='../imagenes/default-gym.jpg'>
                        <img src="../imagenes/WhatsApp Image 2024-10-16 at 8.02.46 PM.jpeg" 
                             alt="Gym Image 3" 
                             class="gallery-image"
                             src='../imagenes/default-gym.jpg'>   
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

            // cambios de transaciones delas imagenes de la galeria 
            const images = document.querySelectorAll('.gallery-image');
            let currentImage = 0;

            function rotateImages() {
                images[currentImage].classList.remove('active');
                currentImage = (currentImage + 1) % images.length;
                images[currentImage].classList.add('active');
            }

            if (images.length > 0) {
                setInterval(rotateImages, 5000);
            }
        });
    </script>
</body>
</html>