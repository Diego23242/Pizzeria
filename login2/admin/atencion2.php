<?php
require_once "../config/conexion.php";
include("includes/header2.php");

$servername = "localhost";
$username = "root";
$password = "";
$database = "login_system";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los mensajes
$query = "SELECT id, usuario_envia, mensaje, fecha_envio FROM mensaje";
$result = $conn->query($query);

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-dark">Mensajes</h1>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Mensaje</th>
                            <th>Fecha de Envío</th>
                            <th>Responder</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Mostrar los datos en la tabla
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["usuario_envia"] . "</td>";
                                echo "<td>" . $row["mensaje"] . "</td>";
                                echo "<td>" . $row["fecha_envio"] . "</td>";
                                // Agregar botón de responder
                                echo "<td><a href='responder.php?id=" . $row["id"] . "' class='btn btn-primary'>Responder</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No hay mensajes</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
