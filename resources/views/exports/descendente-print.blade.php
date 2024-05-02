
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Descendente</title>

  <!-- Theme style -->
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="container-fluid">

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">DESCENDENTE {{ $titulo }} ACUMULADO DEL PERIODO: {{ $fechaInicio }}  AL {{ $fechaFin }}</h3>

        </div>
		
        <div class="card-body">

			<table class="table table-striped table-bordered ">

				<thead>

					<tr>
						<th><strong>CODIGO</strong></th>
						<th><strong>DESCRIPCION</strong></th>
						<th><strong>PRECIO COSTO</strong></th>
						<th><strong>PRECIO VENTA</strong></th>
						<th><strong>DESCTO.%</strong></th>
						<th><strong>VENTA ACUM.</strong></th>
						<th><strong>PARTIC. % </strong></th>
						<th><strong>CANTIDAD</strong></th>
						
					</tr>
				</thead>
				<tbody>
		
					@foreach ($docdetas as $item)
						<tr>			
							<td>{{ $item->codbarras  }}</td>
							<td>{{ $item->artdesc }}</td>
							<td>{{ number_format($item->artprcosto,2) }}</td>
							<td>{{ number_format($item->artprventa,2) }}</td>
							<td>{{ number_format($item->artdescto,2) }}</td>
							<td>{{ number_format($item->importe,2) }}</td>		
							@if ($item->importe > 0) 
								<td width="13">{{  $item->importe / $total * 100 }} </td>
							@else
								<td width="13">{{  $item->importe }} </td>
							@endif							
							<td>{{ $item->cant }}</td>
						</tr>
					@endforeach
					
				</tbody>
				<tfoot>
					<tr>

						<td></td>
						<td></td>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> {{ $total }} </td>
						<td> </td>
						<td> </td>
						

					</tr>
				</tfoot>
			</table>		
		
        </div>

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

</body>

</html>
