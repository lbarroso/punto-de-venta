@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Salidas de mercancias </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">
					<a href="{{ route('salida.index.table') }}" class="btn btn-primary"> Agregar salidas  </a>
				</li>
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
              <h3 class="card-title"> Listado salidas del periodo: <span class="text-muted"> del {{ $fecha_inicio ?? date('d/m/Y') }} al {{ $fecha_fin ?? date('d/m/Y') }} </span> </h3>
          </div>

          <div class="card-body">
		  
              <div class="row">
                  <div class="col-12 mb-3">
					<form action="{{ route('salidas.history') }}" class="form-inline" method="post">
						@csrf
								
						<label for="email2" class="mb-2 mr-sm-2">Fecha Inicio:</label>
						<input type="date" id="fecha_inicio" class="form-control mb-2 mr-sm-2" name="fecha_inicio" required>
						
						<label for="pwd2" class="mb-2 mr-sm-2">Fecha Final:</label>
						<input type="date" id="fecha_fin" class="form-control mb-2 mr-sm-2" name="fecha_fin" required>
						
						<button type="submit" class="btn btn-primary mb-2">Generar Reporte</button>
					</form>				  
                  </div>
              </div>	  
			  
              <div class="row">
			  
                  <div class="col">

                    <div class="table-responsive-sm">  
                      <table class="table table-striped table-bordered table-hover" id="table" class="display" style="width:100%; font-size:11pt">                        
                          <thead class="thead-dark">
                              <tr>
								<th>Fecha</th>
								<th>Folio</th>
								<th>Cliente</th>								
								<th>Total</th>
								<th>Status</th>
								<th>Acciones</th>
                              </tr>
                          </thead> 
						  <tbody>
							@foreach ($salidas as $salida)
							<tr>
								<td>{{ $salida->fecha->format('d/m/y') }}</td>
								<td>{{ $salida->id }} </td>
								<td>{{ $salida->cliente }}</td>								
								<td align="right">$ {{ number_format($salida->total,2) }}</td>
								<td>{{ $salida->status }}</td>
								<td> 
									<a href="{{ route('salidas.pdf', ['id' => $salida->id]) }}" target="_pdf" title="pdf" class="btn btn-primary btn-sm mr-1"> <i class="fa fa-file-pdf"> </i> </a> 
									<a href="{{ route('salida.ticket', ['id' => $salida->id]) }}" target="_ticket" title="ticket" class="btn btn-primary btn-sm mr-1"> <i class="fa fa-print"></i> </a>  
									<a href="#" title="cancelar" class="btn btn-danger btn-sm mr-1"> <i class="fa fa-times"></i> </a>  
																	 
								</td>								
							</tr>
							@endforeach
						</tbody>
                      </table>

						<div>
							{{ $salidas->links() }}
						</div>					  
                    </div>

                  </div>
              </div>

          </div>

      </div>

  </div>
</div>

<script>
// Function to format date as YYYY-MM-DD
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

document.addEventListener('DOMContentLoaded', function() {
    // Set the fecha_inicio and fecha_fin fields to today's date
    var today = formatDate(new Date());
    document.getElementById('fecha_inicio').value = today;
    document.getElementById('fecha_fin').value = today;
});
</script>
    
@endsection



