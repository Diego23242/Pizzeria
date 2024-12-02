<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $carrito = json_decode($_POST['carrito'], true);
    $_SESSION['carrito'] = $carrito;
    echo "Carrito actualizado";
}
?>
