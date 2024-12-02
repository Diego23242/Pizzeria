<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Enviar Mensaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" /> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/carrito.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
        .success-message {
            background-color: #dff0d8;
            border-color: #d0e9c6;
            color: #3c763d;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Envíanos un mensaje, estamos para lo que se ofrezca</h2>
                    </div>
                    <div class="card-body">
                        <form action="enviar2.php" method="post" id="mensajeForm">
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje:</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">Enviar</button>
                                <a href="respuestas.php" class="btn btn-success me-md-2">Respuestas</a>
                                <a href="index.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Regresar</a>
                            </div>
                        </form>
                        <div class="success-message" id="successMessage">
                            Mensaje enviado correctamente. Redireccionando...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar mensaje de éxito y redireccionar después de enviar el mensaje
        $(document).ready(function() {
            $("#mensajeForm").submit(function(e) {
                e.preventDefault();
                $.post($(this).attr("action"), $(this).serialize(), function(response) {
                    if (response.success) {
                        $("#successMessage").fadeIn().delay(2000).fadeOut(function() {
                            window.location.href = "index.php";
                        });
                    } else {
                        alert("Error: " + response.message);
                    }
                }, 'json');
            });
        });
    </script>
</body>
</html>
