<?php
    $host = "localhost";
    $user = "u603711275_azte";
    $clave = "Electrote1234";
    $bd = "u603711275_login_system";
    $conexion = mysqli_connect($host,$user,$clave,$bd);
    if (mysqli_connect_errno()){
        echo "No se pudo conectar a la base de datos";
        exit();
    }
    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");
    mysqli_set_charset($conexion,"utf8");
