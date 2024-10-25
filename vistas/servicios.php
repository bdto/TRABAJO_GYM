<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - GYM-TINA</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">
    <style>
        :root {
            --primary-color: #db2777;
            --secondary-color: #f472b6;
            --background-color: #f5f5f5;
            --text-color: #333;
            --header-bg: #1a202c;
            --card-bg: #ffffff;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
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
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            object-fit: cover;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            transition: var(--transition);
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
            transition: var(--transition);
            text-decoration: none;
            font-weight: bold;
        }

        .login-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        main {
            flex-grow: 1;
            padding-top: 80px;
        }

        .services-section {
            padding: 6rem 0;
        }

        .services-section h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 3rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .service-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .service-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .service-card p {
            color: var(--text-color);
            font-size: 1rem;
            line-height: 1.6;
        }

        .image-gallery {
            margin-top: 4rem;
            position: relative;
            height: 500px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            object-fit: cover;
        }

        .gallery-image.active {
            opacity: 1;
        }

        @media (max-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .image-gallery {
                height: 400px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 1rem;
            }

            .services-section h2 {
                font-size: 2rem;
            }

            .image-gallery {
                height: 300px;
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
                        <li><a href="informacion.php">Nosotros</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                        <li><a href="login.php" class="login-btn">Login</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="services-section">
            <div class="container">
                <h2>Nuestros Servicios</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <h3>Entrenamiento Personal</h3>
                        <p>Sesiones personalizadas con nuestros entrenadores expertos para alcanzar tus metas fitness. Diseñamos planes adaptados a tus necesidades y objetivos específicos.</p>
                    </div>
                    <div class="service-card">
                        <h3>Plan de Alimentación</h3>
                        <p>Variedad de planes alimenticios como dietas bajas en carbohidratos, vegetarianas, cetogénicas y más. Te ayudamos a mantener una nutrición balanceada para optimizar tus resultados.</p>
                    </div>
                    <div class="service-card">
                        <h3>Área de Pesas</h3>
                        <p>Zona de pesas y máquinas de última generación para tu entrenamiento de fuerza. Equipamiento de alta calidad para trabajar todos los grupos musculares de manera efectiva.</p>
                    </div>
                    <div class="service-card">
                        <h3>Cafetería</h3>
                        <p>Amplia variedad de productos como batidos de proteína, creatinas, suplementos y snacks saludables. Opciones nutritivas para potenciar tu rendimiento y recuperación post-entrenamiento.</p>
                    </div>
                </div>

                <div class="image-gallery">
                    <img src="https://images.pexels.com/photos/1954524/pexels-photo-1954524.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Área de pesas" class="gallery-image active">
                    <img src="https://images.pexels.com/photos/3768916/pexels-photo-3768916.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Entrenamiento personal" class="gallery-image">
                    <img src="https://images.pexels.com/photos/3823207/pexels-photo-3823207.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Cafetería saludable" class="gallery-image">
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.gallery-image');
            let currentImage = 0;

            function rotateImages() {
                images[currentImage].classList.remove('active');
                currentImage = (currentImage + 1) % images.length;
                images[currentImage].classList.add('active');
            }

            setInterval(rotateImages, 5000); 
        });
    </script>
</body>
</html>