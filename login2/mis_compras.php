<?php
session_start();

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$database = "login_system";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redireccionar al usuario al login
    header("location: login.php");
    exit;
}

// Obtener el nombre de usuario desde la sesión
$nombreUsuario = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

// Eliminar todas las compras de un día específico
if (isset($_GET['eliminar_compras_dia'])) {
    $fechaEliminar = $_GET['eliminar_compras_dia'];
    $queryEliminar = "DELETE FROM compras WHERE usuario = '$nombreUsuario' AND fecha = '$fechaEliminar'";
    if ($conn->query($queryEliminar) === TRUE) {
        // Redirigir a la misma página después de eliminar las compras
        header("Location: mis_compras.php");
        exit;
    } else {
        echo "Error al eliminar las compras: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Importar FontAwesome para el ícono -->

    <style>
        /* Estilo para el botón de volver a la tienda */
        .btn-volver-tienda {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s ease; /* Agregar transición suave al color de fondo */
        }

        .btn-volver-tienda:hover {
            background-color: #0056b3;
        }

        /* Estilo para el ícono de flecha */
        .icono-flecha {
            margin-right: 5px;
        }

        /* Estilo para la tabla de compras */
        .table {
            border-collapse: collapse; /* Colapsar bordes de la tabla */
            width: 100%;
            max-width: 800px; /* Limitar el ancho de la tabla */
            margin: 0 auto; /* Centrar la tabla horizontalmente */
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6; /* Estilo de borde */
            padding: 8px; /* Espaciado interno */
            text-align: center; /* Alinear texto al centro */
        }

        .table th {
            background-color: #007bff; /* Color de fondo del encabezado */
            color: #fff; /* Color de texto del encabezado */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 123, 255, 0.1); /* Color de fondo alternado */
        }

        /* Estilo para cada compra */
        .compra {
            margin-bottom: 20px; /* Espacio entre cada compra */
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .compra h3 {
            margin-bottom: 10px;
        }

        /* Estilo para el botón de eliminar compra */
        .btn-eliminar {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
            transition: background-color 0.3s ease; /* Agregar transición suave al color de fondo */
        }

        .btn-eliminar:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Mis Compras</h2>
        <?php
        $username = $_SESSION["username"];
        $query = mysqli_query($conn, "SELECT fecha, SUM(precio) as total FROM compras WHERE usuario = '$username' GROUP BY fecha");
        while ($data = mysqli_fetch_assoc($query)) {
            echo "<div class='compra'>";
            echo "<h3>Fecha de Compra: " . $data['fecha'] . "</h3>";
            echo "<p>Total: $" . $data['total'] . "</p>";
            echo "<table class='table table-striped'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Producto</th>";
            echo "<th>Precio</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $queryProductos = mysqli_query($conn, "SELECT producto, precio FROM compras WHERE usuario = '$username' AND fecha = '" . $data['fecha'] . "'");
            $count = 1;
            while ($producto = mysqli_fetch_assoc($queryProductos)) {
                echo "<tr>";
                echo "<td>" . $count . "</td>";
                echo "<td>" . $producto['producto'] . "</td>";
                echo "<td>$" . $producto['precio'] . "</td>";
                echo "</tr>";
                $count++;
            }
            echo "</tbody>";
            echo "</table>";
            echo "<a href='mis_compras.php?eliminar_compras_dia=" . $data['fecha'] . "' class='btn btn-danger'>Eliminar</a>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="container text-center mt-4">
        <a href="index.php" class="btn btn-volver-tienda"><i class="icono-flecha fas fa-arrow-left"></i> Volver a la tienda</a>
    </div>

    <!-- Importar FontAwesome para utilizar el ícono de flecha -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
