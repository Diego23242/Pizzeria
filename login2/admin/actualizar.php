<?php
require_once "../config/conexion.php";

if (!empty($_POST["btnGuardar"])) {
    if (!empty($_POST["id"]) && !empty($_POST["usuario"]) && !empty($_POST["producto"]) && !empty($_POST["precio"]) && !empty($_POST["fecha"])) {
        // Obtener los datos del formulario
        $id = $_POST["id"];
        $usuario = $_POST["usuario"];
        $producto = $_POST["producto"];
        $precio = $_POST["precio"];
        $fecha = $_POST["fecha"];

        // Actualizar la compra en la base de datos
        $sql = "UPDATE compras SET usuario = '$usuario', producto = '$producto', precio = '$precio', fecha = '$fecha' WHERE id = $id";

        if ($conexion->query($sql) === TRUE) {
            // Mostrar mensaje de éxito
            echo '<div class="alert alert-success">Cambios Actualizados</div>';
        } else {
            // Mostrar mensaje de error
            echo '<div class="alert alert-danger">Error al actualizar la compra: ' . $conexion->error . '</div>';
        }
    } else {
        // Mostrar mensaje de advertencia si no se completan todos los campos
        echo '<div class="alert alert-warning">Debes llenar todo el formulario</div>';
    }
}
?>
