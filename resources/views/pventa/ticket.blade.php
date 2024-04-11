<html>

	<head> 
		<title> ticket </title>
		<style>
		body {
			text-transform: uppercase; /* Convertir todas las letras a mayúsculas */
			font-family: Arial, sans-serif; /* Usar la fuente Arial */
			font-size: 11px; /* Tamaño de fuente de 11 puntos */
		}		
		</style>
	</head>
	<!-- window.self.close();-->
	<body onLoad=" window.print(); ">
	
		<center>
			<p><img src="{{ asset('admin/dist/img/lapinata.jpg') }}" alt="ticket" width='210' height='135' border='0'></p>
		
			<table>
				<tr> <td align='center'> {{ $empresa->regnom }}</td> </tr>
				<tr> <td align='center'> {{ $empresa->regmun }}</td> </tr>
				<tr> <td align='center'> {{ $empresa->regtel }}</td> </tr>
				<tr> <td align='center'> &nbsp; </td> </tr>
			</table>
		</center>
		
		<table border="0" width="100%">

			<thead>
				<tr> <th>Cant.</th> <th>Producto</th> <th align='right'>Importe</th> </tr>
			</thead>
			
			<tbody>
				@foreach ($docdetas as $row)
					@php
						$descripcion = substr($row->artdesc, 0, 30)."...";
					@endphp				
					<tr>
						<td> {{ $row->doccant }} </td>
						<td colspan="2"> {{ $descripcion }} </td>
						
					</tr>
					<tr>
						<td colspan="2" align='right'> $ {{ number_format( $row->artprventa, 2,'.','') }} </td>
						<td align='right' width="20%"> {{ number_format( $row->docimporte, 2,'.','') }} </td>
					</tr>
				@endforeach
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="3"> &nbsp; </td>
				</tr>			
				<tr>
					<td></td>
					<td align="right"> Total </td>
					<td align="right"> <strong> {{ number_format( $total, 2,'.',',') }} </strong></td>
				</tr>
				<tr>
					<td></td>
					<td align="right"> Efectivo </td>
					<td align="right"> {{ number_format( $venta->pvcash , 2,'.',',') }} </td>
				</tr>				
				<tr>
					<td></td>
					<td align="right"> Cambio </td>
					<td align="right">  {{ number_format( $venta->pvcash - $venta->pvtotal, 2,'.','') }} </td>
				</tr>				
			</tfoot>
			
		</table>		
		<p><center>  &nbsp; </center></p>
		<center>
			<table>
				<tr> <td align='center'>Articulos: {{ $articulos }}</td> </tr>
				<tr> <td align='center'>Fecha venta: {{ date('d-m-Y', strtotime($venta->pvfecha)) }}</td> </tr>
				<tr> <td align='center'>Folio venta: {{ $id }}</td> </tr>
				<tr> <td align='center'> Le atendio: {{ $venta->user_name }}</td> </tr>
				<tr> <td align='center'> {{ $empresa->regleyenda }}</td> </tr>
				
			</table>
		</center>
		
	
	</body>
	
</html>

 


