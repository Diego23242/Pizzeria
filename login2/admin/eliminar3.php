<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Eliminar el proveedor de la base de datos
    $sql = "DELETE FROM proveedores WHERE id = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: proveedores.php");
        exit();
    } else {
        echo "Error al eliminar el proveedor: " . $conexion->error;
    }
} else {
    header("Location: proveedores.php");
    exit();
}
?>
