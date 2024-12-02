<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $query = mysqli_query($conexion, "INSERT INTO categorias(categoria) VALUES ('$nombre')");
    if ($query) {
        header('Location: categorias2.php');
    }
}

include("includes/header2.php");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-dark mb-4">Categorías</h1>
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#categoriasModal"><i class="fas fa-plus mr-2"></i>Nueva</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
                                    <form method="post" action="eliminar2.php?accion=cli&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
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

<div class="modal fade" id="categoriasModal" tabindex="-1" role="dialog" aria-labelledby="categoriasModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="categoriasModalLabel">Nueva Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Categoría" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
