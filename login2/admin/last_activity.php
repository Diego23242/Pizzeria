<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}


require_once "../config/conexion.php";
include("includes/header.php");

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
