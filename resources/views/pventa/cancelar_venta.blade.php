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
		   
			<h1>Cancelar venta</h1>
			
		   @if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@elseif(session('error'))
				<div class="alert alert-danger">
					{{ session('error') }}
				</div>
			@endif

			<form action="{{ route('venta.cancelar', ['id' => $venta->id]) }}" method="POST">
				@csrf
				<div class="form-group">
					<label for="password">Confirmar con Contraseña:</label>
					<input type="password" class="form-control" id="password" name="password" style="width:auto" required>
				</div>
				<a href="{{ route('daily.sales') }}" class="btn btn-default"> Cancelar </a>
				<button type="submit" class="btn btn-primary">Confirmar Cancelación</button>
			</form>
		
		  </div>

		</div>
		<!-- /.card -->
		
	  </div>
	  
	</div>
	
  </div>
  
</section>
	
@endsection
<!-- /.content -->
