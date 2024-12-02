<?php
require_once "../config/conexion.php";

include("includes/header.php");

// Función para abreviar la contraseña
function abreviarContraseña($contraseña) {
    if (strlen($contraseña) <= 2) {
        return $contraseña;
    }
    return substr($contraseña, 0, 3) . '...';
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4">Lista de Proveedores</h1>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Contraseña</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT id, nombre, email, contraseña, estado FROM proveedores ORDER BY id DESC");

                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['nombre']; ?></td>
                                <td><?php echo isset($data['email']) ? $data['email'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['contraseña']) ? abreviarContraseña($data['contraseña']) : 'N/A'; ?></td>
                                <td><?php echo $data['estado'] == 'activo' ? 'Activo' : 'Inactivo'; ?></td>
                                <td>
                                   
                                        <a href="eliminar3.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este proveedor?')">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                        <?php if ($data['estado'] == 'activo') { ?>
                                            <a href="toggle_estado.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-toggle-on"></i> Desactivar
                                            </a>
                                        <?php } else { ?>
                                            <a href="toggle_estado.php?id=<?php echo $data['id']; ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-toggle-off"></i> Activar
                                            </a>
                                        <?php } ?>
                                    </div>
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
