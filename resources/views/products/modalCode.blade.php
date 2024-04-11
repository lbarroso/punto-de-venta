<div class="modal" id="modal-codes" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">
		<div class="modal-content">
			<!--code.js-->
			<form id="formCodes">
				
				<div class="modal-header">
					<h4 class="modal-title" id="modal-codes-title"> Claves genericas </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<!--id-->
					<input type="hidden" name="product_id" id="product_id" value="0">

					<div class="form-group">
						<label for="barcode">Agregar nuevo código</label>
						<input onKeyPress="return storeCodes(event)" type="text" name="barcode" id="barcode" class="form-control" required>
					</div>

					<div id="modal-codes-body"> modal-codes-body </div>
				</div>
				
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					&nbsp;
				</div>
				
			</form>
		
		</div>
	</div>
</div>

