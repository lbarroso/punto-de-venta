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
					<a href="{{ route('compras.index') }}" class="btn btn-outline-secondary"> cancelar  </a>
					<button class="btn btn-success"  data-toggle="modal" data-target="#modal-compra"> <i class="fa fa-save"></i> Guardar entrada </button> &nbsp; 
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
						<div class="alert alert-info" style="font-size:16pt;"> <span id="total-entradas"> </span>  </div>						
					</div>
					
                    <div class="card-body">

						<!-- Formulario para capturar el código de barras y otros detalles -->
						<form action="#" method="POST" class="row g-3" id="formAjaxProduct">
							@csrf
							<div class="col-auto">
								<label for="codigoBarras" class="visually-hidden">Código de Barras</label>
								<input type="text" class="form-control" id="codbarras" name="codbarras" placeholder="Código de Barras" onFocus="this.select()" onKeyPress="return enterCodbarras(this, event)">
							</div>
			
							<div class="col-md-2">
								<label for="doccant" class="visually-hidden">Cantidad</label>
								<input type="number" class="form-control" id="doccant" name="doccant" placeholder="Cantidad" onFocus="this.select()" onKeyPress="return handleEnter(this, event)">
							</div>
							
							<div class="col-auto">
								<label for="artprcosto" class="visually-hidden">Costo</label>
								<input type="text" class="form-control" id="artprcosto" name="artprcosto" placeholder="Costo" onFocus="this.select()" onchange="artGanancia(); alert('Seleccione actua. =SI  para modificar su precio de venta en todo el iventario')"  onKeyPress=" return handleEnter(this, event); ">
							</div>
							
							<div class="col-md-2">
								<label for="artganancia" class="visually-hidden">Ganancia</label>
								<input type="number" class="form-control" id="artganancia" name="artganancia" placeholder="Utilidad (%)"  onFocus="this.select()" onchange="artGanancia(); alert('Seleccione actua. =SI  para modificar su precio de venta en todo el iventario')" onKeyPress="return handleEnter(this, event)">
							</div>
							
							<div class="col-auto">
								<label for="updateArtprventa" class="visually-hidden">Actua.</label>
								<select class="form-control" id="updateArtprventa" name="updateArtprventa" onKeyPress="return handleEnter(this, event)">
									<option value="0"> NO </option>
									<option value="1"> SI </option>
									
								</select>
							</div>
							
							<div class="col-auto">
								<label for="artprventa" class="visually-hidden">Precio de Venta</label>
								<input type="text" class="form-control" id="artprventa" name="artprventa" placeholder="Precio de Venta" onFocus="this.select()" onKeyPress="return handleEnter(this, event)">
							</div>
							
							<div class="col-md-2">
								<label for="artdescto" class="visually-hidden">Descuento</label>
								<input type="number" class="form-control" id="artdescto" name="artdescto" onFocus="this.select()" placeholder="Descto.(%)" onKeyPress="return entradaAjaxProduct(event)">
							</div>
							
							<!--ocultos-->
							<input type="hidden" name="id" id="id" value="0">
							<input type="hidden" name="artdesc" id="artdesc" value="">
							<input type="hidden" name="artcve" id="artcve" value="0">
							<input type="hidden" name="stock" id="stock" value="0">
							<input type="hidden" name="artpesogrm" id="artpesogrm" value="1">
							<input type="hidden" name="artpesoum" id="artpesoum" value="PZA">						
							
						</form>
					
						<div> <hr> </div>
						<!--listado productos solo encabazados-->	
						<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="productPurchases" class="display" style="width:100% ">                        
						  <thead class="thead-dark">
							  <tr>
								  <th>#</th>
								  <th>codbarras</th>
								  <th>Descripci&oacute;n</th>                                  
								  <th>Cant.</th>
								  <th>P.Compra $</th>
								  <th>Descto.</th>
								  <th>Importe</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>
						  
						  <!-- tbody:datatable /entrada.js  -->

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
<script src="{{ asset('js/admin/ganancia.js') }}"></script>
<!--rutas web -->
<script>
	var urlProveedores = '{{ route("products.proveedores") }}'; 
	var findCodeUrl = '{{ route("entrada.find.code",["code" => 0]) }}';
	var findProductUrl = '{{ route("entrada.find.product",["texto" => 0]) }}';
	var docdetaStoreUrl = '{{ route("entrada.docdeta.store") }}';
	var indexTableUrl = '{{ route("entrada.index.table") }}';
	var ajaxProductUrl = '{{ route("entrada.ajax.product") }}';
	var showProductUrl = '{{ route("entrada.product.show",["id" => 0]) }}';
	var deleteProductUrl = '{{ route("entrada.product.delete",["id" => 0]) }}';
	var updateProductUrl = '{{ route("entrada.product.update",["id" => 0]) }}';
	var entradaTotalUrl = '{{ route("entrada.total") }}';		
</script>
@endsection

@section('modal')
	@include('entradas.modalProduct')
	@include('entradas.modalCompra')
	@include('entradas.modalFindProduct')
@endsection

