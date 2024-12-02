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
$error = "";

// Procesar el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = limpiarDatos($_POST["email"]);
    $contraseña = limpiarDatos($_POST["contraseña"]);

    // Buscar el proveedor en la base de datos
    $sql = "SELECT * FROM proveedores WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Proveedor encontrado, verificar la contraseña
        $row = $result->fetch_assoc();
        if (password_verify($contraseña, $row["contraseña"])) {
            if ($row["estado"] == "activo") {
                // Iniciar sesión
                session_start();
                $_SESSION["proveedor_id"] = $row["id"];
                $_SESSION["proveedor_nombre"] = $row["nombre"];
                // Redireccionar al panel del proveedor
                header("Location: /login2/admin/productos2.php");
                exit();
            } else {
                $error = "Espera a que el administrador te de acceso al panel del proveedor.";
            }
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Proveedor no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login de Proveedores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Login de Proveedores</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>
        <p class="text-center mt-3">¿No tienes una cuenta? <a href="register2.php">Regístrate ahora</a>.</p>
        <a href="login.php" class="btn btn-regresar">Regresar</a>
    </div>
</body>
</html>
