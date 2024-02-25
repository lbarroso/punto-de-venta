$(document).ready(function(){
	
	//Initialize Select2 Elements
    $('.select2').select2()
	
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })		

	const primerInput = document.getElementById("codbarras");	
	
	if (primerInput) {                
		primerInput.focus();
		primerInput.select();
	}

    getCategories();
	
}) // document.ready

// listado categorias 
// pantalla nuevo producto
function getCategories(){
    $.ajax({
        method: 'get',
        url: urlCategories,
        success:function(response){
            var categories = "";

            for (let index = 0; index < response.length; index++) {
                const element = response[index];
				// categoria predeterminada
				if(element["name"] == 'DULCES Y CARAMELOS'){
					categories += "<option value = '"+ element['id'] +"' selected> " + element["name"] + "</option>";
				}		
				else{
					categories += "<option value = '"+ element['id'] +"' > " + element["name"] + "</option>";
				}
                
            }

            $('#category_id').append(categories);
        }
    })
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
        field.form.elements[i].select();
        return false;				
    }else return true;
    
} 
