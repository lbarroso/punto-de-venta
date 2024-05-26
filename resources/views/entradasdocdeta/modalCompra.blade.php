<div class="modal" id="modal-compra" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">
		<div class="modal-content">
		
			<form id="formCompra" action="{{ route('compras.store') }}" method="post">
			@csrf
			
				<div class="modal-header">
					<h4 class="modal-title"> Confirmar datos compra </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
                    <div class="form-group">
						<label for="fecha" class="mb-2 mr-sm-2">Fecha:</label>
						<input type="date" id="fecha" class="form-control mb-2 mr-sm-2" name="fecha" onKeyPress="return handleEnter(this, event)" required>
					</div>		

                    <div class="form-group">
						<label for="prvcve" class="mb-2 mr-sm-2">Proveedor:</label>
						<select class="form-control mb-2 mr-sm-2" name="prvcve" id="prvcve" onKeyPress="return handleEnter(this, event)" required>
							
						</select>
					</div>
					
                    <div class="form-group">
						<label for="factura" class="mb-2 mr-sm-2">No. Factura (referencia):</label>
						<input type="text" id="factura" class="form-control mb-2 mr-sm-2" name="factura" onKeyPress="return handleEnter(this, event)">
					</div>	

					<div class="form-group">
						<label for="fecha_entrada" class="mb-2 mr-sm-2">Fecha lote: control inventario primeras entradas p. salidas:</label>
						<input type="date" id="fecha_entrada" class="form-control mb-2 mr-sm-2" name="fecha_entrada" onKeyPress="return handleEnter(this, event)" required>
					</div>
					
                    <div class="form-group">
						<label for="comentarios" class="mb-2 mr-sm-2">Comentarios:</label>
						<textarea  rows="2" id="comentarios" class="form-control mb-2 mr-sm-2" name="comentarios"></textarea>
					</div>						

				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" onKeyPress="return handleEnter(this, event)" data-dismiss="modal">Cerrar</button>
					<button type="button" id="guardarCompraBtn" class="btn btn-primary">Guardar compra</button>
				</div>
			</form>
		
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var guardarBtn = document.getElementById('guardarCompraBtn');
    var form = document.getElementById('formCompra');

    guardarBtn.addEventListener('click', function(event) {
        event.preventDefault();
        form.submit();
    });
});
</script>

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
    document.getElementById('fecha').value = today;
	document.getElementById('fecha_entrada').value = today;
});
</script>

