@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Entradas de inventario </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">
					
					
					<a href="#" class="btn btn-outline-secondary"> cancelar  </a>
					<button class="btn btn-success"> <i class="fa fa-save"></i> Guardar entrada </button> &nbsp; 
				</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
					<div class="card-header d-flex justify-content-between align-items-center border border-secondary">						
						<div class="alert alert-secondary text-uppercase" id="artdesc-output" style="width:50%;">capturar producto</div>
						<div class="alert alert-info"> $ 0.00 </div>						
					</div>
					
                    <div class="card-body">

						<!-- Formulario para capturar el código de barras y otros detalles -->
						<form action="#" method="POST" class="row g-3" id="formCodBarras">
							@csrf
							<div class="col-auto">
								<label for="codigoBarras" class="visually-hidden">Código de Barras</label>
								<input type="text" class="form-control" id="codbarras" name="codbarras" placeholder="Código de Barras" onFocus="this.select()" onKeyPress="return enterCodbarras(this, event)" >
							</div>
			
							<div class="col-auto">
								<label for="doccant" class="visually-hidden">Cantidad</label>
								<input type="number" class="form-control" id="doccant" name="doccant" placeholder="Cantidad" onFocus="this.select()" onKeyPress="return handleEnter(this, event)">
							</div>
							<div class="col-auto">
								<label for="artprcosto" class="visually-hidden">Costo</label>
								<input type="text" class="form-control" id="artprcosto" name="artprcosto" placeholder="Costo" onFocus="this.select()" onKeyPress="return handleEnter(this, event)">
							</div>
							<div class="col-auto">
								<label for="artganancia" class="visually-hidden">Utilidad</label>
								<input type="number" class="form-control" id="artganancia" name="artganancia" placeholder="Utilidad (%)"  onFocus="this.select()" onKeyPress="return handleEnter(this, event)">
							</div>
							
							<div class="col-auto">
								<label for="actualizar" class="visually-hidden">Actua.</label>
								<select class="form-control" id="actualizar" name="actualizar" onKeyPress="return handleEnter(this, event)">
									<option value="SI"> SI </option>
									<option value="NO"> NO </option>
								</select>
							</div>
							
							<div class="col-auto">
								<label for="artprventa" class="visually-hidden">Precio de Venta</label>
								<input type="text" class="form-control" id="artprventa" name="artprventa" placeholder="Precio de Venta" onFocus="this.select()" onKeyPress="return handleEnter(this, event)">
							</div>
							<div class="col-md-2">
								<label for="artdescto" class="visually-hidden">Descuento</label>
								<input type="number" class="form-control" id="artdescto" name="artdescto" onFocus="this.select()" placeholder="Descto.(%)" required>
							</div>
							
						</form>
					
						<div> <hr> </div>
						<!--listado productos solo encabazados-->	
						<div class="table-responsive-sm">
						<table class="table table-striped table-bordered table-hover" id="entrada" class="display" style="width:100% ">                        
						  <thead class="thead-dark">
							  <tr>
								  <th>#</th>                                  
								  <th>Descripci&oacute;n</th>                                  
								  <th>Cant.</th>
								  <th>Precio</th>
								  <th>-%</th>
								  <th>Importe</th>
								  <th>Stock</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>
						  <!-- tbody:datatable /pvproducts.js -->

						</table>
						</div>					
					
					</div>
					
                </div>
				
            </div>
        </div>
    </section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('pventa/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('pventa/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('pventa/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('pventa/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('pventa/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('pventa/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/admin/entrada.js') }}"></script>
<!--rutas web -->
<script>
	var findCodeUrl = '{{ route("entrada.find.code",["code" => 0]) }}';
	var indexTableUrl = '{{ route("entrada.index.table") }}';
</script>
@endsection

@section('modal')

@endsection

