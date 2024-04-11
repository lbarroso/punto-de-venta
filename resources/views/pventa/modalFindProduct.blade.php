
      <div class="modal" id="modal-findproduct">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Buscar producto</h4>
              <button type="button" class="close" data-dismiss="modal" onclick=" return document.getElementById('codigo').focus();" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			
            <div class="modal-body">
			
				<div class="card">
				  <div class="card-header">
					<!-- Campo cadena -->
					<form id="formfindproduct">					
						<div class="input-group input-group-lg">
							<input type="text" name="texto" id="textoId" class="form-control" onKeyPress="return findProduct(event,0)">
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat"> <i class="fa fa-search"></i> </button>
							</span>
						</div>												
					</form>				  
				  </div>
				  <div class="card-body">
				  
					<div id="table-output">					
						
					</div>
					
				  </div>
				  
				  <div class="card-footer">Footer</div>
				</div>
					
            </div>
			
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" onclick=" return document.getElementById('codigo').focus();" data-dismiss="modal">Cerrar</button>
              <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
			
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
