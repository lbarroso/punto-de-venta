@extends('layouts.pv')

@section('styles')
    <!-- Tus estilos personalizados aquí -->
    <style>
		.celda-de-icono{
			width: 40px;
			text-align: center;
		}
		.icono-azul{
			color: #1e0080
		}
    </style>
@endsection

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
							<th>Ticket </th>
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
								
								<td class="celda-de-icono"> <a href="{{ route('venta.ticket', ['id' => $venta->id]) }}" target="_ticket" title="imprimir"> <i class="fa fa-print icono-azul"></i> </a>  </td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif			
						
		  </div>
		  <!-- /.card-body -->
		  <div class="card-footer">
			Total: $ {{ number_format($total,2) }} 
		  </div>
		  <!-- /.card-footer-->
		</div>
		<!-- /.card -->
	  </div>
	</div>
  </div>
</section>

	
@endsection
<!-- /.content -->
