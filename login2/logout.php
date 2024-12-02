<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Establecer la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Crear la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$database = "login_system";

$conexion = new mysqli($servername, $username, $password, $database);

// Verificar si hay errores de conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Obtener el ID de usuario de la sesión
$id_usuario = $_SESSION["id"];

// Obtener la hora actual
$hora_salida = date('Y-m-d H:i:s');

// Actualizar la hora de salida en la base de datos
$sql = "UPDATE users SET last_logout = '$hora_salida' WHERE id = $id_usuario";

if ($conexion->query($sql) === TRUE) {
    // Limpiar las variables de sesión
    session_unset();
    // Destruir la sesión
    session_destroy();
    // Redirigir al usuario a la página de inicio de sesión
    header("location: login.php");
    exit;
} else {
    echo "Error al cerrar la sesión: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
