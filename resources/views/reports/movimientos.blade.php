<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Movimientos de Artículos</title>
</head>
<body>

	<div class="container mt-4">
	
    <h1>Movimientos por clave</h1>
	
	{{-- Formulario para seleccionar mes/año y código de barras --}}
    <form action="{{ route('inventory.result') }}" method="POST" class="form-inline">
	
        @csrf
        <div>
            <select name="year" id="year" class="form-control">
                @for ($i = now()->year; $i >= 2024; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>           
            <select name="month" id="month" class="form-control">
				@php
					$currentMonth = date('n'); // Obtiene el mes actual como número sin ceros iniciales (1-12)
				@endphp			
                @foreach (range(1, 12) as $month)
					<option value="{{ $month }}" {{ $month == $currentMonth ? 'selected' : '' }}>
						{{ date('F', mktime(0, 0, 0, $month, 1)) }}
					</option>                    
                @endforeach
            </select>
        </div>
        <div>
            <input type="text" id="codbarras" name="codbarras" class="form-control" placeholder="código de barras" required>
        </div>
	
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
		
    </form>
	
	<div class="row"> <br> </div>
	<h4> 
		@if (!empty($product->artdesc))
			{{ $product->id }} /
			{{ $product->codbarras }} 
			&nbsp;
			{{ $product->artdesc }} 
			 <small> Existencia: </small> <span class="badge badge-info"> {{ $product->stock }}  </span>
		@endif
	</h4>
	<div class="row"> <br> </div>
	
	@if($movimientos->isEmpty())
		<p>No hay movimeintos disponibles.</p>
	@else
		<div class="table-responsive-sm">  	
	
		<table class="table table-striped table-bordered table-hover" id="table" class="display" style="width:100%; font-size:11pt">
			<thead class="thead-dark">
				<tr>
					<th>Fecha</th>
					<th>Referencia</th>
					<th>Folio</th>
					<th>Movimiento</th>
					<th>Entrada</th>
					<th>Salida</th>
					<th>Existencia</th>
					
				</tr>
			</thead>
			<tbody>
				@php $existencia = 0; $total_salida = $total_entrada = 0; @endphp
				@foreach ($movimientos as $movimiento)
                @php
                    if ($movimiento->movcve == 52) {
                        $entrada = $movimiento->doccant;
                        $salida = 0;
                        $existencia += $movimiento->doccant; // Incrementa la existencia
                    } elseif (in_array($movimiento->movcve, [51, 53])) {
                        $entrada = 0;
                        $salida = $movimiento->doccant;
                        $existencia -= $movimiento->doccant; // Decrementa la existencia
                    } else {
                        $entrada = 0;
                        $salida = 0;
                    }
                @endphp				
				<tr>
					<td>{{ $movimiento->created_at->format('d-m-Y') }}</td>
					<td>{{ $movimiento->referencia }}</td>                
					<td>{{ $movimiento->docord }}</td>
					<td>{{ $movimiento->movimiento->movdesc ?? 'N/A' }}</td>
                    <td>{{ $entrada }}</td>
                    <td>{{ $salida }}</td>
                    <td>{{ $existencia }}</td>
				</tr>

				@php $total_salida += $salida; $total_entrada += $entrada; @endphp
				
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4"> </td>
					<td class="text-muted">{{ $total_entrada }}</td>
					<td class="text-muted">{{ $total_salida }}</td>
					<td class="text-muted">{{ $total_entrada -  $total_salida }} </td>
				</tr>
			</tfoot>
		</table>
		
		</div>
	@endif

    <script>
        window.onload = function() {
            document.getElementById('codbarras').focus();
        };
    </script>
	
	</div>
</body>
</html>