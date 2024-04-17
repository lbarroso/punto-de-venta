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
		   
			<h1>Movimientos de caja</h1>
			
			<div class="row"> <br> </div>
		  
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Movimientos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Iniciar Caja</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Realizar Retiro</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Registrar Ingreso</a>
                  </li>
                </ul>
              </div>
			  
              <div class="card-body">
			  
				@if(session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif			  
			  
                <div class="tab-content" id="custom-tabs-four-tabContent">
				
                  <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                     
					

					<!-- Info boxes -->
					<div class="row justify-content-end">

					  <div class="col-12 col-sm-3 col-md-3">
						<div class="info-box mb-3">
						  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

						  <div class="info-box-content">
							<span class="info-box-text">Ventas diarias</span>
							<span class="info-box-number">$ {{ $totalSales }}</span>
						  </div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					  </div>
			  
					</div>
					<!-- /.row -->
					
					<h3>Lista de Transacciones</h3>
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
								<td>$ {{ number_format($transaction->amount, 2,'.','') }} </td>
								<td>{{ $transaction->description }}</td>
								<td>{{ $transaction->created_at->format('d-m-Y') }}</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Total </th>
								<th>$ {{ number_format($totalAmount, 2,'.','') }}</th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>						
					</table>						 
                  
				  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                    <h1>Iniciar Caja</h1>
                    <form action="{{ route('cash.start') }}" method="POST">
                        @csrf
                        <label for="amount">Monto inicial:</label>
                        <input class="form-control" type="number" id="amount" name="amount" step="0.01" required>
                        <button class="btn btn-primary" type="submit">Iniciar Caja</button>
                    </form>
                  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                    <h1>Retiro de Caja</h1>
                    <form action="{{ route('cash.withdraw') }}" method="POST">
                        @csrf
                        <label for="amount">Monto a retirar:</label>
                        <input class="form-control" type="number" id="amount" name="amount" step="0.01" required>
                        <label for="description">Descripción:</label>
                        <input class="form-control" type="text" id="description" name="description">
                        <button class="btn btn-primary" type="submit">Realizar Retiro</button>
                    </form>
                  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                    <h1>Registrar Ingreso</h1>
                    <form action="{{ route('cash.sale') }}" method="POST">
                        @csrf
                        <label for="amount">Monto a abonar:</label>
                        <input class="form-control" type="number" id="amount" name="amount" step="0.01" required>
                        <button class="btn btn-primary" type="submit">Registrar Abono</button>
                    </form>
                  </div>
				  
                </div>
				
              </div>
              <!-- /.card -->
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

	
@endsection
<!-- /.content -->
