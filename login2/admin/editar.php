<?php
require_once "../config/conexion.php";

// Verificar si se ha enviado el formulario
if (!empty($_POST["btnGuardar"])) {
    if (!empty($_POST["id"]) && !empty($_POST["usuario"]) && !empty($_POST["producto"]) && !empty($_POST["precio"]) && !empty($_POST["fecha"])) {
        // Obtener los datos del formulario
        $id = $_POST["id"];
        $usuario = $_POST["usuario"];
        $producto = $_POST["producto"];
        $precio = $_POST["precio"];
        $fecha = $_POST["fecha"];

        // Actualizar la compra en la base de datos
        $sql = "UPDATE compras SET usuario = '$usuario', producto = '$producto', precio = '$precio', fecha = '$fecha' WHERE id = $id";

        if ($conexion->query($sql) === TRUE) {
            // Mostrar mensaje de éxito
            echo '<div class="alert alert-success">Cambios Actualizados</div>';
        } else {
            // Mostrar mensaje de error
            echo '<div class="alert alert-danger">Error al actualizar la compra: ' . $conexion->error . '</div>';
        }
    } else {
        // Mostrar mensaje de advertencia si no se completan todos los campos
        echo '<div class="alert alert-warning">Debes llenar todo el formulario</div>';
    }
}

// Verificar si se recibió un ID válido a través de la URL
if (isset($_GET['id'])) {
    // Obtener el ID de la compra de la URL
    $id = $_GET['id'];

    // Consulta SQL para obtener los detalles de la compra con el ID proporcionado
    $sql = "SELECT * FROM compras WHERE id = $id";

    // Ejecutar la consulta
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar el formulario de edición con los detalles de la compra
        $fila = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="text-center my-4">
            <h3>Editar compra #<?= $id ?></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $fila['usuario'] ?></td>
                        <td><?= $fila['producto'] ?></td>
                        <td><?= $fila['precio'] ?></td>
                        <td><?= $fila['fecha'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="">
            <form method="post" action="">
                <input hidden type="number" name="id" value="<?= $fila['id'] ?>">
                <div class="mb-3">
                    <label class="form-label" for="usuario">Usuario</label>
                    <input type="text" class="form-control" name="usuario" value="<?= $fila['usuario'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="producto">Producto</label>
                    <input type="text" class="form-control" name="producto" value="<?= $fila['producto'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="precio">Precio</label>
                    <input type="number" step="0.01" class="form-control" name="precio" value="<?= $fila['precio'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fecha">Fecha</label>
                    <input type="date" class="form-control" name="fecha" value="<?= $fila['fecha'] ?>">
                </div>
                <div class="text-center">
                    <input class="btn btn-primary" type="submit" value="Guardar" name="btnGuardar">
                 
                    <a class="btn btn-success" href="compras.php"><i class="fas fa-arrow-left"></i> Regresar</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
    } else {
        echo "No se encontró la compra con el ID proporcionado.";
    }
} else {
    echo "ID de compra no proporcionado.";
}
?>
