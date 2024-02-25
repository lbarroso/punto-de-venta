@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detalle código </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Codigos</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title"> Clave</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('codigos.index') }}"> regresar atrás</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Product Id:</strong>
                            {{ $codigo->product_id }}
                        </div>
                        <div class="form-group">
                            <strong>Codigo:</strong>
                            {{ $codigo->codigo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
