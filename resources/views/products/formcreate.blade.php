@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Agregar nuevo producto  </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Productos </li>
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
              <h3 class="card-title"> Campos obligatorios (*) </h3>
          </div>

          <div class="card-body">

              <div class="row">
                  <div class="col">
					<form method="post" id="formProductCreate" action="{{ route('product.store') }}"  role="form" enctype="multipart/form-data">
					@csrf
					@if($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach($errors->all() as $error)
									<li> <strong> {{ $error }} </strong> </li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="container">
						
						<div class="row">
						  <div class="col-10">        
							<div class="form-group">
								<div class="mb-3">
									<label for="codbarras" class="form-label">Código de Barras</label>
									<input value="{{ old('codbarras') }}" type="text" class="form-control" id="codbarras" name="codbarras" placeholder="Ingrese el código de barras" onKeyPress="return handleEnter(this, event)">
								</div>
							</div>
						   </div>
						
							<div class="col-2"> v*</div>
						</div>

					 
						<div class="row">
							<div class="col">
								<div class="form-group">
									<div class="mb-3">
										<label for="artdesc" class="form-label">Descripción del Artículo*</label>
										<input onkeyup="this.value = this.value.toUpperCase();" value="{{ old('artdesc') }}" type="text" class="form-control" id="artdesc" name="artdesc" placeholder="Ingrese la descripción del artículo" onKeyPress="return handleEnter(this, event)">
									</div>			
								</div>            
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-10">					
								<div class="form-group">
									<div class="input-group mb-3">
										<label for="category_id" class="form-label">Categoría*</label>
										<select name="category_id" id="category_id" class="form-control select2bs4" style="width: 100%;" onKeyPress="return handleEnter(this, event)">
											<option value="">Selecciona una opción</option>								
										</select>	                                             
									</div>

								</div>            
							</div>
							
							<div class="col-2"> 
								<label for="categorylink" class="form-label"> &nbsp; </label>
								<span id="categorylink" class="btn btn-info btn-sm mr-1"> <i class="nav-icon fas fa-plus"></i> nueva </span>
							</div>
							
						</div>                    

						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="artmarca" class="form-label">Marca</label>
									<input onkeyup="this.value = this.value.toUpperCase();" value="{{ old('artmarca') }}" type="text" class="form-control" id="artmarca" name="artmarca" placeholder="Ingrese la marca" onKeyPress="return handleEnter(this, event)">
								</div>
							</div>
							<div class="col-2">
								<div class="form-group">
									<label for="artpesoum" class="form-label">U.M.</label>
									<input  onkeyup="this.value = this.value.toUpperCase();" value="{{ old('artpesoum') == '' ? 'PZA' : old('artpesoum') }}" type="text" class="form-control" id="artpesoum" name="artpesoum" placeholder="Ingrese um" value="PZA" onKeyPress="return handleEnter(this, event)">
								</div>            
							</div>        							
							<div class="col-2">        
								<div class="form-group">
									<label for="artpesogrm" class="form-label">Peso </label>
									<input value="{{ old('artpesogrm') == '' ? '1' : old('artpesogrm') }}" type="number" min="0" step="1" class="form-control" id="artpesogrm" name="artpesogrm" placeholder="Ingrese grm" onKeyPress="return handleEnter(this, event)">
								</div>
							</div>

						</div>    

						<div class="row">
						
							<div class="col">
								<div class="form-group">
									<label for="prvcve" class="form-label">Proveedor</label>
									<select name="prvcve" id="prvcve" class="form-control" onKeyPress="return handleEnter(this, event)">
										<option value="">Selecciona una opción</option>	
									</select>
								</div>            
							</div>
							
							<div class="col">
								<div class="form-group">
									<label for="artprcosto" class="form-label">Precio costo</label>
									<input type="number" min="0" step="0.01" class="form-control" id="artprcosto" name="artprcosto" onchange="artGanancia()" onKeyPress="return handleEnter(this, event)">
								</div>            
							</div>
							<div class="col-1">
								<div class="form-group">
									<label for="artganancia" class="form-label"> %</label>
									<input type="number" value="0" min="0" step="5" class="form-control" id="artganancia" name="artganancia" onchange="artGanancia()" onKeyPress="return handleEnter(this, event)">					  
								</div>            
							</div>
							<div class="col">
								<div class="form-group">
									<label for="artprventa" class="form-label">Precio venta*</label>
									<input type="number" min="0.01" step="0.01" class="form-control" id="artprventa" name="artprventa"  onKeyPress="return handleEnter(this, event)">
								</div>            
							</div>
						</div>    
			

						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label for="stock" class="form-label">Existencia actual</label>
									<input type="number" class="form-control" id="stock" name="stock"  onKeyPress="return handleEnter(this, event)">														
								</div>            
							</div>												
						</div>    

						<button type="button" id="submitBtn" class="btn btn-primary"> Guardar producto</button>
						<a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
					</div>				  
					
					</form>		  
                  </div>
              </div>

          </div>

      </div>
  </div>
</div>

<!-- modal -->
<div class="modal fade" id="modal-formCreate" data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
	  <h4 class="modal-title">Notificación</h4>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body" id="modal-body-create">
	  <p> &nbsp; </p>
	</div>
	<div class="modal-footer justify-content-between">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  <button type="button" id="modalBtn" class="btn btn-success">Aceptar</button>
	</div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



@endsection

@section('styles')
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('scripts')

	<!--cargar categorias-->
	<script> var urlCategories = '{{ route("products.categories") }}'; </script>
	<script> var urlProveedores = '{{ route("products.proveedores") }}'; </script>
	<script> var urlProductValidation = '{{ route("product.validation") }}'; </script>	
	<script> var urlCategoryStore = '{{ route("categories.store") }}'; </script>	
	<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script> 
	<script src="{{ asset('js/admin/ganancia.js') }}"></script>
	<script src="{{ asset('js/admin/category.js') }}"></script>
	<script src="{{ asset('js/admin/productcreate.js') }}"></script>

	<script>
		/********************
		* validar formulario
		********************/
		var btn = document.querySelector("#submitBtn"); // btn
		// onclick evento
		btn.addEventListener("click",formvalidation);	
		function formvalidation(e){
			e.preventDefault();
			$.ajax({
				
				type: 'get',
				data: $("#formProductCreate").serialize(),
				url: urlProductValidation,
				success: function(response){
					$('#modal-formCreate').modal({backdrop: 'static', keyboard: false}); // bloquear modal
					$('#modal-formCreate').modal("hide");
					$("#modal-formCreate").modal("show"); // abrir modal		
					
					if(response == 'success'){
						$('#modal-body-create').html('<div class="alert alert-success"> ¿Confirma agregar nuevo producto?</div>'); // success						
						$('#modalBtn').prop('disabled', false);
						$('#modalBtn').focus();
					}else{				
						$('.modal-body').html('<div class="alert alert-danger">'+response+'</div>'); // error
						$('#modalBtn').prop('disabled', true);
					}
					
				} // success	
				
			}); // $ajax

		} // function 
		
	</script>

	<script>
		/********************
		* enviar formulario
		********************/
			var btn = document.querySelector("#modalBtn"); // btn
			var form = document.querySelector("#formProductCreate"); // form		
			
			// onclick evento
			btn.addEventListener("click",formSubmit);
			
			function formSubmit(e)
			{
				e.preventDefault();			

				form.submit();
		
			}
	</script>

@endsection

@section('modal')
    @include('products.modalCategory')	
@endsection

