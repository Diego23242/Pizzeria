<?php
require('fpdf/fpdf.php');
require_once "../config/conexion.php";

// Función para ocultar la contraseña
function hidePassword($password) {
    $length = strlen($password);
    $hiddenLength = max(2, min(6, $length - 4)); // Mostrar solo los primeros y últimos 2 caracteres
    $hiddenPart = str_repeat('*', $hiddenLength);
    return substr($password, 0, 2) . $hiddenPart . substr($password, -2);
}

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Arial bold 12
        $this->SetFont('Arial', 'B', 12);
        // Título
        $this->Cell(0, 10, 'TABLA DE USUARIOS REGISTRADOS', 0, 1, 'C');
        // Salto de línea
        $this->Ln(10);

        // Encabezados de la tabla
        $this->Cell(20, 10, '#', 1, 0, 'C');
        $this->Cell(45, 10, 'Nombre', 1, 0, 'C');
        $this->Cell(65, 10, 'Correo', 1, 0, 'C'); // Aumentado el ancho de la columna de correo
        $this->Cell(40, 10, 'Contraseña', 1, 0, 'C');
        $this->Cell(45, 10, 'Fecha Registro', 1, 1, 'C'); // Modificado el título de la columna
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pg ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Creación de la tabla desde la base de datos
$sql = "SELECT * from users";
$resultado = mysqli_query($conexion, $sql);

$pdf = new PDF('L'); // Cambiado el parámetro a 'L' para orientación horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);

while ($datos = $resultado->fetch_object()) {
    $pdf->Cell(20, 10, $datos->id, 1, 0, 'C');
    $pdf->Cell(45, 10, $datos->username, 1, 0, 'C');
    $pdf->Cell(65, 10, $datos->email, 1, 0, 'L'); // Ajustado el texto a la izquierda (L)
    $pdf->Cell(40, 10, hidePassword($datos->password), 1, 0, 'C');
    $pdf->Cell(45, 10, $datos->created_at, 1, 1, 'C');
}

$pdf->Output();
?>
