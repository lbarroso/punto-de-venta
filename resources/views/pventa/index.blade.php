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
		   
			<div id="container">
				<div id="product-list">
					<div id="barcode-section">
						<!-- Campo de entrada para el código de barras -->
						<form id="formCodigo">					
							<div class="input-group input-group-lg">
								<input type="text" name="codigo" id="codigo" placeholder="Introduce el código de barras del producto" onKeyPress="return enterCodigo(event,0)" class="form-control">
								<span class="input-group-append">
									<button type="button" Onclick="return enterCodigo(event,1)" class="btn btn-info btn-flat"> <i class="fa fa-search"></i> </button>
								</span>
							</div>												
						</form>
						<br>

						  <!--listado productos solo encabazados-->	
						  <div class="table-responsive-sm">
						  <table class="table table-hover" id="table" class="display" style="width:100% ">                        
							  <thead>
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

				<div id="total-section">
					<!-- Totales -->
					<div id="total"> </div>
					<div id="total-products" class="text-muted"></div>
					<!-- Agrega anuncios aquí -->
					<div id="ad-container">
						<img class="ad" src="{{ asset('admin/dist/img/welcome.jpg') }}" alt="Anuncio 1">
						<!-- Agrega más anuncios según sea necesario -->
					</div>

					<img id="logo" src="{{ asset('admin/dist/img/credit/visa.png') }}" alt="Logo de la Empresa">
				
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


@endsection
<!-- /.content -->

@section('styles')
<link rel="stylesheet" href="{{ asset('pventa/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('pventa/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@endsection

@section('scripts')
<script src="{{ asset('pventa/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('pventa/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('pventa/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('pventa/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/luz.js') }}"></script>
<!--rutas web apiResource:docdetas-->
<script>

    var indexUrl = '{{ route("pvproducts.index") }}';
	var storeUrl = '{{ route("pvproducts.store") }}';
	var showUrl = '{{ route("pvproducts.show",["pvproduct" => 0]) }}';
    var updateUrl = '{{ route("pvproducts.update",["pvproduct" => 0]) }}';
    var deleteUrl = '{{ route("pvproducts.destroy",["pvproduct" => 0]) }}';
	var totalUrl = '{{ route("venta.total") }}';
	var cashUrl = '{{ route("venta.cash",["cash" => 0]) }}';
	var findUrl = '{{ route("pvproducts.find",["texto" => 0]) }}';
	var docdetaStoreUrl = '{{ route("docdeta.store") }}';
	var totalProductsUrl = '{{ route("venta.totalproducts") }}';
	
	
</script>
<!--contiene el metodo buscar data tables-->
<script src="{{ asset('js/pventa/pvproduct.js') }}"></script>
    <script>
	@if($docord > 0)
        $(document).ready(function() {
            // Mostrar ventana emergente al cargar la página
            console.log('Mostrar ventana emergente');
			// Abre una ventana emergente con el nombre 'ticketWindow' y el URL de la página de ticket
			var ticketWindow = window.open('https://puntoventa.sistemasloop.com/public/venta/ticket/{{ $docord }}', 'ticketWindow', 'width=400,height=500');
			// En caso de que el navegador bloquee la ventana emergente, puedes mostrar un mensaje de alerta
			// https://puntoventa.sistemasloop.com/public/pvproducts
			if (ticketWindow === null || typeof(ticketWindow) === "undefined") {
				alert('¡Por favor, habilite las ventanas emergentes para ver el ticket de venta!');
			}			
        });
		@php
			$docord = 0;
		@endphp
	@endif
    </script>
	<script>
	// Cuando se presione F2, abrir la modal
	document.addEventListener("keydown", function(event) {
	  // console.log("views/pventa/index"+event.key);
	  
	  if (event.key === "F2") {
		openModalConfirm();
	  }
	  if (event.key === "F9") {
		openModalFindProduct( );
	  }	  
	  if (event.key === "Escape") {
		return $('#codigo').focus();
	  }	  
	  
	});
	
	function openModalConfirm( )
	{
		
		$.ajax({
			url: totalUrl,
			type: 'get',
			success:function(response){
				
				const total = parseFloat(response.total);
				
				if(!isNaN(total) && total > 0){
					
					$('#modal-confirm').modal();
					$('#venta-total').html(response.total);
					$('#cash').focus();
					
				}else return $('#codigo').focus();
				
			},
			error:function(res){
				console.log(res);
			}
		});
	}		
	
	function openModalFindProduct( )
	{
		
		$.ajax({
			url: totalUrl,
			type: 'get',
			success:function(response){
				
				const total = parseFloat(response.total);

				$('#modal-findproduct').modal();
				$('#venta-total').html(response.total);
				$('#textoId').focus();
				
			},
			error:function(res){
				console.log(res);
			}
		});
	}			
	</script>
@endsection

<!--buscar producto-->
@section('modal')
    @include('pventa.modalProduct')
	@include('pventa.modalFindProduct')
    @include('pventa.modalConfirmVenta')
@endsection


