<div class="modal fade" id="modal-category-create">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
	  <h4 class="modal-title">Agregar nueva categoria</h4>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body">
		&nbsp;
	</div>


		<form id="formCategoryCreate">
			<div class="col-12">
				<div class="form-group">
					<label for="name">Nombre:</label>
					<input type="text" onkeyup="this.value = this.value.toUpperCase();" name="name" id="name" class="form-control"  required>
				</div>
			</div>
		</form>	

		
	<div class="modal-footer justify-content-between">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  <button type="button" class="btn btn-primary" id="categorybtn">Agregar </button>
	</div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


