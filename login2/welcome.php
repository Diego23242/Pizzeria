<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<style>
    body {
        background-color: #f0f0f0; /* Cambiar el color de fondo a un gris claro */
        background-image: url('https://media.istockphoto.com/id/1460853312/es/foto/puntos-y-l%C3%ADneas-conectados-abstractos-concepto-de-tecnolog%C3%ADa-de-ia-movimiento-del-flujo-de.jpg?s=612x612&w=0&k=20&c=IA_d2iqqxoxc8KrV4U0uAfjusAFP-DwWBd25AIZ5Vik=');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        height: 100vh;
    }
    .container {
        background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
        padding: 20px;
        border-radius: 25px; /* Esquinas redondeadas */
        margin-top: 100px;
        color: white; /* Cambiar el color del texto a blanco para contrastar con el fondo semitransparente */
    }
    .form-group {
        margin-bottom: 20px; /* Espaciado entre elementos del formulario */
    }
    .btn-primary {
        width: 100%; /* Ancho completo del botón */
    }
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px; /* Espaciado superior */
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Bienvenido</h2>
                <p>Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bienvenido a nuestro sitio.</p>
                <p>
                    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
                </p>
                <a href="index.php"class="btn btn-warning">Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
