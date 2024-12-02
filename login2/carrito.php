<?php
session_start();
include 'conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Obtener el nombre de usuario
$nombreUsuario = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

// Obtener los datos del carrito (suponiendo que se envían a través de POST)
$carrito = isset($_POST['carrito']) ? json_decode($_POST['carrito'], true) : [];

if (!empty($carrito)) {
    foreach ($carrito as $item) {
        $idProducto = $item['id'];
        $nombreProducto = $item['nombre'];
        $precioProducto = $item['precio'];
        
        // Insertar la compra en la base de datos
        $stmt = $conn->prepare("INSERT INTO compras (usuario, producto, precio) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssd", $nombreUsuario, $nombreProducto, $precioProducto);
            if (!$stmt->execute()) {
                // Error al ejecutar la consulta
                echo "Error al ejecutar la consulta: " . $stmt->error;
                exit;
            }
            $stmt->close();
        } else {
            // Error al preparar la consulta
            echo "Error al preparar la consulta: " . $conn->error;
            exit;
        }
    }
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "El carrito está vacío o no se recibió correctamente."]);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoEnUno Shop</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
     
body {
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1140px;
    margin: 0 auto;
}

.navbar-brand {
    font-size: 1.8rem;
    color: #007bff;
    font-weight: bold;
}


.banner {
    background-image: url('https://www.elg-asesores.com/images/joomlart/categories/tienda-virtual_001.jpg');
    background-size: cover;
    background-position: center;
}

.banner h1 {
    color: #007bff;
}

.banner p {
    color: #007bff;
    font-size: 1.5rem;
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">TodoEnUno Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </div>
    <header class="py-5 banner">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder mb-4">Carrito de Compras</h1>
                <p class="lead fw-normal">¡Revisa tus productos agregados!</p>
            </div>
        </div>
    </header>
</body>
</html>


    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody id="tblCarrito">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h4>Total a Pagar: <span id="total_pagar">0.00</span></h4>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" id="btnPagar" disabled>Pagar</button>
                        <button class="btn btn-warning" type="button" id="btnVaciar">Vaciar Carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
      $(document).ready(function() {
    mostrarCarrito();

    $('#btnPagar').click(function() {
        if (localStorage.getItem("productos") != null) {
            let productos = JSON.parse(localStorage.getItem('productos'));

            $.ajax({
                url: 'carrito.php',
                type: 'POST',
                data: {
                    carrito: JSON.stringify(productos)
                },
                success: function(response) {
                    localStorage.removeItem('productos');
                    mostrarNotificacion('¡Gracias por tu compra!');
                    setTimeout(function() {
                        window.location.href = 'confirmacion.php';
                    }, 3000); 
                },
                error: function(error) {
                    console.log(error);
                    mostrarNotificacion('Error al procesar la compra.');
                }
            });
        }
    });

    $('#btnVaciar').click(function() {
        localStorage.removeItem('productos');
        mostrarCarrito();
    });
});

function mostrarCarrito() {
    if (localStorage.getItem("productos") != null) {
        let array = JSON.parse(localStorage.getItem('productos'));
        if (array.length > 0) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: true,
                data: {
                    action: 'buscar',
                    data: array
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    let html = '';
                    res.datos.forEach(element => {
                        html += `
                        <tr>
                            <td>${element.id}</td>
                            <td>${element.nombre}</td>
                            <td>${element.precio}</td>
                            <td>1</td>
                            <td>${element.precio}</td>
                        </tr>
                        `;
                    });
                    $('#tblCarrito').html(html);
                    $('#total_pagar').text(res.total);
                    $('#btnPagar').prop('disabled', false); 
                },
                error: function(error) {
                    console.log(error);
                }
            });
        } else {
            mostrarNotificacion('El carrito está vacío');
            $('#btnPagar').prop('disabled', true);
        }
    }
}

function mostrarNotificacion(mensaje) {
    const notificacion = document.createElement('div');
    notificacion.classList.add('alert', 'alert-success', 'position-fixed', 'top-0', 'start-50', 'translate-middle-x', 'mt-5', 'fade', 'show');
    notificacion.setAttribute('role', 'alert');
    notificacion.innerHTML = mensaje;
    document.body.appendChild(notificacion);
    setTimeout(function() {
        $('.alert').alert('close');
    }, 3000); 
}

    </script>


</body>
</html>
