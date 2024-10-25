<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$sql = "SELECT id, admin_id, nombre FROM administradores";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Administradores - Fitness Gym-Tina</title>
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

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .table-container {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 800px;
        }

        h1 {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: var(--secondary-color);
            color: var(--white);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        tr:hover {
            background-color: #edf2f7;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #718096;
            font-style: italic;
        }

        @media (max-width: 600px) {
            .table-container {
                font-size: 0.9rem;
            }

            th, td {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h1>Tabla de Administradores</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Admin ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["id"]."</td>
                                <td>".$row["admin_id"]."</td>
                                <td>".$row["nombre"]."</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='no-data'>No hay administradores registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>