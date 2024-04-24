<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de Caja</title>
</head>
<body onLoad=" window.print(); window.self.close(); " style=" font-size:12pt; font-family:arial; ">
    <div>
        <h2 class="mb-4">Cierre de Caja</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Fecha del Cierre:</strong> {{ $fecha }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Hora del Cierre:</strong> {{ $hora }}</p>
            </div>
        </div>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Saldo Anterior {{  number_format($cierre->saldo_anterior ?? 0, 2) }}</td>
                </tr>
				    <tr><td>Entrada {{ number_format($cierre->entrada ?? 0, 2) }}</td></tr>
                    <tr><td>Salida {{ number_format($cierre->salida ?? 0, 2) }}</td></tr>
                    <tr><td>Venta Total {{ number_format($cierre->venta ?? 0, 2) }}</td></tr>
					<tr><td>Saldo Actual {{ number_format($cierre->saldo_actual ?? 0, 2) }}</td></tr>
                    
            </tbody>
        </table>
        <div class="row mt-5">
            <div class="col-md-6">
                <p><strong>Firmado por:</strong></p>
                <p>_______________________</p>
                <p>Nombre y Firma</p>
            </div>
            <div class="col-md-6">
                <p><strong>Aprobado por:</strong></p>
                <p>_______________________</p>
                <p>Nombre y Firma</p>
            </div>
        </div>
    </div>

</body>
</html>