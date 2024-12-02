<?php
session_start();

if (!isset($_SESSION["reset_id"]) || empty($_SESSION["reset_id"])) {
    header("location: forgot-password.php");
    exit;
}

require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

function validate_password($password) {
    $errors = [];

    if (strlen($password) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Debe contener al menos una letra mayúscula";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Debe contener al menos una letra minúscula";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Debe contener al menos un número";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = "Debe contener al menos un símbolo";
    }

    return $errors;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $password_errors = validate_password($new_password);

    if (empty($new_password)) {
        $new_password_err = "Por favor ingrese la nueva contraseña.";
    } elseif (!empty($password_errors)) {
        $new_password_err = implode('<br>', $password_errors);
    }

    if (empty($confirm_password)) {
        $confirm_password_err = "Por favor confirme la contraseña.";
    } elseif ($new_password !== $confirm_password) {
        $confirm_password_err = "Las contraseñas no coinciden.";
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $param_password, $param_id);

            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["reset_id"];

            if ($stmt->execute()) {
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            background-image: url('https://previews.123rf.com/images/monsitj/monsitj1701/monsitj170100031/71795075-campo-de-la-contrase%C3%B1a-en-el-fondo-ilustraci%C3%B3n-de-la-tecnolog%C3%ADa-representan-el-concepto-de-seguridad.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(0, 0, 0, 0.5);
            padding: 40px;
            border-radius: 25px;
            color: white;
            max-width: 500px;
            width: 100%;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-group i {
            position: absolute;
            top: 10px;
            left: 10px;
            transform: translateY(-50%);
            color: #aaa;
        }
        .form-control {
            padding-left: 40px;
            height: 45px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.2);
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
        .btn-link {
            color: #ddd;
            display: block;
            text-align: center;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .validation-list {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
            font-size: 14px;
        }
        .validation-list li {
            margin: 5px 0;
        }
        .validation-list .valid {
            color: green;
        }
        .validation-list .invalid {
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">Restablecer Contraseña</h2>
    <p>Por favor, complete este formulario para restablecer su contraseña.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-lock"></i>
            <input type="password" name="new_password" class="form-control" placeholder="Nueva Contraseña" value="<?php echo $new_password; ?>" oninput="validateInput()">
            <ul class="validation-list">
                <li id="length" class="invalid">La contraseña debe tener al menos 6 caracteres</li>
                <li id="uppercase" class="invalid">Debe contener al menos una letra mayúscula</li>
                <li id="lowercase" class="invalid">Debe contener al menos una letra minúscula</li>
                <li id="number" class="invalid">Debe contener al menos un número</li>
                <li id="symbol" class="invalid">Debe contener al menos un símbolo</li>
            </ul>
            <span class="error-message"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar Contraseña">
            <span class="error-message"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Enviar">
            <a class="btn btn-link" href="login.php">Cancelar</a>
        </div>
    </form>
</div>
<script>
    function validateInput() {
        const password = document.querySelector('input[name="new_password"]').value;
        const length = document.getElementById('length');
        const uppercase = document.getElementById('uppercase');
        const lowercase = document.getElementById('lowercase');
        const number = document.getElementById('number');
        const symbol = document.getElementById('symbol');

        length.className = password.length >= 6 ? 'valid' : 'invalid';
        uppercase.className = /[A-Z]/.test(password) ? 'valid' : 'invalid';
        lowercase.className = /[a-z]/.test(password) ? 'valid' : 'invalid';
        number.className = /\d/.test(password) ? 'valid' : 'invalid';
        symbol.className = /[\W_]/.test(password) ? 'valid' : 'invalid';
    }
</script>
</body>
</html>
