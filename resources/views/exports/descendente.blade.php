
<table style="border:1px solid #cccccc;">

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
                <td width="16">{{ $item->codbarras  }}</td>
                <td width="80">{{ $item->artdesc }}</td>
                <td width="13">{{ $item->artprcosto }}</td>
                <td width="13">{{ $item->artprventa }}</td>
				<td width="13">{{ $item->artdescto }}</td>
				<td width="13">{{ $item->importe }}</td>          
                <td width="13">{{ $item->importe / $total * 100 }} </td>
                <td width="13">{{ $item->cant }}</td>
            </tr>
        @endforeach
        
    </tbody>
    <tfoot>
        <tr>

            <td colspan="2">
				<strong>DESCENDENTE {{ $titulo }} ACUMULADO DEL PERIODO: {{ $fechaInicio }}  AL {{ $fechaFin }}</strong>
			</td>
			<td> </td>
			<td> </td>
			<td> </td>
            <td> {{ $total }} </td>
            <td> </td>
			<td> </td>
			

        </tr>
    </tfoot>
</table>