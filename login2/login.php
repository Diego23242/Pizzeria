<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor ingrese su nombre de usuario.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor ingrese su contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, active FROM users WHERE username = ?";

        if ($conn) {
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
                $param_username = $username;

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $username, $hashed_password, $active);
                        if ($stmt->fetch()) {
                            if ($active) {
                                if (password_verify($password, $hashed_password)) {
                                    session_start();

                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    

                                    // Establecer la zona horaria a Ciudad de México
                                    date_default_timezone_set('America/Mexico_City');

                                    $now = date('Y-m-d H:i:s');
                                    // Actualizar la hora de la última actividad y la hora de inicio de sesión
                                    $update_login_time = $conn->prepare("UPDATE users SET last_login = ?, last_activity = ? WHERE id = ?");
                                    $update_login_time->bind_param("ssi", $now, $now, $id);
                                    $update_login_time->execute();

                                    header("location: welcome.php");
                                } else {
                                    $login_err = "La contraseña que has ingresado no es válida.";
                                }
                            } else {
                                $login_err = "Esta cuenta está inactiva. Contacte al administrador.";
                            }
                        }
                    } else {
                        $login_err = "No se encontró cuenta con ese nombre de usuario.";
                    }
                } else {
                    echo "Algo salió mal. Por favor, inténtelo de nuevo.";
                }

                $stmt->close();
            }
        } else {
            echo "Error de conexión a la base de datos. Por favor, verifique la configuración.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            background-image: url('https://png.pngtree.com/background/20230617/original/pngtree-digital-depiction-of-the-online-shopping-experience-picture-image_3699648.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: rgba(0, 0, 0, 0.5); /* Fondo transparente */
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: white;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: white;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #aaa;
        }
        .form-control {
            padding-left: 40px; /* Espaciado para los iconos */
            height: 45px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.2); /* Fondo de los campos */
            color: white;
            border: none;
        }
        .form-control::placeholder {
            color: #ddd;
        }
        .btn-primary {
            width: 100%;
            border-radius: 30px;
            height: 45px;
            margin-bottom: 10px;
            background: #007bff;
            border: none;
        }
        .btn-warning, .btn-danger {
            width: 100%;
            border-radius: 30px;
            height: 45px;
            margin-bottom: 10px;
            border: none;
        }
        .btn-warning {
            background: #ffc107;
        }
        .btn-danger {
            background: #dc3545;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .text-center a {
            color: #007bff;
        }
        .text-center a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <p>Por favor, complete sus credenciales para iniciar sesión.</p>
    <?php
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" value="<?php echo $username; ?>">
            <span class="error-message"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Contraseña">
            <span class="error-message"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
        </div>
        <p class="text-center">¿No tienes una cuenta? <a href="register.php">Regístrate ahora</a>.</p>
        <p class="text-center"><a href="forgot-password.php" class="btn btn-warning">Restablecer su contraseña</a></p>
        <a href="/login2/admin/index2.php" class="btn btn-danger">Acceso de Administrador</a>
        <p class="text-center">¿Quiero ser uno de nosotros? <a href="login2.php">Regístrate ahora</a>.</p>
    </form>
</div>
</body>
</html>
