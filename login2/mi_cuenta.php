<?php
session_start();
require_once "config.php";

// Verificar si el usuario ha iniciado sesión, si no redirigir a la página de inicio de sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Obtener los datos del usuario actual
$sql = "SELECT username, email FROM users WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION["id"]);
    if ($stmt->execute()) {
        $stmt->bind_result($username, $email);
        $stmt->fetch();
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
    }
    $stmt->close();
}

// Definir variables e inicializar con valores vacíos
$password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar nombre de usuario
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor ingrese un nombre de usuario.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ? AND id != ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $param_username, $_SESSION["id"]);
            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "Este nombre de usuario ya está en uso.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo.";
            }
            $stmt->close();
        }
    }

    // Validar email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor ingrese un email.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $param_email, $_SESSION["id"]);
            $param_email = trim($_POST["email"]);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $email_err = "Este email ya está en uso.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo.";
            }
            $stmt->close();
        }
    }

    // Validar contraseña
    if (!empty(trim($_POST["password"]))) {
        if (strlen(trim($_POST["password"])) < 6) {
            $password_err = "La contraseña al menos debe tener 6 caracteres.";
        } else {
            $password = trim($_POST["password"]);

            // Validación de la contraseña con expresiones regulares
            $uppercase = preg_match('/[A-Z]/', $password);
            $lowercase = preg_match('/[a-z]/', $password);
            $number = preg_match('/\d/', $password);
            $symbol = preg_match('/\W/', $password);

            if (!$uppercase || !$lowercase || !$number || !$symbol) {
                $password_err = "La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un símbolo.";
            }
        }

        // Validar confirmación de contraseña
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Por favor confirme la contraseña.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Las contraseñas no coinciden.";
            }
        }
    }

    // Verificar errores antes de actualizar en la base de datos
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $param_username, $param_email, $param_password, $_SESSION["id"]);

            $param_username = $username;
            $param_email = $email;
            $param_password = empty($password) ? $_SESSION["password"] : password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                // Actualizar la sesión con los nuevos valores
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                if (!empty($password)) {
                    $_SESSION["password"] = $param_password;
                }
                // Redirigir al usuario a la página principal
                header("location: index.php");
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
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            background-image: url('https://img.freepik.com/vector-premium/tienda-futurista-abstracta-mercado-negocios-linea-concepto-conexion-internet-marketing-digital_618588-1153.jpg?size=626&ext=jpg&ga=GA1.1.44546679.1716508800&semt=ais_user');
            background-size: cover;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-center a {
            color: #007bff;
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Mi Cuenta</h2>
    <p>Actualiza tu información de cuenta.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($_SESSION["username"]); ?>" placeholder="Nombre de usuario">
            <span class="error-message"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_SESSION["email"]); ?>" placeholder="Email">
            <span class="error-message"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="password" id="password" class="form-control" placeholder="Nueva contraseña">
            <span class="error-message"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar nueva contraseña">
            <span class="error-message"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Actualizar">
        </div>
        <p class="text-center"><a href="index.php">Volver a la página principal</a></p>
    </form>
</div>

<script>
    document.getElementById('password').addEventListener('input', function () {
        var password = this.value;
        var requirements = [
            { id: 'requirement-length', regex: /.{6,}/ },
            { id: 'requirement-uppercase', regex: /[A-Z]/ },
            { id: 'requirement-lowercase', regex: /[a-z]/ },
            { id: 'requirement-number', regex: /\d/ },
        

            { id: 'requirement-special', regex: /\W/ }
        ];

        requirements.forEach(function(requirement) {
            var element = document.getElementById(requirement.id);
            if (requirement.regex.test(password)) {
                element.classList.add('valid');
                element.innerHTML = '<i class="fas fa-check-circle"></i> ' + element.textContent.trim();
            } else {
                element.classList.remove('valid');
                element.innerHTML = '<i class="fas fa-circle"></i> ' + element.textContent.trim();
            }
        });
    });
</script>
</body>
</html>
