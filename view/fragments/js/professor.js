		$(document).ready(function(){
			load(1);

            $('.list_view_encarregado').on('click','li', function(){
                $('#auto_encarregado').val($(this).text());
                $('.list_view_encarregado').hide();
            });

        });

        function listar_Disciplinas(id){
            $.ajax({
                url:"../../requestCtr/Processa_docente.php",
                type:'POST',
                data:{id:id, acao:10},
                success:function(data){
                    $('.list_disciplinas').html(data)
                }
            });
        }

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

        function obter_estudante_nota(item, ctr){

            $('#campo_utilizador').val(item);
            $('#user_id').val(item);
        }

		function load(page){

            var q= $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'buscar_professor.php?action=ajax&page='+page+'&q='+q,
                beforeSend: function(objeto){
                    $('#loader').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
                },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })
        }

		function eliminar (id) {
            var q= $("#q").val();

		if (confirm("Realmente desejas eliminar este professor")){
		$.ajax({
        type: "GET",
        url: "buscar_professor.php",
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
		
		
		
		

