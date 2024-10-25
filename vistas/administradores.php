<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores - Fitness Gym-Tina</title>
    <link rel="icon" href="../imagenes/WhatsApp Image 2024-10-19 at 9.12.07 AM.jpeg" type="image/jpeg">

    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #f472b6;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

        nav a, .logout-btn {
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        nav a:hover, .logout-btn:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .hero {
            flex-grow: 1;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            padding: 4rem 0;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h2 {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .hero-text p {
            font-size: 1.2rem;
            max-width: 600px;
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image-container {
            width: 100%;
            max-width: 500px;
            aspect-ratio: 1 / 1;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .hero-image-cut {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-image-stripe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(244, 114, 182, 0.7);
            clip-path: polygon(0 0, 30% 0, 0 100%);
        }

        .logout-btn {
            background-color: transparent;
            border: 1px solid var(--white);
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: var(--white);
            margin: 15% auto;
            padding: 2rem;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
        }

        .modal-buttons {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .confirm-btn {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .confirm-btn:hover {
            background-color: #e55a9d;
        }

        .cancel-btn {
            background-color: #ccc;
            color: var(--text-color);
        }

        .cancel-btn:hover {
            background-color: #bbb;
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
                max-width: 350px;
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
                        <li><a href="usuarios.php">USUARIOS</a></li>
                        <li><a href="pagos.php">PAGOS</a></li>
                        <li><button id="logoutBtn" class="logout-btn">CERRAR SESIÓN</button></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h2>¡OJO CON LOS DATOS!</h2>
                        <p>Querido Administrador, por favor solicita los datos pertinentes a los usuarios para realizar los registros. La precisión y la confidencialidad son fundamentales para mantener la integridad de nuestro sistema.</p>
                    </div>
                    <div class="hero-image">
                        <div class="hero-image-container">
                            <img src="https://files.oaiusercontent.com/file-AegSjTnImKTXRPdyca2wbTTz?se=2024-09-18T02%3A23%3A35Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D604800%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3Dfc20e7a6-1db2-4014-a3c7-8739d0ddef9e.webp&sig=db04CiEXE2xARRHYY1RnO%2BEfVERUSxyQbzHPnqdS9dw%3D" alt="People Working Out" class="hero-image-cut">
                            <div class="hero-image-stripe"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2>Confirmar cierre de sesión</h2>
            <p>¿Estás seguro que quieres cerrar sesión?</p>
            <div class="modal-buttons">
                <button id="confirmLogout" class="modal-btn confirm-btn">Confirmar</button>
                <button id="cancelLogout" class="modal-btn cancel-btn">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');
            const logoutModal = document.getElementById('logoutModal');
            const confirmLogout = document.getElementById('confirmLogout');
            const cancelLogout = document.getElementById('cancelLogout');

        
            logoutBtn.addEventListener('click', () => {
                logoutModal.style.display = 'block';
            });

            
            window.addEventListener('click', (event) => {
                if (event.target === logoutModal) {
                    logoutModal.style.display = 'none';
                }
            });

         
            cancelLogout.addEventListener('click', () => {
                logoutModal.style.display = 'none';
            });

            
            confirmLogout.addEventListener('click', () => {
                window.location.href = 'dashboard.php';
            });
        });
    </script>
</body>
</html>