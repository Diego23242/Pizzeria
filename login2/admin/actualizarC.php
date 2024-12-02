<?php
require_once "../config/conexion.php";

if(isset($_POST['btnGuardar'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $created_at = $_POST['created_at'];

    // Iniciar la consulta de actualización
    $sql = "UPDATE users SET username = ?, email = ?, created_at = ?";
    
    // Verificar si se proporcionó una nueva contraseña
    if(!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password = ?";
    }
    
    $sql .= " WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);

    // Vincular los parámetros a la consulta
    if(!empty($password)) {
        $stmt->bind_param("ssssi", $username, $email, $created_at, $hashed_password, $id);
    } else {
        $stmt->bind_param("sssi", $username, $email, $created_at, $id);
    }

    if($stmt->execute()) {
        echo '<div class="alert alert-success">Usuario actualizado correctamente.</div>';
        header('Location: lista_usuarios.php?msg=Usuario actualizado correctamente');
        exit();
    } else {
        echo '<div class="alert alert-danger">Error al actualizar el usuario: ' . $conexion->error . '</div>';
    }

    $stmt->close();
} else {
    echo "Acceso no autorizado.";
}
?>
