@extends('layouts.pv')

<!-- Main content -->
@section('content')

<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-12">
		<!-- Default box -->
		<div class="card">  
			
		  <div class="card-header"> <i class="fas fa-user"></i> {{ ucwords(Auth::user()->name) }} </div>
		  
		  <div class="card-body">    
		  
			@if($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li> <strong> {{ $error }} </strong> </li>
						@endforeach
					</ul>
				</div>
			@endif
			
			@if($success)
				<div class="alert alert-success">
				  <strong>Success!</strong> {{ $success }}
				</div>				
			@endif

			<form action="{{ route('password.update') }}" method="POST">

				@csrf
				<label for="password">Nueva Contraseña:</label>
				<input type="password" name="password" id="password" class="form-control">
				
				<br>
				<label for="password_confirmation">Confirmar Contraseña:</label>
				<input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
				
				<br>
				<button type="submit" class="btn btn-primary">Cambiar Contraseña</button>		
					
			</form>	
						
						
		  </div>
		  <!-- /.card-body -->
		  <div class="card-footer">
			No olvide anotar su nueva contraseña para recordarla
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
