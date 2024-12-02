<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: productos.php');
    exit();
}

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                    Ingrese usuario y contraseña
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
        require_once "../config/conexion.php";
        $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
        $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user' AND clave = '$clave'");
        
        if ($query) {
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                mysqli_close($conexion); // Cierra la conexión solo después de usar los datos

                $_SESSION['active'] = true;
                $_SESSION['id'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];

                header('Location: productos.php');
                exit();
            } else {
                mysqli_close($conexion); // Cierra la conexión si no hay resultado

                $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                        Usuario o contraseña incorrectos
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
            }
        } else {
            mysqli_close($conexion); // Cierra la conexión si hay error en la consulta

            $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                    Error en la consulta
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .card-login {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            overflow: hidden;
        }
        .card-login .card-img-top {
            border-radius: 1rem 0 0 1rem;
            object-fit: cover;
            height: 100%;
        }
        .card-login .card-body {
            padding: 4rem;
        }
        .btn-login {
            font-size: 1.2rem;
            letter-spacing: 0.1rem;
            padding: 0.75rem 1.5rem;
        }
        .btn-regresar {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-regresar:hover {
            background-color: #45a049;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-login shadow-lg my-5">
                    <div class="row g-0">
                        <div class="col-lg-5 d-flex align-items-center">
                            <img src="https://st2.depositphotos.com/5266903/7897/i/450/depositphotos_78976646-stock-photo-accounter-icon.jpg" class="img-fluid" alt="Login Image">
                        </div>
                        <div class="col-lg-7">
                            <div class="card-body">
                                <div class="text-center mb-5">
                                    <h1 class="h4 text-gray-900">¡Bienvenido de nuevo!</h1>
                                    <?php echo (isset($alert)) ? $alert : ''; ?>
                                </div>
                                <form class="user" method="POST" action="" autocomplete="off">
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-user <?php echo isset($usuario_valido) && !$usuario_valido ? 'is-invalid' : ''; ?>" id="usuario" name="usuario" placeholder="Usuario...">
                                        <?php if(isset($usuario_valido) && !$usuario_valido): ?>
                                            <div class="invalid-feedback">Usuario incorrecto.</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control form-control-user <?php echo isset($contraseña_valida) && !$contraseña_valida ? 'is-invalid' : ''; ?>" id="clave" name="clave" placeholder="Contraseña...">
                                        <?php if(isset($contraseña_valida) && !$contraseña_valida): ?>
                                            <div class="invalid-feedback">Contraseña incorrecta.</div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-login btn-block">Iniciar Sesión</button>
                                    <hr>
                                    <a href="/login2/logout.php" class="btn btn-regresar">Regresar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
