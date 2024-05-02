<html>

	<head> 
		<title> ticket </title>
		<style>
		body {
			text-transform: uppercase; /* Convertir todas las letras a mayúsculas */
			font-family: Arial, sans-serif; /* Usar la fuente Arial */
			font-size: 8pt; /* Tamaño de fuente de 11 puntos */
		}
        .precio {
            /* Estilo predeterminado para el precio */
            color: black;
        }		
        .precio.descuento {
            /* Estilo para el precio con descuento */
            color: red;
			font-size: 7pt;
            text-decoration: line-through; /* Subrayado para indicar descuento */
        }		
		</style>
	</head>
	<!-- window.self.close();-->
	<body onLoad=" window.print(); window.self.close(); " style=" font-size:10pt; font-family:arial; ">
	
		<center>
			<p><img src="{{ asset('admin/dist/img/pvticket.jpg') }}" alt="ticket" width='210' height='135' border='0'></p>
		
			<table style=" font-size:7pt; font-family:arial; ">
				<tr> <td align='center'> {{ $empresa->regnom }}</td> </tr>
				<tr> <td align='center'> {{ $empresa->regmun }}</td> </tr>
				<tr> <td align='center'> {{ $empresa->regtel }}</td> </tr>
				<tr> <td align='center'> &nbsp; </td> </tr>
			</table>
		</center>
		
		<table border="0" width="100%" style=" font-size:9pt; font-family:arial; ">

			<thead>
				<tr> <th>Cant.</th> <th>Producto</th> <th align='right'>Importe</th> </tr>
			</thead>
			
			<tbody>
				@foreach ($docdetas as $row)
					@php
						$descripcion = substr($row->artdesc, 0, 35)."...";
					@endphp				
					<tr>
						<td> {{ $row->doccant }} </td>
						<td colspan="2"> {{ $descripcion }} </td>
						
					</tr>
					<tr>
						<td colspan="2" align='right'>
							@if($row->artdescto > 0)
								<span class="precio descuento"> $ {{ number_format( $row->artprventa, 2,'.','') }}  </span>							
								@php
									$descuento = $row->artprventa * ($row->artdescto / 100);
									$subtotal = $row->artprventa- $descuento;
								@endphp
								
								$ {{ number_format( $subtotal, 2,'.','') }}
							@else
								$ {{ number_format( $row->artprventa, 2,'.','') }}
							@endif							
						</td>
						<td align='right' width="20%"> {{ number_format( $row->docimporte, 2,'.','') }} </td>
					</tr>
				@endforeach
			</tbody>
			
		</table>	
		
        <center>
			<table style=" font-size:8pt; font-family:arial; ">
	
				<tr>
					<td></td>
					<td align="right"> Total </td>
					<td align="right"> <strong> {{ number_format( $total, 2,'.',',') }} </strong></td>
				</tr>
				
			</table>            
        </center>

		<center >
			<table style=" font-size:8pt; font-family:arial; ">
				<tr> <td align='center'>Articulos: {{ $articulos }}</td> </tr>
				<tr> <td align='center'>Fecha salida: {{ $salida->fecha->format('d/m/y') }} </td> </tr>
				<tr> <td align='center'>Folio salida: {{ $salida->id }}</td> </tr>
				<tr> <td align='center'>Elaboro: {{ $salida->user_name }}</td> </tr>
				<tr> <td align='center'> {{ $salida->comentarios }}</td> </tr>
				
				
			</table>
		</center>
		
	
	</body>
	
</html>

 


