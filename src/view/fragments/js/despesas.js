		$(document).ready(function(){
			load(1);
		});

		function load(page){

			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_despesas.php?action=ajax&page='+page+'&q='+q,

				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Carregando...');
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
        url: "./ajax/buscar_curso.php",
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


		
		
		

