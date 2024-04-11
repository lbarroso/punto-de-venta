@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Productos {{ config('app.name', 'Laravel') }} </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Productos</li>
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
              <h3 class="card-title">Listado productos activos</h3>
          </div>

          <div class="card-body">
              <div class="row">
                  <div class="col-12 mb-3">
                      <a href="{{ route('product.create') }}" class="btn btn-primary modal-trigger" > <i class="fa fa-plus"></i> Nuevo producto</a>
						  <small class="lead">  [F2] </small>
                  </div>
              </div>

              <div class="row">
                  <div class="col">

                    <div class="table-responsive-sm">  
                      <table class="table table-hover" id="table" class="display" style="width:100%; font-size:11pt">                        
                          <thead>
                              <tr>
                                  <th>Id</th>                                  
                                  <th>Descripci&oacute;n</th>
                                  <th>Marca</th>
								  <th>Detalle</th>
                                  <th>codbarras</th>
                                  <th>Costo</th>
                                  <th>Venta</th>
                                  <th>Stock</th>                                  
                                  <th>Acciones</th>
                              </tr>
                          </thead>                        
                      </table>
                    </div>

                  </div>
              </div>

          </div>

      </div>

  </div>
</div>
    
@endsection


@section('styles')

<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!--rutas web apiResource:products-->
<script>
    var indexUrl = '{{ route("products.index") }}';
	var storeUrl = '{{ route("products.store") }}';
    var updateUrl = '{{ route("products.update",["product" => 0]) }}';
	var showUrl = '{{ route("products.show",["product" => 0]) }}';
    var deleteUrl = '{{ route("products.destroy",["product" => 0]) }}';
    var urlCategories = '{{ route("products.categories") }}';
	var urlProveedores = '{{ route("products.proveedores") }}';
    var urlImageStore = '{{ route("images.store") }}';
    var urlProductCodes = '{{ route("product.codes",["id" => 0]) }}';
	var urlDeleteCodes = '{{ route("delete.codes",["id" => 0]) }}';
	var urlStoreCodes = '{{ route("store.codes") }}';

</script>
<!--contiene el metodo buscar data tables-->
<script src="{{ asset('js/admin/product.js') }}"></script>
<script src="{{ asset('js/admin/discount.js') }}"></script>
<script src="{{ asset('js/admin/property.js') }}"></script>
<script src="{{ asset('js/admin/image.js') }}"></script>
<script src="{{ asset('js/admin/ganancia.js') }}"></script>


@endsection
<!--Agregado rapido nuevo producto-->
@section('modal')
    @include('products.modalProduct')
    @include('products.modalDiscount')
    @include('products.modalProperty')	
    @include('products.modalImage')	
	@include('products.modalCode')	
@endsection


