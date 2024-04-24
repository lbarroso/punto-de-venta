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
						<input type="date" id="fecha" class="form-control mb-2 mr-sm-2" name="fecha" required>
					</div>		

                    <div class="form-group">
						<label for="prvcve" class="mb-2 mr-sm-2">Proveedor:</label>
						<select class="form-control mb-2 mr-sm-2" name="prvcve" id="prvcve" required>
							
						</select>
					</div>
					
                    <div class="form-group">
						<label for="factura" class="mb-2 mr-sm-2">No. Factura (referencia):</label>
						<input type="text" id="factura" class="form-control mb-2 mr-sm-2" name="factura">
					</div>	

                    <div class="form-group">
						<label for="factura" class="mb-2 mr-sm-2">Comentarios:</label>
						<textarea  rows="2" id="comentarios" class="form-control mb-2 mr-sm-2" name="comentarios"></textarea>
					</div>						

				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" onKeyPress="return handleEnter(this, event)" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar compra</button>
				</div>
			</form>
		
		</div>
	</div>
</div>

