<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Factura </title>
	
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Nota:</h5>
              {{ $compra->comentarios }}
            </div>

				<!-- Main content -->
				<div class="invoice p-3 mb-3">
				  <!-- title row -->
				  <div class="row">
					<div class="col-12">
					  <h4>
						<i class="fas fa-globe"></i> {{ $empresa->regnom }} 
						<small class="float-right">Fecha: {{ date('m/d/Y') }} </small>
					  </h4>
					</div>
					<!-- /.col -->
				  </div>
				  <!-- info row -->
				  <div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						&nbsp;
					  <address>
						<strong> {{ $proveedor->prvrazon }} </strong><br>
						{{ $proveedor->prvrfc }} <br>
						&nbsp; <br>
						{{ $proveedor->prvtel  }} <br>
						&nbsp; 
					  </address>
					</div>
					<!-- /.col -->
					<div class="col-sm-4 invoice-col">
					  &nbsp;
					  <address>
						<strong>  {{ config('app.name', 'Laravel') }} </strong><br>
						{{ $empresa->regnom }} <br>
						{{ $empresa->regloc }}<br>
						{{ $empresa->regtel }} <br>
						Elaboro: {{ $compra->user_name }}
					  </address>
					</div>
					<!-- /.col -->
					<div class="col-sm-4 invoice-col">
					  <b>Factura #{{ $compra->factura }} </b><br>
					  <br>
					  <b>Docord ID:</b> {{ $compra->id }}<br>
					  <b>Doc. fecha:</b> {{ $compra->fecha }} <br>
					  <b>Status:</b> {{ $compra->status }} 
					</div>
					<!-- /.col -->
				  </div>
				  <!-- /.row -->

				  <!-- Table row -->
				  <div class="row">
					<div class="col-12 table-responsive">
					  <table class="table table-striped">
						<thead>
						<tr>
						  <th>Cant.</th>
						  <th>Codigo</th>
						  <th>Descripcion Producto</th>
						  <th>Stock</th>
						  <th>P.Compra</th>
						  <th>Importe</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($docdetas as $docdeta)
						<tr>
						  <td>{{ $docdeta->doccant }}</td>
						  <td>{{ $docdeta->codbarras }}</td>						  
						  <td>{{ $docdeta->artdesc }}</td>
						  <td>{{ $docdeta->stock }}</td>
						  <td>{{ number_format($docdeta->artprcosto, 2,) }}</td>
						  <td>{{ number_format($docdeta->docimporte, 2,) }}</td>
						</tr>
						@endforeach
						</tbody>
					  </table>
					</div>
					<!-- /.col -->
				  </div>
				  <!-- /.row -->

				  <div class="row">
					<!-- accepted payments column -->
					<div class="col-6">
					
		

					  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
						&nbsp; 
					  </p>
					</div>
					<!-- /.col -->
					<div class="col-6">
					  <p class="lead">Totales </p>

					  <div class="table-responsive">
						<table class="table">
						  <tr>
							<th style="width:50%">Subtotal: </th>
							<td>$ {{ number_format($compra->total, 2) }} </td>
						  </tr>
						  <tr>
							<th>IVA (0%)</th>
							<td>$ </td>
						  </tr>
						  <tr>
							<th>Descto.:</th>
							<td>$ </td>
						  </tr>
						  <tr>
							<th>Total:</th>
							<td>$ {{ number_format($compra->total, 2) }} </td>
						  </tr>
						</table>
					  </div>
					</div>
					<!-- /.col -->
				  </div>
				  <!-- /.row -->

				  <!-- this row will not appear when printing -->

				</div>
				<!-- /.invoice -->
						

		  </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
		  
</div>
<!-- ./wrapper -->

</body>
</html>			  