<?php
require_once "../config/conexion.php";
include("includes/header.php");


date_default_timezone_set('America/Mexico_City');

$online_time_limit = 800; 

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-dark">Usuarios en Línea</h1>
                <a href="lista_usuarios.php" class="btn btn-primary">
    <i class="fas fa-arrow-left"></i> Regresar
</a>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Última Actividad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_time = time();
                        $query = mysqli_query($conexion, "SELECT id, username, email, active, last_activity FROM users ORDER BY id ASC");
                        while ($data = mysqli_fetch_assoc($query)) {
                            $last_activity_time = strtotime($data['last_activity']);
                            $time_difference = $current_time - $last_activity_time;
                            $online = $time_difference <= $online_time_limit;
                            ?>
                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['username']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td>
                                    <?php echo $data['active'] ? 'Activo' : 'Inactivo'; ?>
                                    <?php if ($online) { ?>
                                        <span style="color: green; font-size: 20px;">●</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $data['last_activity']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
