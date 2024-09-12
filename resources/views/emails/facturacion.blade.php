<!DOCTYPE html>
<html lang="es">
<head>
  <title>Facturacion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

</head>
<body>
    
<div class="container">
  <div class="row">
 
    <p> A continuaci&oacute;n encontr&aacute; su comprobante fiscal digital (CFDI) por los servicios realizados: </p>
    <p> Comprobante Fiscal Digital por Internet: {{ $invoice->uuid }}  </p>
    
    <p> Link para descargar representacion impresa PDF: <br> <a href="{{ route('invoices.pdf', ['uuid' => $invoice->uuid]) }}" class="btn btn-primary">  invoices/pdf/{{ $invoice->uuid }} </a> </p>
    <p> link para descargar archivo XML : <br> <a href="{{ route('download.xml', ['uuid' => $invoice->uuid]) }}" class="btn btn-secondary">  download/xml/{{ $invoice->uuid }} </a> </p>
    
  </div>
</div>

</body>
</html>
    


