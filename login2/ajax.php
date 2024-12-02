<?php
require_once "config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'buscar') {
        // Obtener los IDs de los productos del array enviado
        $productos_ids = array_column($_POST['data'], 'id');
        
        // Convertir los IDs en una cadena separada por comas para usar en la consulta SQL
        $productos_ids_str = implode(',', $productos_ids);
        
        // Consulta para obtener información de todos los productos en la lista
        $query = "SELECT id, nombre, precio_rebajado FROM productos WHERE id IN ($productos_ids_str)";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            $array['datos'] = array();
            $total = 0;

            // Iterar sobre los resultados de la consulta y agregarlos al array de datos
            while ($row = mysqli_fetch_assoc($result)) {
                $data['id'] = $row['id'];
                $data['precio'] = $row['precio_rebajado'];
                $data['nombre'] = $row['nombre'];
                $total += $row['precio_rebajado'];
                array_push($array['datos'], $data);
            }
            
            // Agregar el total al array de respuesta
            $array['total'] = $total;
            
            // Devolver los datos en formato JSON
            echo json_encode($array);
        } else {
            // Si la consulta falla, devolver un mensaje de error
            echo json_encode(['error' => 'Error al ejecutar la consulta SQL']);
        }
    }
} else {
   
    echo json_encode(['error' => 'Solicitud no válida']);
}
?>
