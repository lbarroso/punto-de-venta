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
		   
			<h1>Lista de Transacciones</h1>
			
			<div class="row"> <br> </div>
			
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Tipo</th>
							<th>Monto</th>
							<th>Descripción</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($transactions as $transaction)
						<tr>
							<td>{{ $transaction->id }}</td>
							<td>{{ $transaction->type }}</td>
							<td>{{ $transaction->amount }}</td>
							<td>{{ $transaction->description }}</td>
							<td>{{ $transaction->created_at->toFormattedDateString() }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>			

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

	
@endsection
<!-- /.content -->
