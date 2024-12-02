<?php
require_once "../config/conexion.php";

if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($_GET['accion'] == 'pro') {
        $query = mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
        if ($query) {
            header('Location: productos.php');
            exit(); // Importante salir después de la redirección
        }
    }
    
    if ($_GET['accion'] == 'cli') {
        $query = mysqli_query($conexion, "DELETE FROM categorias WHERE id = $id");
        if ($query) {
            header('Location: categorias.php');
            exit(); // Importante salir después de la redirección
        }
    }

    if ($_GET['accion'] == 'com') {
        $query = mysqli_query($conexion, "DELETE FROM compras WHERE id = $id");
        if ($query) {
            header('Location: compras.php');
            exit(); // Importante salir después de la redirección
        }
    }
}

// Resto del código para eliminar usuarios




require_once "../config/conexion.php";

// Verificar si se recibió un ID válido a través de la URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_eliminar = $_GET['id'];

    // Preparar la consulta para eliminar el usuario
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_eliminar);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la lista de usuarios con un mensaje de éxito
        header('Location: lista_usuarios.php?msg=Usuario eliminado correctamente');
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $conexion->error;
    }

    $stmt->close();
} else {
    echo "ID de usuario no proporcionado.";
}
?>
<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Eliminar el proveedor de la base de datos
    $sql = "DELETE FROM proveedores WHERE id = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: proveedores.php");
        exit();
    } else {
        echo "Error al eliminar el proveedor: " . $conexion->error;
    }
} else {
    header("Location: proveedores.php");
    exit();
}
?>
