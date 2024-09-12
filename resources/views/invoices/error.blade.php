<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Factura</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <div class="alert alert-danger">
            <h1 class="display-4">Error</h1>
            <p class="lead">Hubo un problema al procesar su solicitud.</p>
            @if(session('error'))
                <p>{{ session('error') }}</p>
            @else
                <p>No se pudo encontrar la información solicitada.</p>
            @endif
        </div>

        <div class="mt-4">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-home"></i> Volver al Inicio
            </a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
