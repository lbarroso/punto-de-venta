<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Factura </title>

	  
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">

	<style>
	/* Aplicar estilos globales para el cuerpo del documento */
	body {
		font-size: 12px; /* Establece el tamaño del texto a 12px */

		font-family: Arial, sans-serif; /* Fuente para mejorar la legibilidad */
	}	
		
	table {
		width: 100%; /* Ajusta el ancho de la tabla al 100% del contenedor */
		border-collapse: separate; /* Mantiene las celdas separadas para poder usar border-spacing */
		border-spacing: 1px; /* Espacio entre celdas */

	}

	/* Estilo para las celdas de la tabla */
	td, th {
		border: 0px solid #ddd; /* Borde de cada celda */
		padding: 3px; /* Espacio entre el texto y el borde de la celda */
		text-align: left; /* Alineación del texto */
	}	
	</style>

</head>

<body>

  <div class="container-fluid">
	<div class="row">
	  <div class="col-12">
		<div class="callout callout-info">
		  <h5><i class="fas fa-info"></i> Total: $ {{ number_format($salida->total,2) }} </h5>
		     No. Articulos {{ $articulos }}
		</div>

			<!-- Main content -->
			<div class="invoice p-1 mb-1">
			  <!-- title row -->
			  <div class="row">
				<div class="col-12">
				  <h4>
					<i class="fas fa-globe"></i> {{ $empresa->regnom }} 
					<small>
						<img class="animation__wobble" src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">	
					</small>
				  </h4>
				  
				</div>
				<!-- /.col -->
			  </div>
			  <!-- info row -->
			  <div class="row invoice-info">
				<div class="col-sm-4">
				  <address>
					<strong> {{ $cliente->ctenom }} </strong>
					@if(!empty($cliente->prvtel))
					entro
					{{ $cliente->cteemail }} <br>
					{{ $cliente->prvtel }} <br>						
					@endif			
				  </address>
				</div>		
			  </div>
			  
				<table  style="width: 100%; padding: 8px; text-align: left;">
					<tr>
						<td> {{ config('app.name', 'Laravel') }} </strong> </td>
						<td>Factura #{{ $salida->factura }}</td>
					</tr>
					<tr>
						<td>{{ $empresa->regnom }}</td>
						<td>Docord ID:</b> {{ $salida->id }}</td>
					</tr>
					<tr>
						<td>{{ $empresa->regloc }}</td>
						<td>Doc. fecha:</b> {{ $salida->fecha }}</td>
					</tr>
					<tr>
						<td>{{ $empresa->regtel }}</td>
						<td>Status:</b> {{ $salida->status }} </td>
					</tr>
					<tr>
						<td>Elaboro: {{ $salida->user_name }}</td>
						<td>Fecha: {{ date('m/d/Y') }}</td>
					</tr>
				</table>				
	

			  <!-- Table row -->
			  <div class="row">
				
				  <table  style="width: 100%; padding: 12px; font-size: 12px;">
					<thead>
					<tr>
					  <th>Cant.</th>
					  <th>Código</th>
					  <th>Descripción Producto</th>
					  <th>$ Venta</th>
					  <th>-%</th>
					  <th>Importe</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($docdetas as $docdeta)
					<tr>
					  <td>{{ $docdeta->doccant }}</td>
					  <td>{{ $docdeta->codbarras }}</td>						  
					  <td>{{ $docdeta->artdesc }}</td>
					  <td>{{ number_format( $docdeta->artprventa, 2) }}</td>
					  <td>{{ number_format($docdeta->artdescto, 2) }}</td>
					  <td>{{ number_format($docdeta->docimporte, 2) }}</td>
					</tr>
					@endforeach
					</tbody>
				  </table>
				
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			  @if(!empty($salida->comentarios))
			  <table style="width: 100%;  text-align: left; padding: 3px; border: 1px solid #ddd;">
				<tr>
					<td>
						&nbsp; Comentarios: {{ $salida->comentarios }} 
					</td>
				</tr>
			  </table>
			  @endif
			  <!-- /.row -->

			  <!-- this row will not appear when printing -->

			</div>
			<!-- /.invoice -->
					

	  </div><!-- /.col -->
	</div><!-- /.row -->
  </div><!-- /.container-fluid -->

	  


</body>
</html>			  