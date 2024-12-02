<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$database = "login_system";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        // Redireccionar al usuario al login si no ha iniciado sesión
        echo json_encode(["success" => false, "message" => "No has iniciado sesión"]);
        exit;
    }

    // Obtener el nombre de usuario del remitente desde la sesión
    $usuario_envia = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

    // Obtener el mensaje enviado desde el formulario
    $mensaje = $_POST["mensaje"];

    // Obtener la fecha y hora actual
    $fecha_envio = date("Y-m-d H:i:s");

    // Insertar el mensaje en la tabla mensaje
    $query = "INSERT INTO mensaje (usuario_envia, mensaje, fecha_envio) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sss", $usuario_envia, $mensaje, $fecha_envio);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al enviar el mensaje"]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta"]);
    }

    // Cerrar la conexión
    mysqli_close($conn);
} else {
    // Si no es una solicitud POST, redireccionar al usuario a la página de inicio
    echo json_encode(["success" => false, "message" => "La solicitud no es POST"]);
}
?>
