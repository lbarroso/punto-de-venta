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


<div class="row">
  <div class="col-12">
      <div class="card card-default">
          <div class="card-header">
              <h3 class="card-title">Situacion actual de inventario</h3>
          </div>

          <div class="card-body">
    
              <div class="row">
                  <div class="col">

                    <div class="table-responsive-sm">  
						cotenido tabla
                    </div>

                  </div>
              </div>

          </div>

      </div>

  </div>
</div>


@endsection
