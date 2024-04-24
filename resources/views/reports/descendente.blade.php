@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Reportes </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Reportes</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row">

  <div class="col-12">
  
      <div class="card card-default">
          <div class="card-header">
              <h3 class="card-title">Descendente </h3>
          </div>

          <div class="card-body">

              <div class="row">
                
					<div class="col-md-12">
						
						<div class="card card-primary card-outline">
						
							<div class="card-header">
							  <h5 class="card-title m-0">Descende de ventas acumulado</h5>
							</div>
							
							<div class="card-body">
								
								<form id="reportForm" action="{{ route('descendente.export') }}" method="GET">
								
									<label for="fecha_inicio" class="mb-2 mr-sm-2">Fecha Inicio:</label>
									<input type="date" id="fecha_inicio" class="form-control mb-2 mr-sm-2" name="fecha_inicio" required>
									
									<label for="fecha_fin" class="mb-2 mr-sm-2">Fecha Final:</label>
									<input type="date" id="fecha_fin" class="form-control mb-2 mr-sm-2" name="fecha_fin" required>
									
									<label for="cvemov" class="mb-2 mr-sm-2">Movimiento:</label>
									<select id="cvemov" class="form-control mb-2 mr-sm-2" name="movcve" required>
										<option value="51">VENTAS MOSTRADOR</option>
										<option value="52">ENTRADAS DE PROVEEDORES</option>                                
									</select>
									
									<label for="formato_salida" class="mb-2 mr-sm-2">Salida:</label>
									<select id="formato_salida" class="form-control mb-2 mr-sm-2" name="formato_salida" required>
										<option value="1">FORMATO EXCEL</option>
										<option value="2">PANTALLA</option>                                
									</select>                                  
									
									<button type="submit" class="btn btn-primary mb-2">Generar Reporte</button>

								</form>				
						
							</div>
							
						</div>                        

					</div>
                    
              </div>

          </div>

      </div>

  </div>
  
</div>

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
    document.getElementById('fecha_inicio').value = today;
    document.getElementById('fecha_fin').value = today;
});

document.getElementById('reportForm').addEventListener('submit', function(event) {
    // Prevent the default form submission
    event.preventDefault();
    
    // Get the selected value from the formato_salida dropdown
    var salida = document.getElementById('formato_salida').value;
    
    // Update the form's action based on the selected value
    if (salida === '1') {
		this.target = '_self';
        this.action = '{{ route('descendente.export') }}';
    } else if (salida === '2') {
        this.target = '_blank';
		this.action = '{{ route('descendente.print') }}';
		
    }

    // Submit the form
    this.submit();
});
</script>
    
@endsection



