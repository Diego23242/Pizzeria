<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conexion, "SELECT imagen FROM productos WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    $imagen = $data['imagen'];
    unlink("../assets/img/$imagen");
    $eliminar = mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
    if ($eliminar) {
        header('Location: eliminar2.php');
    }
}

include("includes/header2.php");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-dark mb-4">Eliminar Productos</h1>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio Normal</th>
                            <th>Precio Rebajado</th>
                            <th>Cantidad</th>
                            <th>Categoría</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria ORDER BY p.id DESC");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><img class="img-thumbnail" src="../assets/img/<?php echo $data['imagen']; ?>" width="50"></td>
                                <td><?php echo $data['nombre']; ?></td>
                                <td><?php echo $data['descripcion']; ?></td>
                                <td><?php echo $data['precio_normal']; ?></td>
                                <td><?php echo $data['precio_rebajado']; ?></td>
                                <td><?php echo $data['cantidad']; ?></td>
                                <td><?php echo $data['categoria']; ?></td>
                                <td>
                                    <form method="post" action="eliminar2.php?id=<?php echo $data['id']; ?>" class="d-inline eliminar">
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

<?php include("includes/footer.php"); ?>


<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $eliminar = mysqli_query($conexion, "DELETE FROM categorias WHERE id = $id");
    if ($eliminar) {
        header('Location: eliminar2.php');
    }
}

include("includes/header2.php");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-dark mb-4">Eliminar Categorías</h1>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM categorias ORDER BY id DESC");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['categoria']; ?></td>
                                <td>
                                    <form method="post" action="eliminar2.php?id=<?php echo $data['id']; ?>" class="d-inline eliminar">
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

<?php include("includes/footer.php"); ?>
