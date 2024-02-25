@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Editar código  </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Códigos</li>
            </ol>
        </div>
    </div>
</div>
@endsection
@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"> Actualizar codigo</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('codigos.update', $codigo->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('codigo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
