<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['usuario']) && !empty($_POST['producto']) && !empty($_POST['precio']) && !empty($_POST['fecha'])) {
    $usuario = $_POST['usuario'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    $query = mysqli_query($conexion, "INSERT INTO compras(usuario, producto, precio, fecha) VALUES ('$usuario', '$producto', '$precio', '$fecha')");
    if ($query) {
        header('Location: compras.php');
        exit(); // Asegura que se detenga la ejecución del script después de la redirección
    }
}

include("includes/header.php");

// Procesar eliminación si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_compra'])) {
    $id_compra = $_POST['id_compra'];
    $query_delete = mysqli_query($conexion, "DELETE FROM compras WHERE id = '$id_compra'");
    if ($query_delete) {
        // Redireccionar a la misma página usando JavaScript si la redirección por PHP causa problemas
        echo '<script>window.location.href = "compras.php";</script>';
        exit();
    }
}
?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-dark mb-4">Compras de los usuarios</h1>
        </div>
        <div class="col-md-4 text-right">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM compras ORDER BY id DESC");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['usuario']; ?></td>
                                <td><?php echo $data['producto']; ?></td>
                                <td><?php echo $data['precio']; ?></td>
                                <td><?php echo $data['fecha']; ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form method="post" action="" class="d-inline eliminar">
                                        <input type="hidden" name="id_compra" value="<?php echo $data['id']; ?>">
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="comprasModal" tabindex="-1" role="dialog" aria-labelledby="comprasModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="comprasModalLabel">Nueva Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="producto">Producto</label>
                        <input id="producto" class="form-control" type="text" name="producto" placeholder="Producto" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input id="fecha" class="form-control" type="text" name="fecha" placeholder="Fecha" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
