<div class="modal" id="modal-descto">

	<div class="modal-dialog">
	
		<div class="modal-content">
		
			<form id="formConfirm" action="{{ route('descto.venta') }}" method="post">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title" id="confirm-title"> Porcentaje de descuento </h4>
					<button type="button" class="close" data-dismiss="modal" onclick=" return document.getElementById('codigo').focus();" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
				
					<div class="row">
					
						<div class="col-6">

							<div class="form-group">
								<label for="porcentaje">Descto. %</label>
								<input type="number" value="0" min="0" step="1" max="15" onKeyPress="return handleEnter(this, event)" name="porcentaje" id="porcentaje" onFocus="this.select()" class="form-control">
							</div>	
						   
						</div>
						
						<div class="col-6">
							<div class="text-muted"> Todos los productos en la lista serán afectados</div>
						</div>
					  
					</div>											
                    
				</div>
				
				<div class="modal-footer justify-content-between">					
					<button type="submit" class="btn btn-primary">Aplicar</button>
					<button type="button" class="btn btn-default" onclick=" return document.getElementById('codigo').focus();" data-dismiss="modal">Cerrar</button>
				</div>
				
			</form>
			<!-- /.form -->
		
		</div>
		<!-- /.modal-content -->
		
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
