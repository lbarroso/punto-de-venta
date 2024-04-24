@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Reportes </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Reportes</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row">

  <div class="col-12">
  
      <div class="card card-default">
	  
          <div class="card-header">
              <h3 class="card-title">Reportes diarios</h3>
          </div>

          <div class="card-body">

              <div class="row">

					<div class="col-md-6">
						
						<div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="card-title m-0">Reporte</h5>
							</div>
							<div class="card-body">
							  <h6 class="card-title">Posición de almacen con existencias</h6>
			  
							  <p class="card-text"> Incluye importes valorizados a precio de costo y precio venta </p>
							  <a href="{{ route('posicion.almacen') }}" class="btn btn-primary"><i class="fas fa-download"></i> Descargar Excel</a>
							</div>
						</div>                        

					</div>

					<div class="col-md-6">
						
						<div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="card-title m-0">Reporte</h5>
							</div>
							<div class="card-body">
							  <h6 class="card-title">Productos</h6>
			  
							  <p class="card-text"> Con existencia </p>
							  <a href="{{ route('catalogo.pdf') }}" class="btn btn-primary"><i class="fas fa-download"></i> Descargar PDF</a>
							</div>
						</div>                        

					</div>
					
			  
              </div>

          </div>

      </div>

  </div>
  
</div>
    
@endsection


