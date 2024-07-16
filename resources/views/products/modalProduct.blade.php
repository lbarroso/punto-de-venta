<div class="modal" id="modal-product" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		
			<form id="formProduct">
				<div class="modal-header">
					<h4 class="modal-title">Producto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!--id-->
					<input type="hidden" name="id" id="id">
				
					<div class="form-row">
						<div class="form-group col-md-12">
							<div class="form-group">
								<label for="artdesc">Descripci&oacute;n </label>
								<input type="text" name="artdesc" id="artdesc" class="form-control" onKeyPress="return handleEnter(this, event)">
							</div>							
						</div>					
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="artprcosto">Costo</label>
								<input type="number" name="artprcosto" id="artprcosto" onchange="artGanancia()" class="form-control" onKeyPress="return handleEnter(this, event)">
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="artganancia">Ganancia</label>
								<input type="number" name="artganancia" id="artganancia" onchange="artGanancia()" class="form-control" onKeyPress="return handleEnter(this, event)">
							</div>									
						</div>		
						<div class="form-group col-md-4">
							<div class="form-group">
								<label for="artprventa">Precio</label> 
								<input type="number" name="artprventa" id="artprventa" class="form-control" onKeyPress="return handleEnter(this, event)">
							</div>							
						</div>												
					</div>		
					
					<div class="form-row">
						<div class="form-group col-md-6">
							@if(Auth::user()->stock == 1)
							<div class="form-group">
								<label for="stock">Stock</label>
								<input type="number" name="stock" id="stock" class="form-control" onKeyPress="return handleEnter(this, event)">
							</div>
							@else
								<input type="hidden" name="stock" id="stock">
							@endif							
						</div>
						<div class="form-group col-md-6">
							<div class="form-group">
								<label for="artmarca">Marca </label>
								<input type="text" name="artmarca" id="artmarca" class="form-control" onKeyPress="return handleEnter(this, event)">
							</div>								
						</div>						
					</div>					


                    <div class="form-group">
						<label for="category_id">Categoria</label>
						<select name="category_id" id="category_id" class="form-control" style="width: 100%;" onKeyPress="return handleEnter(this, event)">
                            <option value="">Selecciona una opción</option>
                        </select>
					</div>			
					
                    <div class="form-group">
						<label for="proveedor_id">Proveedor</label>
						<select name="proveedor_id" id="proveedor_id" class="form-control" style="width: 100%;" onKeyPress="return handleEnter(this, event)">
                            <option value="">Selecciona una opción</option>
                        </select>
					</div>	

					<div class="form-row">
						<div class="form-group col-md-12">
							<div class="form-group">
								<label for="artmarca">Status: <span class="text-muted">C=CANCELADO, A=ACTIVO</span></label>						
								<input style="width:15%" type="text" name="artstatus" id="artstatus" pattern="^[AC]{1,2}$" class="form-control" onInput="this.value = this.value.toUpperCase().replace(/[^AC]/g, 'A');" maxlength="1" onKeyPress="return handleEnter(this, event)" required>
							</div>								
						</div>
					</div>

					
					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-danger" onKeyPress="return handleEnter(this, event)" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-success">Guardar</button>
				</div>
			</form>
		
		</div>
	</div>
</div>

