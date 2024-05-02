<div class="modal" id="modal-product" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">
		<div class="modal-content">
		
			<form id="formProduct">
				<div class="modal-header">
					<h4 class="modal-title"> <span id="Purchasesartdesc"> </span> </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!--id-->
					<input type="hidden" name="id" id="Purchasesid">
					
                    <div class="form-group">
						<label for="artprcosto">Descto.%</label>
						<input type="text" name="artdescto" id="Purchasesartdescto" onfocus="this.select()" class="form-control" onKeyPress="return handleEnter(this, event)">
					</div>					

                    <div class="form-group">
						<label for="artprcosto">Cantidad</label>
						<input type="text" name="doccant" id="Purchasesdoccant"  onfocus="this.select()" class="form-control" onKeyPress="return handleEnter(this, event)">
					</div>

                    <div class="form-group">
						<label for="artprcosto">P.Compra $</label>
						<input type="text" name="artprcosto" id="Purchasesartprcosto" onfocus="this.select()" class="form-control" onKeyPress="return handleEnter(this, event)">
					</div>
					


				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-primary"  id="formProductBtn">Guardar</button>
					<button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
					
				</div>
			</form>
		
		</div>
	</div>
</div>

