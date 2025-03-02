<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores - Fitness Gym-Tina</title>
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

        body,
        html {
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

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1.25rem;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
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
            border: 2px solid var(--accent-color);
            transition: var(--transition);
        }

        .logo img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(244, 114, 182, 0.3);
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--accent-color);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        nav a,
        .logout-btn,
        .btn-download {
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--secondary-color);
            border: none;
            cursor: pointer;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }

        nav a:hover,
        .logout-btn:hover,
        .btn-download:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
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
            padding: 6rem 0;
            min-height: calc(100vh - 100px);
        }

        .hero-content {
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
            font-size: 3.5rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            line-height: 1.2;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-text p {
            font-size: 1.25rem;
            line-height: 1.8;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 600px;
        }

        .hero-image-container {
            width: 100%;
            aspect-ratio: 16 / 9;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        .hero-image-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
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
            background-color: rgba(244, 114, 182, 0.4);
            clip-path: polygon(0 0, 40% 0, 0 100%);
            transition: var(--transition);
        }

        .hero-image-container:hover .hero-image-stripe {
            clip-path: polygon(0 0, 50% 0, 0 100%);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: var(--white);
            margin: 15% auto;
            padding: 2.5rem;
            border-radius: 15px;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            animation: modalSlideIn 0.3s ease forwards;
        }

        @keyframes modalSlideIn {
            to {
                transform: translateY(0);
            }
        }

        .modal-content h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .modal-content p {
            color: var(--text-color);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .modal-btn {
            padding: 0.875rem 2rem;
            cursor: pointer;
            border: none;
            border-radius: 9999px;
            font-size: 1rem;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .confirm-btn {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .confirm-btn:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .cancel-btn {
            background-color: #e2e8f0;
            color: var(--text-color);
        }

        .cancel-btn:hover {
            background-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .download-container {
            margin-right: 1rem;
        }

        @media (max-width: 1200px) {
            .container {
                padding: 0 1.5rem;
            }

            .hero-text h2 {
                font-size: 3rem;
            }
        }

        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 3rem;
            }

            .hero-text {
                max-width: 800px;
            }

            .hero-image {
                max-width: 500px;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1.5rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
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

            .modal-content {
                margin: 30% auto;
                padding: 2rem;
            }

            .download-container {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="../imagenes/WhatsApp Image 2024-10-13 at 10.26.18 PM.jpeg" alt="GYM TINA Logo">
                    <h1>FITNESS GYM-TINA</h1>
                </div>
                <nav id="main-nav">
                    <ul>
                        <li class="download-container">
                            
                        </li>
                        <li><a href="usuarios.php"><i class="fas fa-users"></i> USUARIOS</a></li>
                        <li><a href="pagos.php"><i class="fas fa-credit-card"></i> PAGOS</a></li>
                        <li><a href="estadisticas.php"><i class="fas fa-chart-bar"></i> CONTABILIDAD</a></li>
                        <li><button id="logoutBtn" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN
                            </button></li>
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
                            <img src="https://st2.depositphotos.com/1017986/10221/i/450/depositphotos_102211842-stock-photo-smiling-man-and-woman-waving.jpg" alt="People Working Out" class="hero-image-cut">
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
                <button id="confirmLogout" class="modal-btn confirm-btn">
                    <i class="fas fa-check"></i> Confirmar
                </button>
                <button id="cancelLogout" class="modal-btn cancel-btn">
                    <i class="fas fa-times"></i> Cancelar
                </button>
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
                document.body.style.overflow = 'hidden';
            });

            window.addEventListener('click', (event) => {
                if (event.target === logoutModal) {
                    logoutModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });

            cancelLogout.addEventListener('click', () => {
                logoutModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });

            confirmLogout.addEventListener('click', () => {
                window.location.href = '../index.php';
            });
        });
    </script>
</body>
</html>