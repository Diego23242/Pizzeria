<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redireccionar al usuario al login
    header("location: login.php");
    exit;
}

// Obtener el nombre de usuario desde la sesión
$nombreUsuario = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
?>

    </a>
</li>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TodoEnUno Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/estilos.css" rel="stylesheet">
    <style>
        .btn-flotante {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-flotante:hover {
            background-color: #218838;
        }
        .btn-flotante .fa-shopping-cart {
            margin-right: 10px;
        }
        .carousel-item {
            height: 50vh;
            min-height: 300px;
            background: no-repeat center center scroll;
            background-size: cover;
        }
        .navbar-brand, .nav-link, .dropdown-item {
            color: #007bff;
        }
        .navbar-brand:hover, .nav-link:hover, .dropdown-item:hover {
            color: #0056b3;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-footer .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .card .badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <a href="#" class="btn-flotante" id="btnCarrito">
        <i class="fas fa-shopping-cart"></i>
        <span class="badge bg-success" id="carrito">0</span>
    </a>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="welcome.php">Regresar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">Todo</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorías</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                $queryCategorias = mysqli_query($conn, "SELECT * FROM categorias");
                                while ($dataCategorias = mysqli_fetch_assoc($queryCategorias)) { ?>
                                    <li><a class="dropdown-item" href="categoria.php?categoria=<?php echo $dataCategorias['categoria']; ?>"><?php echo $dataCategorias['categoria']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (isset($_SESSION["username"])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> Bienvenid@, <?php echo $_SESSION["username"]; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="mi_cuenta.php"><i class="fas fa-user"></i> Mi cuenta </a></li>
                                    <li><a class="dropdown-item" href="mis_compras.php"><i class="fas fa-shopping-bag"></i> Mis Compras</a></li>
                                    <li><a class="dropdown-item" href="enviar.php"><i class="fas fa-headset"></i> Atención al Cliente</a></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary mx-2" href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url('https://tecnosoluciones.com/wp-content/uploads/2023/04/que-productos-vender-en-una-tienda-virtual-o-comercio-electronico.jpg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold">TodoEnUno Shop</h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('https://img.freepik.com/foto-gratis/carro-compras-lleno-productos-dentro-supermercado_123827-28165.jpg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold">TodoEnUno Shop</h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230717/pngtree-d-render-of-a-laptop-with-a-supermarket-cart-and-parcel-image_3892818.jpg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold">TodoEnUno Shop</h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('https://www.elfinanciero.com.mx/resizer/F8v_jmhWetkghfvaApwFH8Kxoi4=/400x267/filters:format(jpg):quality(70)/cloudfront-us-east-1.images.arcpublishing.com/elfinanciero/AQMGWQMZNVHSZAG7WTKUMG4LLY.jpeg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold">TodoEnUno Shop</h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </header>

    <script>
        // Esto inicializa el carrusel cuando el documento esté listo.
        $(document).ready(function(){
            $('#carouselExampleIndicators').carousel();
        });
    </script>
</body>
</html>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $query = mysqli_query($conn, "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                       <div class="col mb-5 productos">
                            <div class="card h-100">
                                <div class="badge bg-danger text-white position-absolute">
                                    <?php echo ($data['precio_normal'] > $data['precio_rebajado']) ? 'Oferta' : ''; ?>
                                </div>
                                <img class="card-img-top" src="assets/img/<?php echo $data['imagen']; ?>" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $data['nombre']; ?></h5>
                                        <p><?php echo $data['descripcion']; ?></p>
                                        <span class="text-muted text-decoration-line-through"><?php echo $data['precio_normal']; ?></span>
                                        <?php echo $data['precio_rebajado']; ?>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto agregar" data-id="<?php echo $data['id']; ?>" data-nombre="<?php echo $data['nombre']; ?>" data-precio="<?php echo $data['precio_rebajado']; ?>" href="#">Agregar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php  }
                } ?>
            </div>
        </div>
    </section>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Modal para el carrito de compras -->
<div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carritoModalLabel">Carrito de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="carritoItems" class="list-group">
                </ul>
                <p>Total: $<span id="totalCarrito">0</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="pagar">Pagar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let carrito = [];

        if (sessionStorage.getItem('carrito')) {
            carrito = JSON.parse(sessionStorage.getItem('carrito'));
            actualizarCarrito();
        }

        $('.agregar').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const nombre = $(this).data('nombre');
            const precio = parseFloat($(this).data('precio'));

            const producto = { id, nombre, precio };
            carrito.push(producto);

            sessionStorage.setItem('carrito', JSON.stringify(carrito));

            $('#carrito').text(carrito.length);

            actualizarCarrito();
        });

        $('#btnCarrito').click(function() {
            $('#carritoItems').empty();
            let totalCarrito = 0;
            carrito.forEach((producto, index) => {
                $('#carritoItems').append(`<li class="list-group-item">${producto.nombre} - $${producto.precio.toFixed(2)} <button class="btn btn-danger btn-sm eliminar" data-index="${index}">Eliminar</button></li>`);
                totalCarrito += producto.precio;
            });
            $('#totalCarrito').text(totalCarrito.toFixed(2));
            $('#carritoModal').modal('show');
        });

        $(document).on('click', '.eliminar', function() {
            const index = $(this).data('index');
            carrito.splice(index, 1);
            sessionStorage.setItem('carrito', JSON.stringify(carrito));
            $('#carrito').text(carrito.length);
            actualizarCarrito();
        });

        $('#pagar').click(function() {
            $.ajax({
                url: 'carrito.php',
                method: 'POST',
                data: {
                    carrito: JSON.stringify(carrito)
                },
                success: function(response) {
                    // Limpiar el carrito después de realizar la compra
                    carrito = [];
                    sessionStorage.removeItem('carrito');
                    $('#carrito').text('0');
                    actualizarCarrito();
                    // Redirigir a la página de confirmación
                    window.location.href = 'confirmacion.php';
                },
                error: function(xhr, status, error) {
                    alert("Hubo un problema al procesar tu compra. Inténtalo de nuevo.");
                }
            });
        });

        function actualizarCarrito() {
            $('#carritoItems').empty();
            let totalCarrito = 0;
            carrito.forEach((producto, index) => {
                $('#carritoItems').append(`<li class="list-group-item">${producto.nombre} - $${producto.precio.toFixed(2)} <button class="btn btn-danger btn-sm eliminar" data-index="${index}">Eliminar</button></li>`);
                totalCarrito += producto.precio;
            });
            $('#totalCarrito').text(totalCarrito.toFixed(2));
        }
    });
</script>

</body>
</html>