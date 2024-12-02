<?php
require_once "../config/conexion.php";

include("includes/header.php");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-dark">Lista de Usuarios</h1>
                <div class="btn-group">
                    <a href="pdf.php" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-2"></i> Reporte en PDF
                    </a>
                    <a href="excel.php" class="btn btn-primary">
                        <i class="fas fa-file-excel me-2"></i> Reporte en Excel
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Contraseña</th>
                            <th>Estado</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT id, username, email, password, active, hora_entrada, hora_salida FROM users ORDER BY id DESC");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['username']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo $data['password']; ?></td>
                                <td><?php echo $data['active'] ? 'Activo' : 'Inactivo'; ?></td>
                                <td><?php echo $data['last_login']; ?></td>
                                <td><?php echo $data['last_logout']; ?></td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a href="editarC.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm me-1">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="eliminar.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                        <a href="toggle_active.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">
                                            <?php echo $data['active'] ? 'Desactivar' : 'Activar'; ?>
                                        </a>
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
