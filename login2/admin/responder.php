<?php
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

// Verificar si se ha proporcionado un ID de mensaje válido
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $mensaje_id = $_GET['id'];

    // Consulta SQL para obtener los detalles del mensaje
    $query = "SELECT usuario_envia, mensaje FROM mensaje WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $mensaje_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el mensaje
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usuario_envia = $row['usuario_envia']; // Aquí se obtiene el nombre del usuario
        $mensaje = $row['mensaje'];
    } else {
        // Si no se encuentra el mensaje, redirigir a la página de mensajes con un mensaje de error
        header("Location: mensajes.php?error=not_found");
        exit();
    }
} else {
    // Si no se proporciona un ID de mensaje válido, redirigir a la página de mensajes con un mensaje de error
    header("Location: mensajes.php?error=invalid_id");
    exit();
}

// Procesar el formulario de respuesta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado una respuesta
    if (isset($_POST["respuesta"])) {
        // Obtener la respuesta del administrador
        $respuesta = $_POST["respuesta"];

        // Preparar la consulta SQL para insertar la respuesta en la base de datos
        $query = "INSERT INTO respuestas (mensaje_id, respuesta) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $mensaje_id, $respuesta);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // La respuesta se guardó correctamente
            echo "<div class='alert alert-success' role='alert'>La respuesta se ha guardado correctamente.</div>";
        } else {
            // Error al guardar la respuesta
            echo "<div class='alert alert-danger' role='alert'>Error al guardar la respuesta.</div>";
        }

        // Cerrar la declaración preparada
        $stmt->close();
    } else {
        // No se envió ninguna respuesta
        echo "<div class='alert alert-danger' role='alert'>Por favor, escriba una respuesta antes de enviar.</div>";
    }
}

include("includes/header.php");
?>

<div class="container mt-5">
    <h3>Responder a <?php echo isset($usuario_envia) ? htmlspecialchars($usuario_envia) : "" ?></h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $mensaje_id; ?>" method="POST">
        <input type="hidden" name="mensaje_id" value="<?php echo $mensaje_id; ?>">
        <div class="mb-3">
            <label for="usuario_envia" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario_envia" name="usuario_envia" value="<?php echo htmlspecialchars($usuario_envia); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" disabled><?php echo htmlspecialchars($mensaje); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="respuesta" class="form-label">Respuesta</label>
            <textarea class="form-control" id="respuesta" name="respuesta" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
        <a href="atencion.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>
