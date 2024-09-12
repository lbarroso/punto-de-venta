<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Factura Electrónica</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
	
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Generar Factura Electrónica {{ config('app.name', 'Laravel') }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-center text-muted">Por favor, completa los siguientes campos para generar tu factura.</p>

                        <!-- Información de Ticket -->
                        <div class="mb-4 text-center">
                            <h6><strong>Número de Ticket:</strong> {{ $id }}</h6>
                            <h6><strong>Total del Ticket:</strong> ${{ number_format($total, 2, '.', ',') }}</h6>
                        </div>

                        <!-- Mostrar mensajes de error si existen -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('invoices.store') }}" method="POST" id="form-cfdi">
                            @csrf

                            <!-- Campo RFC -->
                            <div class="form-group mb-3">
                                <label for="rfc">RFC</label>
                                <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ old('rfc') }}" placeholder="Ingrese su RFC" required>
                                @error('rfc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo Nombre -->
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese su nombre completo" required>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo Código Postal -->
                            <div class="form-group mb-3">
                                <label for="DomicilioFiscalReceptor">Código Postal</label>
                                <input type="number" class="form-control @error('DomicilioFiscalReceptor') is-invalid @enderror" id="DomicilioFiscalReceptor" name="DomicilioFiscalReceptor" value="{{ old('DomicilioFiscalReceptor') }}" placeholder="Ingrese su código postal" maxlength="5" required>
                                @error('DomicilioFiscalReceptor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo Uso CFDI -->
                            <div class="form-group mb-3">
                                <label for="UsoCFDI">Uso de CFDI</label>
                                <select class="form-control @error('UsoCFDI') is-invalid @enderror" name="UsoCFDI" id="UsoCFDI" required>
                                    <option value="">Seleccionar una opción</option>
                                    <option value="CP01" {{ old('UsoCFDI') == 'CP01' ? 'selected' : '' }}>CP01 - Pagos</option>
                                    <option value="G01" {{ old('UsoCFDI') == 'G01' ? 'selected' : '' }}>G01 - Adquisición de mercancías</option>
                                    <option value="G02" {{ old('UsoCFDI') == 'G02' ? 'selected' : '' }}>G02 - Devoluciones, descuentos o bonificaciones</option>
                                    <option value="G03" {{ old('UsoCFDI') == 'G03' ? 'selected' : '' }}>G03 - Gastos en general</option>
                                    <option value="I01" {{ old('UsoCFDI') == 'I01' ? 'selected' : '' }}>I01 - Construcciones</option>
                                    <option value="I02" {{ old('UsoCFDI') == 'I02' ? 'selected' : '' }}>I02 - Mobiliario y equipo de oficina por inversiones</option>
                                    <option value="I03" {{ old('UsoCFDI') == 'I03' ? 'selected' : '' }}>I03 - Equipo de transporte</option>
                                    <option value="I04" {{ old('UsoCFDI') == 'I04' ? 'selected' : '' }}>I04 - Equipo de cómputo y accesorios</option>
                                    <option value="I05" {{ old('UsoCFDI') == 'I05' ? 'selected' : '' }}>I05 - Dados, troqueles, moldes, matrices y herramental</option>
                                    <option value="I06" {{ old('UsoCFDI') == 'I06' ? 'selected' : '' }}>I06 - Comunicaciones telefónicas</option>
                                    <option value="I07" {{ old('UsoCFDI') == 'I07' ? 'selected' : '' }}>I07 - Comunicaciones satelitales</option>
                                    <option value="I08" {{ old('UsoCFDI') == 'I08' ? 'selected' : '' }}>I08 - Otra maquinaria y equipo</option>
                                    <option value="D01" {{ old('UsoCFDI') == 'D01' ? 'selected' : '' }}>D01 - Honorarios médicos, dental y gastos hospitalarios</option>
                                    <option value="D02" {{ old('UsoCFDI') == 'D02' ? 'selected' : '' }}>D02 - Gastos médicos por incapacidad o discapacidad</option>
                                    <option value="D03" {{ old('UsoCFDI') == 'D03' ? 'selected' : '' }}>D03 - Gastos funerales</option>
                                    <option value="D04" {{ old('UsoCFDI') == 'D04' ? 'selected' : '' }}>D04 - Donativos</option>
                                    <option value="D05" {{ old('UsoCFDI') == 'D05' ? 'selected' : '' }}>D05 - Intereses por créditos hipotecarios</option>
                                    <option value="D06" {{ old('UsoCFDI') == 'D06' ? 'selected' : '' }}>D06 - Aportaciones voluntarias al SAR</option>
                                    <option value="D07" {{ old('UsoCFDI') == 'D07' ? 'selected' : '' }}>D07 - Primas por seguros de gastos médicos</option>
                                    <option value="D08" {{ old('UsoCFDI') == 'D08' ? 'selected' : '' }}>D08 - Gastos de transportación escolar obligatoria</option>
                                    <option value="D09" {{ old('UsoCFDI') == 'D09' ? 'selected' : '' }}>D09 - Depósitos en cuentas para el ahorro, primas con base</option>
                                    <option value="D10" {{ old('UsoCFDI') == 'D10' ? 'selected' : '' }}>D10 - Pagos por servicios educativos (colegiaturas)</option>
                                    <option value="P01" {{ old('UsoCFDI') == 'P01' ? 'selected' : '' }}>P01 - Por definir</option>
                                </select>
                                @error('UsoCFDI')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo Régimen Fiscal Receptor -->
                            <div class="form-group mb-3">
                                <label for="RegimenFiscalReceptor">Régimen Fiscal</label>
                                <select class="form-control @error('RegimenFiscalReceptor') is-invalid @enderror" id="RegimenFiscalReceptor" name="RegimenFiscalReceptor" required>
                                    <option value="">Seleccionar una opción</option>
                                    <option value="601" {{ old('RegimenFiscalReceptor') == '601' ? 'selected' : '' }}>601 - General de Ley Personas Morales</option>
                                    <option value="603" {{ old('RegimenFiscalReceptor') == '603' ? 'selected' : '' }}>603 - Personas Morales con Fines no Lucrativos</option>
                                    <option value="605" {{ old('RegimenFiscalReceptor') == '605' ? 'selected' : '' }}>605 - Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                                    <option value="606" {{ old('RegimenFiscalReceptor') == '606' ? 'selected' : '' }}>606 - Arrendamiento</option>
                                    <option value="607" {{ old('RegimenFiscalReceptor') == '607' ? 'selected' : '' }}>607 - Régimen de Enajenación o Adquisición de Bienes</option>
                                    <option value="608" {{ old('RegimenFiscalReceptor') == '608' ? 'selected' : '' }}>608 - Demás ingresos</option>
                                    <option value="610" {{ old('RegimenFiscalReceptor') == '610' ? 'selected' : '' }}>610 - Residentes en el Extranjero sin Establecimiento Permanente en México</option>
                                    <option value="611" {{ old('RegimenFiscalReceptor') == '611' ? 'selected' : '' }}>611 - Ingresos por Dividendos (socios y accionistas)</option>
                                    <option value="612" {{ old('RegimenFiscalReceptor') == '612' ? 'selected' : '' }}>612 - Personas Físicas con Actividades Empresariales y Profesionales</option>
                                    <option value="614" {{ old('RegimenFiscalReceptor') == '614' ? 'selected' : '' }}>614 - Ingresos por intereses</option>
                                    <option value="615" {{ old('RegimenFiscalReceptor') == '615' ? 'selected' : '' }}>615 - Régimen de los ingresos por obtención de premios</option>
                                    <option value="616" {{ old('RegimenFiscalReceptor') == '616' ? 'selected' : '' }}>616 - Sin obligaciones fiscales</option>
                                    <option value="620" {{ old('RegimenFiscalReceptor') == '620' ? 'selected' : '' }}>620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
                                    <option value="621" {{ old('RegimenFiscalReceptor') == '621' ? 'selected' : '' }}>621 - Incorporación Fiscal</option>
                                    <option value="622" {{ old('RegimenFiscalReceptor') == '622' ? 'selected' : '' }}>622 - Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
                                    <option value="623" {{ old('RegimenFiscalReceptor') == '623' ? 'selected' : '' }}>623 - Opcional para Grupos de Sociedades</option>
                                    <option value="624" {{ old('RegimenFiscalReceptor') == '624' ? 'selected' : '' }}>624 - Coordinados</option>
                                    <option value="625" {{ old('RegimenFiscalReceptor') == '625' ? 'selected' : '' }}>625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
                                    <option value="626" {{ old('RegimenFiscalReceptor') == '626' ? 'selected' : '' }}>626 - Régimen Simplificado de Confianza</option>
                                </select>
                                @error('RegimenFiscalReceptor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo Email -->
                            <div class="form-group mb-4">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo electrónico" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							
							<!-- Botón Generar Factura -->
                            <div class="form-group mb-4">
								<button type="button" id="submit-cfdi" class="btn btn-primary">
									<i id="fa-file-text-o" class="fa fa-file-text-o"> </i> Generar factura 
								</button> 
                            </div>
							
							<!-- Error al timbrar -->
							<div class="col-sm-12 p-2">
								<div id="errorcfdi"></div>
							</div>
							
                            <!-- Campos ocultos -->
                            <input type="hidden" name="base" id="base" value="{{ number_format($total, 2, '.', '') }}">
                            <input type="hidden" name="numberid" id="numberid" value="{{ $id }}">
							<input type="hidden" name="store" id="store" value="{{ $store }}">
                            <input type="hidden" name="FormaPago" id="FormaPago" value="{{ $FormaPago }}">
							<input type="hidden" name="uuid" id="uuid" value="">
							
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->


    <!--AJAX-->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
            }
        }); 
            
    	var btn = document.querySelector("#submit-cfdi"); // btn
    	var form = document.querySelector("#form-cfdi"); // form
    	
    	// onclick evento
    	btn.addEventListener("click",formSubmit);
    
    	// enviar formulario
    	function formSubmit(e)
    	{
    		e.preventDefault();		
    		// limpiar errores
    		$('#errorcfdi').html(""); 
    		
    		// AJAX 
    		$.ajax({
    		
    			url: "{{ route('invoices.ticket.timbrar') }}",
    			type: 'post',
                data: $("#form-cfdi").serialize(),
    			beforeSend: function(){
    				// iniciar loader
    				$('#fa-file-text-o').removeClass('fa fa-file-text-o').html('<img src="{{ asset("ajax-loader.gif") }}">');
    			},
    			
    			success: function(response){
    				// detener loader
    				$('#fa-file-text-o').html("").addClass('fa fa-file-text-o');

                    // Comprobar el contenido del response
                    if(response.trim() === "success"){
                        // Si la respuesta es "success", enviar el formulario
                        // $("#form-cfdi").unbind('submit').submit();
                        $('#errorcfdi').html('<div class="alert alert-success">' + response + '</div>');
                    } else {
                        // Mostrar el error en el div con id="errorcfdi"
                        $('#errorcfdi').html('<div class="alert alert-danger">' + response + '</div>');
                    }    			
    			},
    			
    			error : function(){
					// Mostrar el error en el div con id="errorcfdi"
					$('#errorcfdi').html('<div class="alert alert-danger">' + response + '</div>');					
    				console.log('We could not find that page');
    			}
    			
    		}); // EndAjax
    		
    	}// endFunction
    </script>

</body>
</html>

