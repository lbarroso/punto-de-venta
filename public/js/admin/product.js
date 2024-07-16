var datatable;

$(document).ready(function(){	

    datatable = $('#table').DataTable({
		
		order: [[0, 'desc']], 
        ajax: indexUrl,
		
        columns: [
            { data:'id' },            
            { data:'artdesc' },
			{ data:'artmarca' },

            { data:'codbarras' },
            { 
				data:'artprcosto',
				"render": function (data, type, row) {
					// Formatear el número con dos decimales
					return parseFloat(data).toFixed(2);
				}				
			},            
            { 
				data:'artprventa',
				"render": function (data, type, row) {
					// Formatear el número con dos decimales
					return parseFloat(data).toFixed(2);
				}				
			},
            { data:'stock' },            
            { 
                data:'id',
                render: function(data,type,row){
                    var edit = ''
                    var pDelete = ''
                    var pDiscount = ''
					var pProperty = ''					
                    var pImages = ''

                    edit = '<button title="editar" data-id="'+data+'" data-toggle="modal" data-target="#modal-product" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></button>';                    
                    pDiscount = '<button data-product_id="'+data+'" data-toggle="modal" data-target="#modal-discount" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-table"></i></button>';                    
                    pProperty = '<button data-name="'+row.artdesc+'" data-product_id="'+data+'" data-toggle="modal" data-target="#modal-property" class="btn btn-info btn-sm mr-1"><i class="fas fa-table"></i></button>';
					pImages = '<button title="imagen" data-name="'+row.artdesc+'" data-product_id="'+data+'" data-toggle="modal" data-target="#modal-images" class="btn btn-info btn-sm mr-1"><i class="fa fa-image"></i></button>';
					pCodes = '<button title="claves" onClick="codesModel('+data+')" data-product_id="'+data+'"  class="btn btn-secondary btn-sm mr-1"><i class="fas fa-barcode"></i></button>';
					pDelete = '<button title="eliminar" onclick="if(confirm(\'eliminar\')) deleteModel('+data+'); else return false;"  class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></button>';
				   return edit+pDelete+pProperty+pImages;
                }
            }
        ]
    });

    getCategories();
	getProveedores();

    $('#formProduct').validate({
        rules:{
            artdesc: {
                required:true,
                minlength: 3
            },
            category_id: {
                required:true,
                minlength: 1
            },               
            artprventa: {
                required:true,
                minlength: 1
            },            
        },
        errorClass:'text-danger',
        submitHandler:function(form){
            let id =  $('#id').val()
            let url = storeUrl;
            let method  = 'post';

            if(parseInt(id) !== 0){
                url = updateUrl.replace("/0","/"+id);
                method = 'PUT';
            }

            $.ajax({
                method: method,
                url : url,
                data:$(form).serialize(),
                success:function(){
                    $('#modal-product').modal('hide');
                    $.notify("Se guardo correctamente", "success");

                    datatable.ajax.reload();

                },
                error:function(res){
                    console.log(res);
                }
            })

        }


    });


    $('#modal-product').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
		
        if(parseInt(id) == 0){
            $("#formProduct")[0].reset();
            $('#id').val(0)
        }else{

            find(id);
        } 
      
    });
	
	// Asociar la función enviarDatos al botón sin recargar la página
	document.getElementById('formCodes').addEventListener('submit', function(event) {
		event.preventDefault();
		storeCodes();
		$("#formCodes")[0].reset();
	});	
	
}) // document.ready

function getCategories(){
    $.ajax({
        method: 'get',
        url: urlCategories,
        success:function(response){
            var categories = "";

            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                categories += "<option value = '"+ element['id'] +"' > " + element["name"] + "</option>";
            }

            $('#category_id').append(categories);
        }
    })
}

function getProveedores(){
    $.ajax({
        method: 'get',
        url: urlProveedores,
        success:function(response){
            var proveedores = "";

            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                proveedores += "<option value = '"+ element['id'] +"' > " + element["prvrazon"] + "</option>";
            }

            $('#proveedor_id').append(proveedores);
        }
    })
}

function find(id){
    let url = showUrl.replace("/0","/"+id);
    $.ajax({
        method:'get',
        url:url,
        success:function(response){            
			$('#artdesc').focus();	
			$('#artstatus').val(response.artstatus);
            $('#artdesc').val(response.artdesc);
			$('#artdetalle').val(response.artdetalle);          
            $('#artprcosto').val(parseFloat(response.artprcosto).toFixed(2));
			$('#artganancia').val(parseFloat(response.artganancia).toFixed(2));
			$('#artprventa').val(parseFloat(response.artprventa).toFixed(2));
            $('#stock').val(response.stock);
            $('#artmarca').val(response.artmarca);
            $('#category_id').val(response.category_id);
			$('#proveedor_id').val(response.proveedor_id);
            $('#id').val(response.id);
        }
    })

}

function deleteModel(id){
    let url = deleteUrl.replace("/0","/"+id);

    $.ajax({
        method:'DELETE',
        url:url,
        success:function(respo){
            $.notify("Se elimino correctamente", "success");

            datatable.ajax.reload();
        }
    });

}

function codesModel(id){

    $.ajax({
        url: urlProductCodes,	
        type: 'GET',			
        data: { 'id' : id },			
        success: function(response){
			$('#product_id').val(id);
			codesTable(response, id);            
        
        },
        error : function(){
            alert('We could not find that page');
        }
    });		

} // function

function codesTable(response, product_id){
	let i= 1;
	var codes = "";
	codes +="<table class='table'>";
	for (let index = 0; index < response.length; index++) {
		const element = response[index];
		codes += "<tr> <td>"+ i +"</td> <td>" + element["codigo"] +  "</td> <td> <a href'#' onclick='deleteCode("+element["id"]+", "+product_id+")' class='btn btn-danger btn-sm mr-1'> <i class='fas fa-trash'></i> </a> </td> </tr>";
		i++;
	}
	codes +="</table>";

	$('#modal-codes-title').html("Claves genericas producto: "+product_id);
	$('#modal-codes-body').html(codes); // coloca los datos
	$('#modal-codes').modal(); 
	$('#barcode').focus();	

} // function

function deleteCode(id, product_id){

    $.ajax({
        url: urlDeleteCodes,
		type:'GET',
		data: { 'id' : id, "product_id": product_id },
        success:function(response){
            
            codesTable(response, product_id); 
        }
    });

} // function

function storeCodes(){

	// Obtener el valor del campo "barcode"
	var product_id = document.getElementById('product_id').value;
	var barcode = document.getElementById('barcode').value;
	var tecla = event.keyCode;
	 
	if(tecla == 13)
	{
		
		if (!barcode) return;
		
		$.ajax({
			url: urlStoreCodes,
			type: 'post',		
			data: { "product_id": product_id, "codigo": barcode },
			success: function(response){

				codesTable(response, product_id);

			},
			error : function(response){
			   console.log(response);
			}
		});
		
	}
	
} // function

function handleEnter(field, event){	
    var tecla = event.keyCode;
    
    if(tecla == 13){
        event.preventDefault();
        for (i = 0; i < field.form.elements.length; i++) if (field == field.form.elements[i]) break;
        i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();		
        return false;				
    }else return true;
    
} 
