<?php
require_once "../config/conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conexion, "SELECT active FROM users WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    $new_status = $data['active'] ? 0 : 1;

    mysqli_query($conexion, "UPDATE users SET active = $new_status WHERE id = $id");

    header("Location: lista_usuarios.php");
    exit();
}
?>
