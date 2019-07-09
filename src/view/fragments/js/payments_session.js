		$(document).ready(function(){
			load(1);
		});

		function load(page){

			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'buscar_spayments.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="../fragments/img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{

			var q= $("#q").val();
		if (confirm("Realmente deseja eliminar este curso")){
		$.ajax({
        type: "GET",
        url: "buscar_curso.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensagem: Carregando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}


		
		
		

