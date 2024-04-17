var datatable;

// datatable
$(document).ready(function(){
		
    datatable = $('#entrada').DataTable({
		
		order: [[0, 'asc']], 
        ajax: indexTableUrl,
		
        columns: [
            // La primera columna ahora es un número consecutivo
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data:'artdesc' },			
            { data:'doccant' },
            {
				data:'artprventa',
				"render": function (data, type, row) {
					return parseFloat(data).toFixed(2);
				}
			},
			{ data:'artdescto' },
            {
				data:'docimporte',
				"render": function (data, type, row) {
					return parseFloat(data).toFixed(2);
				}
			},
			{ data:'stock' },
            {
                data:'id',
                render: function(data,type,row){
                    var edit = ''
                    var pDelete = ''
                    
                    edit = '<button data-id="'+data+'" data-toggle="modal" data-target="#modal-product" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                    pDelete = '<button onclick="deleteModel('+data+')"  class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></button>';

                    return edit + pDelete;
                }
            }
        ]
    }); // datatable
	

}) // document.ready


document.getElementById("codbarras").focus();

// buscar codbarras
function enterCodbarras(field, event){
	
	var tecla = event.keyCode;
	
	if(tecla == 13){

		event.preventDefault();
		
		var codbarras = document.getElementById("codbarras").value;
		
		if(codbarras.length <= 0 || codbarras == '') return false;
				
		$.ajax({
			url: findCodeUrl,
			type: 'get',
			data: { 'code' : codbarras },
			success:function(response){
				
				var product = response.data;
				
				$("#formCodBarras")[0].reset();
				$('#artdesc-output').html('CAPTURAR PRODUCTO');
				
				if(product == null) return console.log('abrir modal');
				
				$('#artdesc-output').html(product.artdesc);
				
				$('#doccant').val(1);
				$('#artprcosto').val(parseFloat(product.artprcosto).toFixed(2));
				$('#artganancia').val(product.artganancia);
				$('#artprventa').val(parseFloat(product.artprventa).toFixed(2));
				$('#artdescto').val(0);
				
				handleEnter(field, event);
								
			},
			error:function(res){
				console.log(res);
			}
		});
	}
	
} // function


// Manejar el evento keypress en formulario
function handleEnter(field, event)
{	
    var tecla = event.keyCode;
    
    if(tecla == 13){
        event.preventDefault();
        for (i = 0; i < field.form.elements.length; i++) if (field == field.form.elements[i]) break;
        i = (i + 1) % field.form.elements.length;
        field.form.elements[i].focus();
        
        return false;				
    }else return true;
    
}