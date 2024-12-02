<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Obtener el estado actual del proveedor
    $query = mysqli_query($conexion, "SELECT estado FROM proveedores WHERE id = $id");

    if ($query) {
        $data = mysqli_fetch_assoc($query);
        $estado_actual = $data["estado"];

        // Cambiar el estado del proveedor
        $nuevo_estado = $estado_actual == "activo" ? "pendiente" : "activo";
        $sql = "UPDATE proveedores SET estado = '$nuevo_estado' WHERE id = $id";

        if ($conexion->query($sql) === TRUE) {
            header("Location: proveedores.php");
            exit();
        } else {
            echo "Error al cambiar el estado del proveedor: " . $conexion->error;
        }
    } else {
        echo "Error al obtener el estado del proveedor: " . $conexion->error;
    }
} else {
    header("Location: proveedores.php");
    exit();
}
?>
