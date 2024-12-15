<?php
$servername = "localhost";
$username = "u603711275_azte";
$password = "Electrote1234";
$dbname = "u603711275_login_system";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
