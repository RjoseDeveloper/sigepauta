		$(document).ready(function(){
			load_2(1);
		});

        function load_2(page){
            var q= $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'buscar_clientes.php?action=ajax&page='+page+'&q='+q,
                beforeSend: function(objeto){
                    $('#loader').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
                },

                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })
        }

        function get_item_val(item){
            $('#campo_frm').val(item);
        }


        function listar_Encarregado(id){

            //alert(id)

            $(this).css('background','red');

            $.ajax({
                url:"../../controller/FormandoCtr.php",
                data:{id:id, acao:14},
                success:function(data){
                    $('.list_encarregado').html(data)
                }
            });

        }

        function obtener_datos(id){

            var nombre_cliente = $("#nombre_cliente"+id).val();
            var telefono_cliente = $("#telefono_cliente"+id).val();
            var email_cliente = $("#email_cliente"+id).val();
            var direccion_cliente = $("#direccion_cliente"+id).val();
            var status_cliente = $("#status_cliente"+id).val();

            $("#mod_nombre").val(nombre_cliente);
            $("#mod_telefono").val(telefono_cliente);
            $("#mod_email").val(email_cliente);
            $("#mod_direccion").val(direccion_cliente);
            $("#mod_estado").val(status_cliente);
            $("#mod_id").val(id);

        }

		function eliminar (id)
		{

			var q= $("#q").val();
		if (confirm("Realmente desejas eliminar este aluno")){
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_clientes.php",
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

        var parametros = "";

        $("#registar_encarregado").submit(function( event ) {

            $('#btn_save_encarregado').attr("disabled", true);

            //var parametros = $(this).serialize();

            var nc = $("#fullname").val();
            var cel = $('#celular').val();
            var gr = $('#parentesco').val();
            var ne = $('select#nivel_ac').val();
            var age = $('#idade').val();
            var work = $('#local_work').val();
            var al = $("#campo_frm").val();
            var doc = $('#doc').val();
            $.ajax({

                type: "POST",
                url: "novo_encarregado.php",
                data: {fullname:nc,celular:cel,parentesco:gr,
                    nivel:ne, idade:age,work:work, idaluno:al,doc:doc},

                beforeSend: function(objeto){
                    $("#resultados_ajax_encarregado").html("Mensagem: Enviando...");
                },
                success: function(datos){

                    $("#resultados_ajax_encarregado").html(datos);
                    $('#btn_save_encarregado').attr("disabled", false);
                }
            });
            event.preventDefault();
        });
		
	
$( "#guardar_cliente" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_cliente.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_cliente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_cliente.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})




	
		
		

