@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard {{ config('app.name', 'Laravel') }} </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row-md-12">

  <div class="col-md-6">
	  <div class="card" >
		<img src="{{ asset('admin/dist/img/welcome.jpg') }}" class="rounded" width="210"/>
		<div class="card-body">
		  <h4 class="card-title">Sistema Punto de Venta</h4>
		  <p class="card-text"> &nbsp; </p>
		  <a href="{{ route('pvproducts.index') }}" class="btn btn-primary">Iniciar sesi&oacute;n</a>
		</div>
	  </div>
  </div>
  
  <div class="col-md-6"></div>
  
</div>
  



@endsection
