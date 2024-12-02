<?php
require_once "../config/conexion.php";

// Función para ocultar la contraseña
function hidePassword($password) {
    $length = strlen($password);
    $hiddenLength = max(2, min(6, $length - 4)); // Mostrar solo los primeros y últimos 2 caracteres
    $hiddenPart = str_repeat('*', $hiddenLength);
    return substr($password, 0, 2) . $hiddenPart . substr($password, -2);
}

// Establecer encabezados HTTP
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=datos-usuario.xls");

?>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <caption>Lista De Usuarios</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Fecha de registro</th>
            
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, username, email, password, created_at FROM users";
            $resultado = mysqli_query($conexion, $sql);
            while ($mostrar = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td><?php echo $mostrar['id'] ?></td>
                <td><?php echo $mostrar['username'] ?></td>
                <td><?php echo $mostrar['email'] ?></td>
                <td><?php echo hidePassword($mostrar['password']) ?></td> <!-- Aquí aplicamos la función hidePassword -->
                <td><?php echo $mostrar['created_at'] ?></td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</body>
</html>
