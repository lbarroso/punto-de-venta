var datatable;

// datatable
$(document).ready(function(){
		
    datatable = $('#salidas-table').DataTable({
		
		order: [[0, 'asc']], 
        ajax: salidaIndexTableUrl,
		
        columns: [
            // La primera columna ahora es un número consecutivo
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data:'codbarras' },
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
	
	// mostrar modal
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
	
	// 	actualizar cantidad
	var btn = document.querySelector("#formProductBtn"); // boton
	btn.addEventListener("click",updatePvproduct);
	btn.addEventListener("keypress",updatePvproduct);
	
	function updatePvproduct(e){
		
		e.preventDefault;

		$.ajax({
			method:'GET',
			url: updateProductUrl,
			data: $('#formProduct').serialize(),
			success:function(respo){
				
				$('#modal-product').modal('hide');		        
				
				datatable.ajax.reload();
				
				$.notify("Producto actualizado correctamente", "success"); 
				
				document.getElementById("codbarras").focus();
				
				salidaTotal();
				
			}
		});

	}	
	
	salidaTotal();
	
	getClientes();
	
}) // document.ready

// open modal
function find(id){
    let url = showProductUrl.replace("/0","/"+id);
    $.ajax({
        method:'get',
        url:url,
        success:function(response){

			$('#Purchasesartdescto').focus();
			$('#Purchasesartdesc').html(response.artdesc);
            $('#Purchasesartdescto').val(parseFloat(response.artdescto).toFixed(2));
			$('#Purchasesdoccant').val(parseFloat(response.doccant).toFixed(2));
            $('#Purchasesartprventa').val(parseFloat(response.artprventa).toFixed(2));
            $('#Purchasesid').val(response.id);
			$('#Purchasesartdescto').select();
			salidaTotal();
		
        }
    })
}

// eliminar
function deleteModel(id){
    let url = deleteProductUrl.replace("/0","/"+id);

    $.ajax({
        method:'get',
        url:url,
        success:function(respo){

            datatable.ajax.reload();
			$('#codbarras').focus();
			salidaTotal();
        }
    });
}

document.getElementById("codbarras").focus();

// buscar codbarras
function enterCodbarras(field, event){
	
	var tecla = event.keyCode;
	
	if(tecla == 13){

		event.preventDefault();
		
		var codbarras = document.getElementById("codbarras").value;
		
		if(codbarras.length <= 0 || codbarras == ''){
			$('#modal-findproduct').modal();
			$('#textoId').focus();
			return false;
		}
				
		$.ajax({
			url: findCodeUrl,
			type: 'get',
			data: { 'code' : codbarras },
			success:function(response){
				
				var product = response.data;
				
				//$("#formAjaxProduct")[0].reset();
				$('#artdesc-output').html('CAPTURAR PRODUCTO');
				
				if(product == null){
					$('#modal-findproduct').modal(); // abrir modal
					return $('#textoId').focus();
				}
				
				$('#artdesc-output').html(product.artdesc);
				
				$('#id').val(product.id);
				$('#artdesc').val(product.artdesc);
				$('#artcve').val(product.artcve);
				$('#stock').val(product.stock);
				$('#artpesogrm').val(product.artpesogrm);
				$('#artpesoum').val(product.artpesoum);
				
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

// agregar registro a la tabla docdetas
function salidaAjaxProduct(event){
	
	var tecla = event.keyCode;
	
	if(tecla == 13){
	
		event.preventDefault();
		
		$.ajax({
			url: salidaAjaxProductUrl,
			type: 'post',
			data: $("#formAjaxProduct").serialize(),
			success:function(response){
				
				var product = response.data;
				const doccant = parseFloat(product.doccant);
				const stock = parseFloat(product.stock);
				// error
				if(doccant > stock) alert('La cantidad solicitada supera nuestro stock actual: Actualmente dispone ['+product.stock+'] unidades disponibles');
				
				$("#formAjaxProduct")[0].reset();
				
				datatable.ajax.reload();
				
				$('#artdesc-output').html('CAPTURAR PRODUCTO');
				
				$('#codbarras').focus();
									
				salidaTotal();
				
			},
			error:function(res){
				console.log(res);
			}
		});	
		
	}
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

// total entradas
function salidaTotal(){
	$.ajax({
		type: 'GET',
		data: { "docord" : 0 },
		url: salidaTotalUrl,
		success: function(response){				
			
			$('#total-entradas').html(formatCurrency(response.total));			
		}			
	});	
}

function formatCurrency(number) {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
}


// listado clientes
function getClientes(){
    $.ajax({
        method: 'get',
        url: urlClientes,
        success:function(response){
            var clientes = "";

            for (let index = 0; index < response.length; index++){
                const element = response[index];

				// categoria predeterminada
				if(element["ctenom"] == 'TODOS LOS CLIENTES'){
					clientes += "<option value = '"+ element['id'] +"' selected> " + element["ctenom"] + "</option>";
				}		
				else{
					clientes += "<option value = '"+ element['id'] +"' > " + element["ctenom"] + "</option>";
				}

            }

            $('#ctecve').append(clientes);
        }
    })
}

// buscar descripcion
function findProduct(event, flat){
		
	var tecla = event.keyCode;
	
	if(tecla == 13 || flat == 1)
	{
		
		event.preventDefault();
		
		var texto = document.getElementById("textoId").value;
		texto = texto.trim();
		
		if(texto.length <= 0 || texto == '') return false;

		$.ajax({
			url: findProductUrl,
			type: 'get',
			data: { 'texto' : texto },
			success:function(response){
				
				var tableBody ="";
				var products = response.data;				
				
				$("#formfindproduct")[0].reset();
				
				$('#textoId').focus();

				tableBody +='<div class="table-responsive">';
				tableBody +='<table class="table table-striped table-bordered table-hover" id="tableProducts">';
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
					tableBody +='<tr>';
					tableBody +='<td> <i class="fa fa-check-square"></i> </td>';
					tableBody +='<td>' + product.codbarras + '</td>';
					tableBody +='<td> <a onClick="entradaDocdetaStore(' + product.id + ')" href="#" title="insertar">'+product.artdesc+'</a> </td>';
					tableBody +='<td align="right">'+parseFloat(product.artprventa).toFixed(2)+'</td> <td align="right">'+product.stock+'</td>';
					tableBody +='</tr>';
				}
				
				tableBody +='</tbody>';
				tableBody +='</table>';
				tableBody +='</div>';
					
				$(function () {
					$('#tableProducts').DataTable();
				})
				
				$('#table-output').html(tableBody);
				
			},
			error:function(res){
				console.log(res);
			}
		});

	}	
} // function

// clic en la descripcion 
function entradaDocdetaStore(id){
	var id = parseInt(id);
	
	$.ajax({
		url: docdetaStoreUrl,
		type: 'get',
		data: { 'id' : id },			
		success:function(response){
			
			var product = response.data;
			console.log(product);
			// lo agregar para editarlo
			$('#artdesc-output').html(product.artdesc);
			$('#codbarras').val(product.codbarras);
			$('#id').val(product.id);
			$('#artdesc').val(product.artdesc);
			$('#artcve').val(product.artcve);
			$('#stock').val(product.stock);
			$('#artpesogrm').val(product.artpesogrm);
			$('#artpesoum').val(product.artpesoum);
			
			$('#doccant').val(1);
			$('#artprcosto').val(parseFloat(product.artprcosto).toFixed(2));
			$('#artganancia').val(product.artganancia);
			$('#artprventa').val(parseFloat(product.artprventa).toFixed(2));
			$('#artdescto').val(0);

			$('#doccant').focus();
									
			salidaTotal();
			
			$('#modal-findproduct').modal('hide');
		
		},
		error:function(res){
			console.log(res);
		}
	});
}
