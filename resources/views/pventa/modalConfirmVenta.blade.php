<div class="modal" id="modal-confirm" >
	<div class="modal-dialog ">
		<div class="modal-content bg-primary">
		
			<form id="formConfirm" action="{{ route('venta.store') }}" method="post" onKeyUp="highlight(event)" onClick="highlight(event)">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title" id="confirm-title">Confirmar venta</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
				
					<div class="row">
					  <div class="col-6">
						   <div class="form-group">
							  <label for="tipopago"> Metodo de pago  </label> 
								<div class="custom-control custom-checkbox">
								  <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox4" checked>
								  <label for="customCheckbox4" class="custom-control-label">Efectivo</label>									  
								</div>								
						   </div>
					  </div>
					  
					  <div class="col-6">
						<div class="form-group">
							<label for="cash"> Efectivo recibido </label> 
							<input type="text" onKeyPress="return enterCash(this, event);" onFocus="this.select();" name="cash" id="cash" class="form-control text-center" value="0" style=" color:#111723; font-family:Arial; font-weight:bold; font-size:30pt; text-align:center; vertical-align:middle; ">
						</div>							
					  </div>

					</div>											
                    
                    <div class="info-box bg-gradient-warning">
                        <span class="info-box-icon bg-info" id="venta-cash" style="font-size: 14pt;"> </span>
                        <div class="info-box-content text-center">
                          <span class="info-box-text"> <h3> Total </h3> </span>
                          <h1><span class="info-box-number" id="venta-total"> 0,00 </span></h1>
                        </div>
                    </div>
					
				</div>
				
				<div class="modal-footer justify-content-between">
					<button type="submit" class="btn btn-default" id="venta-confirm"  style="font-size:14px; color:#000000; font-weight:bold; "> Confirmar venta </button>
					<button type="button" class="btn btn-default">Aceptar sin imprimir</button>
					<button type="button" onclick=" return $('#codigo').focus();  " class="btn btn-danger" data-dismiss="modal">Cerrar</button>					
				</div>
			</form>
		
		</div>
	</div>
</div>
