<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información - Fitness Gym-Tina</title>
    <link rel="icon" href="imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #1a202c;
            color: #fff;
            padding: 1rem;
            position: fixed;
            width: 100%;
            z-index: 1000;
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
        }

        nav a:hover {
            color: #f472b6;
        }

        .login-btn {
            background-color: #db2777;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #be185d;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
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
            background-color: #1a202c;
            color: #fff;
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
            display: flex;
            justify-content: space-between;
            gap: 4rem;
            align-items: stretch;
            height: 100%;
        }

        .gym-info {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .gym-bio h3 {
            font-size: 2.5rem;
            color: #f472b6;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .gym-bio p {
            margin-bottom: 1.5rem;
            text-align: left;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .image-gallery {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 600px;
            height: 500px;
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            object-fit: cover;
        }

        .gallery-image.active {
            opacity: 1;
        }

        @media (max-width: 1200px) {
            .hero-content {
                flex-direction: column;
                align-items: center;
            }

            .gym-info, .image-gallery {
                max-width: 100%;
                width: 100%;
            }

            .image-gallery {
                height: 400px;
                margin-top: 2rem;
            }
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
                background-color: #1a202c;
                padding: 1rem;
            }

            nav.active {
                display: block;
            }

            nav ul {
                flex-direction: column;
                gap: 1rem;
            }

            .gym-bio h3 {
                font-size: 2rem;
            }

            .gym-bio p {
                font-size: 1rem;
            }

            .hero {
                padding: 2rem 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">
                    <h1>GYM-TINA</h1>
                </div>
                <nav id="main-nav">
                    <ul>
                        <li><a href="dashboard.php">Inicio</a></li>
                        <li><a href="informacion.php" class="">Nosotros</a></li>
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
                        <div class="gym-bio">
                            <h3>Nuestra Historia</h3>
                            <p>Tina Andersen, nacida en Dinamarca el 14 de julio de 1967, se trasladó a Colombia a los 19 años. Con una formación en ballet, jazz y danza contemporánea, decidió abrir su primer gimnasio, "Gimnasio Tina's", a los 20 años, impulsada por su pasión por el movimiento y la salud.</p>
                            <p>En 2004, fundó "Gym Tina", comenzando con solo cinco máquinas, pero logrando un crecimiento constante gracias a su dedicación y al apoyo de la comunidad de Honda, Tolima.</p>
                            <p>A lo largo de los años, Tina ha construido fuertes lazos con sus clientes, incluidos turistas y extranjeros, convirtiéndose en una figura clave en el ámbito fitness local. Orgullosa de contribuir al bienestar físico de las generaciones presentes y futuras, Tina sigue comprometida con su gimnasio, siendo un referente en la ciudad y promoviendo un estilo de vida saludable para todos.</p>
                        </div>
                    </div>
                    <div class="image-gallery">
                        <img src="imagenes/WhatsApp Image 2024-10-16 at 8.02.47 PM.jpeg" alt="Gym Image 1" class="gallery-image active">
                        <img src="imagenes/WhatsApp Image 2024-10-16 at 8.02.46 PM (2).jpeg" alt="Gym Image 2" class="gallery-image">
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

            const images = document.querySelectorAll('.gallery-image');
            let currentImage = 0;

            function rotateImages() {
                images[currentImage].classList.remove('active');
                currentImage = (currentImage + 1) % images.length;
                images[currentImage].classList.add('active');
            }

            setInterval(rotateImages, 10000); 
        });
    </script>
</body>
</html>