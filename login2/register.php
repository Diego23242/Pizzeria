<?php
require_once "config.php";

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validar nombre de usuario
  if (empty(trim($_POST["username"]))) {
    $username_err = "Por favor ingrese un nombre de usuario.";
  } else {
    $sql = "SELECT id FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_username);
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
    $sql = "SELECT id FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_email);
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
  if (empty(trim($_POST["password"]))) {
    $password_err = "Por favor ingrese una contraseña.";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "";
  } else {
    $password = trim($_POST["password"]);

    // Improved password validation with regular expression
    $uppercase = preg_match('/[A-Z]/', $password);
    $lowercase = preg_match('/[a-z]/', $password);
    $number = preg_match('/\d/', $password);
    $symbol = preg_match('/\W/', $password);

    if (!$uppercase || !$lowercase || !$number || !$symbol) {
      $password_err = "";
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

  // Verificar errores antes de insertar en la base de datos
  if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("sss", $param_username, $param_email, $param_password);

      $param_username = $username;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT);

      if ($stmt->execute()) {
        header("location: login.php");
      } else {
        echo "Algo salió mal. Por favor, inténtelo de nuevo.";
      }

      $stmt->close();
    
        }
    }

    // Validar contraseña
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor ingrese una contraseña.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
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

    // Verificar errores antes de insertar en la base de datos
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                header("location: login.php");
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
    <title>Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            background-image: url('https://www.codigosanluis.com/wp-content/uploads/9c99e646-8c78-4554-8871-8df1ff3c1e9e-1536x1023.jpg.webp');
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
        .password-requirements {
            text-align: left;
            font-size: 14px;
            color: white;
            margin-top: 10px;
        }
        .password-requirements li {
            list-style: none;
            color: white;
            display: flex;
            align-items: center;
        }
        .password-requirements li.valid {
            color: green;
        }
        .password-requirements li i {
            margin-right: 5px;
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
    <h2>Registro</h2>
    <p>Por favor, complete este formulario para crear una cuenta.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-user"></i>
            <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" value="<?php echo $username; ?>">
            <span class="error-message"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
            <span class="error-message"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" value="<?php echo $password; ?>">
            <span class="error-message"><?php echo $password_err; ?></span>
            <ul class="password-requirements" id="password-requirements">
                <li id="requirement-length"><i class="fas fa-circle"></i> La contraseña debe tener al menos 6 caracteres</li>
                <li id="requirement-uppercase"><i class="fas fa-circle"></i> Debe contener al menos una letra mayúscula</li>
                <li id="requirement-lowercase"><i class="fas fa-circle"></i> Debe contener al menos una letra minúscula</li>
                <li id="requirement-number"><i class="fas fa-circle"></i> Debe contener al menos un número</li>
                <li id="requirement-special"><i class="fas fa-circle"></i> Debe contener al menos un símbolo</li>
            </ul>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar contraseña" value="<?php echo $confirm_password; ?>">
            <span class="error-message"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Registrarse">
        </div>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
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
