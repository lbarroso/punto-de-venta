$(document).ready(function(){	

	var link = document.querySelector("#categorylink"); // boton
	
	var btn = document.querySelector("#categorybtn"); // boton
	
	link.addEventListener("click",modalCategory);


	function modalCategory(e){

		$('#modal-category-create').modal("hide"); // oculta la ventana
		$('.modal-body').html(''); // 
		
		$('#modal-category-create').modal(); // muestra la ventana	
		document.getElementById("name").focus();
	}	
	
	// nueva categoria
	btn.addEventListener("click",categoryStore);

	function categoryStore(){		
			var category = document.getElementById("name").value;
			var selectElement = document.getElementById('category_id');
			$("#formCategoryCreate")[0].reset();
			
            $.ajax({
                method: 'post',
                url : urlCategoryStore,
				data: { "name": category, "agregado_rapido": "si" },
                success: function(res){
                    					
					categories = "<option value = '"+ res +"' selected='selected'> " + category + "</option>";
					
					$('#category_id').prepend(categories);
					
					$('#modal-category-create').modal('hide');
					
                    $.notify("Se guardo correctamente", "success");
					
                },
                error:function(res){
                    console.log(res);
                }
            })				
	}		

})

