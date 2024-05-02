<table style="border:1px solid #cccccc;">

    <thead>
        <tr>
            <th><strong>ID</strong></th>
            <th><strong>CODIGO</strong></th>
            <th><strong>DESCRIPCION</strong></th>
			<th><strong>MARCA</strong></th>
			<th><strong>ARTDETA</strong></th>
            <th><strong>PRECIO COSTO</strong></th>
            <th><strong>PRECIO VENTA</strong></th>
            <th><strong>EXISTENCIA</strong></th>
            <th><strong>VALOR COSTO</strong></th>
            <th><strong>VALOR VENTA</strong></th>
			<th><strong>STATUS</strong></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($products as $item)
            <tr>
                <td style="border:1px solid #cccccc">{{ $item->id }}</td>
                <td width="16">{{ $item->codbarras  }}</td>
                <td width="80">{{ $item->artdesc }}</td>
				<td width="13">{{ $item->artmarca }}</td>
				<td width="13">{{ $item->artdetalle }}</td>
                <td width="13">{{ $item->artprcosto }}</td>
                <td width="13">{{ $item->artprventa }}</td>
                <td>{{ $item->stock }}</td>
                <td width="13">{{ $item->artprcosto * $item->stock }}</td>
                <td width="13">{{ $item->artprventa * $item->stock }}</td>   
				<td> {{ $item->artstatus }} </td>	
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
            <td></td>
            <td></td>
            <td>{{ $total_stock }}</td>
            <td>{{ $total_costo }}</td>
            <td>{{ $total_venta }}</td>
        </tr>
    </tfoot>
</table>