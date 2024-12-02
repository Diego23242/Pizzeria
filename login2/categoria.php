<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

$query = mysqli_query($conn, "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria WHERE c.categoria = '$categoria'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo $categoria; ?> - TodoEnUno Shop</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <a href="#" class="btn-flotante" id="btnCarrito">Carrito <span class="badge bg-success" id="carrito">0</span></a>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="welcome.php">Regresar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link text-info">Todo</a>
                        </li>
                        <!-- Menú desplegable de Categorías -->
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
                            <!-- Menú desplegable para usuarios autenticados -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> Bienvenido, <?php echo $_SESSION["username"]; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="mis_compras.php"><i class="fas fa-shopping-bag"></i> Mis Compras</a></li>
                                    <li><a class="dropdown-item" href="enviar.php"><i class="fas fa-headset"></i> Atención al Cliente</a></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <!-- Enlace para iniciar sesión -->
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary mx-2" href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TodoEnUno Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .carousel-item {
            height: 37vh;
            min-height: 200px;
            background: no-repeat center center scroll;
            background-size: cover;
        }
    </style>
</head>
<body>
    <!-- Carrusel de imágenes -->
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url('https://tecnosoluciones.com/wp-content/uploads/2023/04/que-productos-vender-en-una-tienda-virtual-o-comercio-electronico.jpg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold"><?php echo $categoria; ?></h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('https://img.freepik.com/foto-gratis/carro-compras-lleno-productos-dentro-supermercado_123827-28165.jpg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold"><?php echo $categoria; ?></h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230717/pngtree-d-render-of-a-laptop-with-a-supermarket-cart-and-parcel-image_3892818.jpg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold"><?php echo $categoria; ?></h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url('https://www.elfinanciero.com.mx/resizer/F8v_jmhWetkghfvaApwFH8Kxoi4=/400x267/filters:format(jpg):quality(70)/cloudfront-us-east-1.images.arcpublishing.com/elfinanciero/AQMGWQMZNVHSZAG7WTKUMG4LLY.jpeg');">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-2 fw-bold"><?php echo $categoria; ?></h1>
                        <p class="lead fw-normal mb-0">Aquí podrás encontrar de todo y de buena calidad.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <div class="col mb-5 productos">
                            <div class="card h-100">
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
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
                } else { ?>
                    <p>No hay productos en esta categoría.</p>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Modal del carrito -->
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

        // Recuperar carrito desde la sesión al cargar la página
        if (sessionStorage.getItem('carrito')) {
            carrito = JSON.parse(sessionStorage.getItem('carrito'));
            actualizarCarrito();
        }

        $('.agregar').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const nombre = $(this).data('nombre');
            const precio = $(this).data('precio');

            const producto = { id, nombre, precio };
            carrito.push(producto);

            // Actualizar el carrito en la sesión del servidor
            sessionStorage.setItem('carrito', JSON.stringify(carrito));

            actualizarCarrito();
        });

        $('#btnCarrito').click(function() {
            $('#carritoItems').empty();
            carrito.forEach((producto, index) => {
                $('#carritoItems').append(`<li class="list-group-item">${producto.nombre} - $${producto.precio} <button class="btn btn-danger btn-sm eliminar" data-index="${index}">Eliminar</button></li>`);
            });
            $('#carritoModal').modal('show');
        });

        $(document).on('click', '.eliminar', function() {
            const index = $(this).data('index');
            carrito.splice(index, 1);
            sessionStorage.setItem('carrito', JSON.stringify(carrito));
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
                    window.location.href = 'confirmacion.php';
                },
                error: function(xhr, status, error) {
                    alert("Hubo un problema al procesar tu compra. Inténtalo de nuevo.");
                }
            });
        });

        function actualizarCarrito() {
            $('#carrito').text(carrito.length);
            $('#carritoItems').empty();
            carrito.forEach((producto, index) => {
                $('#carritoItems').append(`<li class="list-group-item">${producto.nombre} - $${producto.precio} <button class="btn btn-danger btn-sm eliminar" data-index="${index}">Eliminar</button></li>`);
            });
        }
    });
    </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="assets/js/carrito.js"></script>
</body>
</html>
