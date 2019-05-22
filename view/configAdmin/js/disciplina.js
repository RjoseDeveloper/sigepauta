		$(document).ready(function(){
			load(1);



        });



        function pesquisar(item, ctr){
            // var inp = $("#auto_aluno");

            $.ajax({

                url: '../../controller/FormandoCtr.php',
                data: {acao: 10, q:item, ctr:ctr},
                success: function (data) {

                    $('.list_view_encarregado').show();
                    $('.list_view_encarregado').html(data);
                }

            });

        }
		function load(page){

            var q= $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'./ajax/buscar_disciplina.php?action=ajax&page='+page+'&q='+q,
                beforeSend: function(objeto){
                    $('#loader').html('<img src="./img/ajax-loader.gif"> Carregando...');
                },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })
        }

		function eliminar (id) {
            var q= $("#q").val();

		if (confirm("Realmente desejas eliminar esta disciplina")){
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_disciplina.php",
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
		
		
		
		

