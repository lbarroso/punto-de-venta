<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succes - Factura</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>

	<div class="container text-center">
		@if(session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif

		<h1 class="mb-4">¡Factura Generada Exitosamente!</h1>
		<p class="lead">Su factura electrónica ha sido generada correctamente. Hemos enviado una copia a su correo electrónico.</p>

		<div class="row justify-content-center">
			<!-- Botón para descargar XML -->
			<div class="col-md-4 mb-3">
				<a href="{{ route('download.xml', ['uuid' => $venta->uuid]) }}" target="_xml" class="btn btn-outline-primary btn-block">
					<i class="fas fa-file-code"></i> Descargar Archivo XML
				</a>
			</div>
			
			<!-- Botón para descargar PDF -->
			<div class="col-md-4 mb-3">
				<a href="{{ route('invoices.pdf', ['uuid' => $venta->uuid]) }}" target="_pdf" class="btn btn-outline-secondary btn-block">
					<i class="fas fa-file-pdf"></i> Descargar Factura Representación Impresa (PDF)
				</a>
			</div>
		</div>

		<div class="mt-4">
		   &nbsp;
		</div>
	</div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	
</body>
</html>
