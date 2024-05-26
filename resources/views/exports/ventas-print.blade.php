
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ventas</title>

  <!-- Theme style -->
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="container-fluid">

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">VENTAS  DEL PERIODO: {{ $fechaInicio }}  AL {{ $fechaFin }}</h3>

        </div>
		
        <div class="card-body">

			<table class="table table-striped table-bordered ">

				<thead>
					<tr>
						<th><strong>FECHA</strong></th>
						<th><strong>CODIGO</strong></th>
						<th><strong>DESCRIPCION</strong></th>
						<th><strong>CANTIDAD</strong></th>
						<th><strong>PRECIO VENTA</strong></th>
						<th><strong>DESCTO.%</strong></th>
						<th><strong>IMPORTE</strong></th>				
						<th><strong>FORMA PAGO</strong></th>
						<th><strong>STATUS</strong></th>
					</tr>
				</thead>
				<tbody>
		
					@foreach ($docdetas as $item)
						<tr>
							<td>{{ $item->pvfecha  }}</td>
							<td>{{ $item->codbarras  }}</td>
							<td>{{ $item->artdesc }}</td>
							<td>{{ $item->cant }}</td>
							<td>{{ number_format($item->artprventa,2) }}</td>
							<td>{{ number_format($item->artdescto,2) }}</td>							
							<td>{{ number_format($item->importe,2) }}</td>						 
							<td>{{ $item->pvtipopago }}</td>
							<td>{{ $item->status }}</td>
						</tr>
					@endforeach
					
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>{{ number_format($total,2) }}</td>
						<td> </td>
					</tr>
				</tfoot>
			</table>		
		
        </div>

		<div class="card-footer">
			@foreach ($totales as $row) 

				Total de ventas por {{ $row->pvtipopago }} : {{ number_format($row->total,2) }}  <br>
				
			@endforeach			

			Total general de ventas: $ {{ number_format($total,2) }} 
		</div>

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

</body>

</html>
