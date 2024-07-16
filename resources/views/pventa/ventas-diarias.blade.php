@extends('layouts.pv')

<!-- Main content -->
@section('content')

<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-12">
		<!-- Default box -->
		<div class="card">  
		
		  <div class="card-body">               
		   
			<h1>Consulta ventas diarias</h1>

			 <div class="row">
				
				 <form action="{{ route('daily.sales') }}" class="form-inline" method="GET">
					@csrf
							
					<label for="email2" class="mb-2 mr-sm-2">Fecha Inicio:</label>
					<input type="date" id="fecha_inicio" class="form-control mb-2 mr-sm-2" name="fecha_inicio" style="width:auto;" required>
					
					<label for="pwd2" class="mb-2 mr-sm-2">Fecha Final:</label>
					<input type="date" id="fecha_fin" class="form-control mb-2 mr-sm-2" name="fecha_fin" style="width:auto;" required>
				  
					<button type="submit" class="btn btn-primary mb-2" style="width:auto;">Generar Reporte</button>
					
				  </form>	
				
			 </div>

		    @if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif		
		
		   <!-- Muestra errores de validación -->
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		
			<div class="row"> <br> </div>

			@if($ventas->isEmpty())
				<p>No hay ventas disponibles.</p>
			@else
				
				@php
					$i = 1;
				@endphp
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Folio</th>
							<th>MPago</th>
							<th>Fecha</th>
							<th>Total</th>
							<th>Usuario</th>
							<th>Status</th>
							<th> Venta</th>
						</tr>
					</thead>
					<tbody>
						@foreach($ventas as $venta)
							<tr>
								<td class="text-muted">{{ $i++ }} </td>
								<td>{{ $venta->id }}</td>
								<td>{{ $venta->pvtipopago }}</td>
								<td>{{ $venta->created_at }}</td>
								<td align="right">$ {{ number_format($venta->pvtotal,2) }}</td>
								<td>{{ $venta->user_name }}</td>
								<td>{{ $venta->pvstatus }}</td>								
								<td class="celda-de-icono"> 
									<a href="{{ route('venta.ticket', ['id' => $venta->id]) }}" target="_ticket" title="imprimir" class="btn btn-primary btn-sm mr-1"> <i class="fa fa-print"></i> </a>
									<a href="{{ route('ventas.cancelar', ['id' => $venta->id]) }}" title="cancelar" class="btn btn-danger btn-sm mr-1"> <i class="fa fa-times"></i> </a>  
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				
			@endif			
						
		  </div>
		  <!-- /.card-body -->
		  <div class="card-footer">
			@foreach ($totales as $row) 
			
				Total de ventas por {{ $row->pvtipopago }} : {{ $row->total }}  <br>
				
			@endforeach			
			
			Total general de ventas: $ {{ number_format($total,2) }} 
		  </div>
		  <!-- /.card-footer-->
		</div>
		<!-- /.card -->
	  </div>
	</div>
  </div>
</section>

<script>
// Function to format date as YYYY-MM-DD
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

document.addEventListener('DOMContentLoaded', function() {
    // Set the fecha_inicio and fecha_fin fields to today's date
    var today = formatDate(new Date());
    document.getElementById('fecha_inicio').value = today;
    document.getElementById('fecha_fin').value = today;
});
</script>

	
@endsection
<!-- /.content -->
