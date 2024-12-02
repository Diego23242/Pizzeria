<?php
session_start();
require_once "config.php";

$email = "";
$email_err = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor ingrese su email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($email_err)) {
        $sql = "SELECT id, username FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username);
                    $stmt->fetch();
                    $_SESSION["reset_id"] = $id;
                    $_SESSION["reset_username"] = $username;
                    header("location: reset-password.php");
                    exit;
                } else {
                    $email_err = "No se encontró cuenta con ese email.";
                }
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo.";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            background-image: url('https://media.istockphoto.com/id/1631319311/es/foto/conecte-la-tecnolog%C3%ADa-de-la-informaci%C3%B3n-moderna-comun%C3%ADquese-con-el-mundo-los-datos-y-la-copia.jpg?s=1024x1024&w=is&k=20&c=c-xNa4rj512ERVH_u34Qwd1pMyovLmwMhj5qmFfSxS4=');
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
    <h2>Recuperar Contraseña</h2>
    <p>Por favor, ingrese su email para recuperar su contraseña.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
            <span class="error-message"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Enviar">
        </div>
    </form>
    <p>¿Recordaste tu contraseña? <a href="login.php">Inicia sesión aquí</a>.</p>
</div>
</body>
</html>
