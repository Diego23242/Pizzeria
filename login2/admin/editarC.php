<?php
require_once "../config/conexion.php";

// Verificar si se recibió un ID válido a través de la URL
if(isset($_GET['id'])) {
    // Obtener el ID del usuario de la URL
    $id = $_GET['id'];

    // Consulta SQL para obtener los detalles del usuario con el ID proporcionado
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conexion, $sql);

    if($result->num_rows > 0) {
        // Obtener los detalles del usuario
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontró el usuario con el ID proporcionado.";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}

include("includes/header.php");
?>

<div class="container mt-5">
    <h3>Editar Usuario</h3>
    <form action="actualizarC.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Dejar en blanco para no cambiar">
        </div>
    
        <button type="submit" class="btn btn-primary" name="btnGuardar">Guardar Cambios</button>
        <a href="lista_usuarios.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include("includes/footer.php"); ?>
