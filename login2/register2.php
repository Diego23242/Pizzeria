<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$database = "login_system";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para limpiar los datos enviados por el formulario
function limpiarDatos($datos) {
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

// Inicializar variables
$registroExitoso = false;
$error = "";

// Procesar el formulario de registro si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = limpiarDatos($_POST["nombre"]);
    $email = limpiarDatos($_POST["email"]);
    $contraseña = limpiarDatos($_POST["contraseña"]);
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Validar que los campos requeridos no estén vacíos
    if (empty($nombre) || empty($email) || empty($contraseña)) {
        $error = "Por favor, complete todos los campos del formulario.";
    } else {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO proveedores (nombre, email, contraseña) VALUES ('$nombre', '$email', '$contraseña_hash')";

        if ($conn->query($sql) === TRUE) {
            $registroExitoso = true;
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Proveedores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .registro-container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .registro-container h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registro-container">
            <h2>Registro de Proveedores</h2>
            <?php if ($registroExitoso): ?>
                <div class="alert alert-success">
                    Registro exitoso. Espera a que el administrador te de acceso al panel del proveedor.
                </div>
                <a href="login2.php" class="btn btn-primary">Ir al inicio de sesión</a>
            <?php else: ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
