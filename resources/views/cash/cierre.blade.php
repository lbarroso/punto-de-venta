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
		   
			<h1>Cierre del Día</h1>
			@if(session('success'))
		<div class="alert alert-success">
			{{ session('success') }}
		</div>
	@endif		
	
			@if($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li> <strong> {{ $error }} </strong> </li>
						@endforeach
					</ul>
				</div>
			@endif	
			<div class="row"> <br> </div>
			
			<!-- Botones de acción -->
			<div class="mb-3">
				<button class="btn btn-success" onclick="guardarCierre()">Guardar Cierre</button>
				<button class="btn btn-primary" onclick="window.print()">Imprimir Cierre</button>
			</div>

			<!-- Tarjetas de totales -->
			<div class="row">
			
				<!-- Saldo Anterior -->
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-header">Saldo Anterior</div>
						<div class="card-body">
							<h5 class="card-title">$ {{ $saldoAnterior }}</h5>
						</div>
					</div>
				</div>
				
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-header">Inicio de caja</div>
						<div class="card-body">
							<h5 class="card-title">$ {{ $inicio }}</h5>
						</div>
					</div>
				</div>				

				<!-- Total Ventas Diarias -->
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-header">Ventas Diarias</div>
						<div class="card-body">
							<h5 class="card-title">$ {{ $ventasDiarias }}</h5>
						</div>
					</div>
				</div>

				<!-- Total Entradas -->
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-header">Total Entradas</div>
						<div class="card-body">
							<h5 class="card-title">$ {{ $totalEntradas }}</h5>
						</div>
					</div>
				</div>

				<!-- Total Salidas -->
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-header">Total Salidas</div>
						<div class="card-body">
							<h5 class="card-title">$ {{ $totalSalidas }}</h5>
						</div>
					</div>
				</div>
				
				<!-- Saldo Actual -->
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-header" style="font-size: 18px; font-weight: bold; color: #007bff;">Saldo Actual</div>
						<div class="card-body">
							<h5 class="card-title">$ {{ number_format( $saldoActual, 2,'.',',') }}</h5>
							
						</div>
					</div>
				</div>
				
			</div>			
				
				
		  </div>
		  <!-- /.card-body -->
		  <div class="card-footer">
			&nbsp;
		  </div>
		  <!-- /.card-footer-->
		</div>
		<!-- /.card -->
	  </div>
	</div>
  </div>
</section>

<form action="{{ route('cierre.store') }}" method="POST" id="myForm">
    @csrf
    <input type="hidden" name="venta" value="{{ $ventasDiarias  }}">
    <input type="hidden" name="entrada" value="{{ $totalEntradas }}">
    <input type="hidden" name="salida" value="{{ $totalSalidas }}">
    <input type="hidden" name="saldo_actual" value="{{ $saldoActual }}">
	<input type="hidden" name="saldo_anterior" value="{{ $saldoAnterior }}" >
</form>

	
@endsection
<!-- /.content -->

    <script>
        function guardarCierre() {
            alert('Guardar cierre aún no implementado.');
			document.getElementById("myForm").submit();
			
        }
    </script>
