var datatable;

// datatable
$(document).ready(function(){
		
    datatable = $('#table').DataTable({
		
		order: [[0, 'asc']], 
        ajax: indexUrl,
		
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
	    
// 	var form = document.querySelector("#formProduct"); // form	
	var btn = document.querySelector("#formProductBtn"); // boton
	btn.addEventListener("click",updatePvproduct);
	
	function updatePvproduct(e){
		
		e.preventDefault;
		
		let url = updateUrl;

		$.ajax({
			method:'PUT',
			url:url,
			data: $('#formProduct').serialize(),
			success:function(respo){
				$('#modal-product').modal('hide');		        
				
				datatable.ajax.reload();
				total();
				document.getElementById("codigo").focus();
			}
		});

	}
	
	total();
	
}) // document.ready

// modificar cantidad y artdescto
function find(id){
    let url = showUrl.replace("/0","/"+id);
	
    $.ajax({
        method:'get',
        url:url,
		data: { 'id' : id },
        success:function(response){	
			$('#product-title').html(response.artdesc);
			$('#artdescto').val(response.artdescto);
            $('#doccant').val(parseFloat(response.doccant).toFixed(2));
            $('#id').val(response.id);
			$('#doccant').focus();
			$('#doccant').select();		
			total();
        }
    })
}

// eliminar pvproducts
function deleteModel(id){
	
    let url = deleteUrl.replace("/0","/"+id);

    $.ajax({
        method:'DELETE',
        url:url,
		data: { 'id' : id },
        success:function(respo){

            datatable.ajax.reload();
			document.getElementById("codigo").focus();
			total();
        }
    });

}

// enter cantidad
function enterCantidad(field, event){
	var tecla = event.keyCode;
	
	if(tecla == 13){
		event.preventDefault;
	  
		let url = updateUrl;

		$.ajax({
			method:'PUT',
			url:url,
			data: $('#formProduct').serialize(),
			success:function(respo){
				$('#modal-product').modal('hide');		        
				// $.notify("Cantidad actualizada correctamente", "success");
				datatable.ajax.reload();
				document.getElementById("codigo").focus();
				total();
			}
		});	  
	}
}

// enter cash
function enterCash(field, event){
	var tecla = event.keyCode;
	
    if(tecla == 13){
        event.preventDefault();
		
		var cash = document.getElementById("cash").value;
		
		$.ajax({
			url: cashUrl,
			data: { 'cash' : cash },
			success:function(response){
				
				const cash = parseFloat(response.cash);
				
				if(!isNaN(cash) && cash >= 0){
					$('#venta-cash').html("cambio " + response.cash);

				}else{  alert(); return $('#cash').focus(); }
				
			}
		});
		
		for (i = 0; i < field.form.elements.length; i++) if (field == field.form.elements[i]) break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;		
		
    }else return true;
}

// venta confirm 
function ventaConfirm(field, event){
	var tecla = event.keyCode;	
	
	if(tecla == 13){
		
		event.preventDefault();
				
	}else return true;
}

// total de la venta
function total(){
	$.ajax({
		type: 'GET',
		data: { "id" : 0 },
		url: totalUrl,
		success: function(response){				
			
			$('#total').html("$" + response.total);
			totalProducts()			
		}			
	});	
}

// total productos
function totalProducts(){
	$.ajax({
		type: 'GET',
		data: { "id" : 0 },
		url: totalProductsUrl,
		success: function(response){				
			
			$('#total-products').html("Productos "+response.articulos);			
		}			
	});	
}

document.getElementById("codigo").focus();

// buscar codigo
function enterCodigo(event, flat){
	var tecla = event.keyCode;
	
	if(tecla == 13 || flat == 1)
	{

		event.preventDefault();
		var codigo = document.getElementById("codigo").value;
		if (codigo.trim() == 'BUSCAR' || codigo.trim() == 'buscar') $('#modal-findproduct').modal(); // abrir modal	
		if (codigo.trim() == 'VENDER' || codigo.trim() == 'vender') $('#modal-confirm').modal();
		
		if(codigo.length <= 0 || codigo == '') return false;
				
		$.ajax({
			url: storeUrl,
			type: 'post',
			data: { 'codigo' : codigo },
			success:function(){
				
				$("#formCodigo")[0].reset();
				
				datatable.ajax.reload();
				total();

			},
			error:function(res){
				console.log(res);
			}
		});
	}
	
} // function

// buscar articulo descripcion
function findProduct(event, flat){
		
	var tecla = event.keyCode;
	
	if(tecla == 13 || flat == 1)
	{
		
		event.preventDefault();
		
		var texto = document.getElementById("textoId").value;
		texto = texto.trim();
		
		if(texto.length <= 0 || texto == '') return false;

		$.ajax({
			url: findUrl,
			type: 'get',
			data: { 'texto' : texto },
			success:function(response){
				
				var tableBody ="";		
				var products = response.data;				
				
				$("#formfindproduct")[0].reset();
				
				$('#textoId').focus();

				tableBody +='<div class="table-responsive">';
				tableBody +='<table class="table table-striped table-bordered table-hover" id="tablaProducts">';
				tableBody +='<thead class="thead-dark">';
				tableBody +='<tr class="text-center">';
				tableBody +='<th> # </th>';
				tableBody +='<th> codbarras </th>';
				tableBody +='<th> Descripci&oacute;n </th>';
				tableBody +='<th> $ </th>';
				tableBody +='<th> Stock </th>';
				tableBody +='</tr>';
				tableBody +='</thead>';

				tableBody +='<tbody>';
						
				// Recorrer los productos y agregarlos a la tabla
				for (var i = 0; i < products.length; i++){
					var product = products[i];
					tableBody +='<tr> <td> <i class="fa fa-check-square"></i> </td> <td>'+product.codbarras+'</td> <td> <a onClick="docdetaStore('+product.id+')" href="#" title="insertar">'+product.artdesc+'</a></td> <td align="right">'+parseFloat(product.artprventa).toFixed(2)+'</td> <td align="right">'+product.stock+'</td> </tr>';
				}
				
				tableBody +='</tbody>';
				tableBody +='</table>';
				tableBody +='</div>';
					
				$(function () {
					$('#tablaProducts').DataTable();
				})					
				
				$('#table-output').html(tableBody);
				
			},
			error:function(res){
				console.log(res);
			}
		});

	}	
} // function

// clic en la descripcion del producto
function docdetaStore(id){
	var id = parseInt(id);
	
	$.ajax({
		url: docdetaStoreUrl,
		type: 'get',
		data: { 'id' : id },
		success:function(){
			
			datatable.ajax.reload();
			total();

			$('#codigo').focus();
			$('#modal-findproduct').modal("hide");
		
		},
		error:function(res){
			console.log(res);
		}
	});
}

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