@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Códigos  </h1>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Claves genericas
                            </span>

                             <div class="float-right">
								<a href="{{ route('products.index') }}" class="btn btn-default btn-md "  data-placement="left">
								  Cancelar
								</a>
							    &nbsp; 
                                <a href="{{ route('codigos.create') }}" class="btn btn-primary btn-md float-right"  data-placement="left">
                                  Nuevo código
                                </a>

                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>                                        
										<th>Producto descripción</th>
										<th>Código</th>
                                        <th></th>
                                    </tr>
                                </thead>
								<?php $i = 0; ?> 
                                <tbody>
                                    @forelse($codigos as $codigo)
                                        <tr>
                                            <td>{{ ++$i }}</td>                                            
											<td>{{ $product->artdesc }}</td>
											<td>{{ $codigo->codigo }}</td>
                                            <td>
                                                <form action="{{ route('codigos.destroy',$codigo->id) }}" method="POST">
                                                             
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> eliminar </button>
                                                </form>
                                            </td>
                                        </tr>
									@empty
										<tr><td colspan="4"> No hay claves agregadas para; {{ $product->artdesc }}</td></tr>
									@endforelse									
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $codigos->links() !!}
            </div>
        </div>
    </div>
@endsection
