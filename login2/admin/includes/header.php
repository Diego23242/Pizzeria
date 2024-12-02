<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$nombreUsuario = isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<style>
    
</style>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administracion</title>

  
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEAM9ZcahAOqHk0IDbS15TH2a8KJiV4mqeD4UsaV3oFW-9FHiKiMXb3kjLMLOmKeNF6Y4&usqp=CAU" alt="Logo" style="width: 40px;">
                </div>
                <div class="sidebar-brand-text mx-3">TodoEnUno <sup>Shop</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->


            <li class="nav-item active">
    <a class="nav-link" href="compras.php">
        <i class="fas fa-shopping-cart"></i>
        <span>Mis ventas</span>
    </a>
</li>
<li class="nav-item active">
    <a class="nav-link" href="lista_usuarios.php">
        <i class="fas fa-users"></i>
        <span>Clientes</span>
    </a>
</li>




<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="categorias.php">
        <i class="fas fa-tag"></i>
        <span>Categorías</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="productos.php">
        <i class="fas fa-list"></i>
        <span>Productos</span>
    </a>
</li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item">
    <a class="nav-link" href="atencion.php">
        <i class="fas fa-headset"></i>
        <span>Atención Al Cliente</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="proveedores.php">
        <i class="fas fa-headset"></i>
        <span>Proveedores</span>
    </a>
</li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombreUsuario; ?></span>
                                <img class="img-profile rounded-circle" src="https://w7.pngwing.com/pngs/701/653/png-transparent-computer-icons-system-administrator-administrator-icon-silhouette-desktop-wallpaper-administrator-icon.png">
                            </a>
                           
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                           
                            <a class="dropdown-item" href="/login2/admin/logout2.php">
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
    Salir
</a>

                            </div>
                        </li>

                    </ul>

                </nav>
             
                <div class="container-fluid">