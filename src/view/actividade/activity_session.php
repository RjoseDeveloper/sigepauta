<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: index.php");
		exit;
        }

	/* Connect To Database*/
	require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="active";	
	$title="Software| Pautas";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <?php include("../layouts/head.php");?>
  </head>
  <body>

    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">

				<button type='button' class="btn btn-default" data-toggle="modal" data-backdrop="false" data-target="#nova_sessao">
                    <span class="glyphicon glyphicon-plus" ></span> Adiccionar</button>
			</div>

			<h4><span class="glyphicon glyphicon-bookmark"></span>Sessão de Planificação</h4>
		</div>			
			<div class="panel-body">
			<?php
			include("form_activity.php");
			include("editar_activity.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nome:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nome" onkeyup='load(1);'>
							</div>

							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
						</div>
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
						
			</div>
		</div>


	</div>
	<hr>

	<script type="text/javascript" src="../fragments/js/payments_session.js"></script>

  </body>
</html>

<script>

$("#guardar_actividade" ).submit(function( event ) {


  $('#guardar_dados').attr("disabled", true);
  
 var parametros = $(this).serialize();

	 $.ajax({
			type: "POST",
			url: "actividade.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			$('#guardar_dados').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
});


$("#guardar_professor_disciplinas" ).submit(function( event ) {

    var valor = $('#user_id').val();
    //alert(valor);
    
    var parametros = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "../../requestCtr/Processa_gestao_pautas.php",
        data: parametros,
        beforeSend: function(objeto){
            $(".success_result").html("Mensagem: Carregando ...");
        },
        success: function(datos){
            $(".success_result").html(datos);

            load(1);
        }
    });
    event.preventDefault();
});

$('#disciplina').change(function(){
    $('#associar_disciplinas').attr("disabled", true);
})

$( "#editar_usuario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "editar_professor.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_password" ).submit(function( event ) {
  $('#actualizar_datos3').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_password.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax3").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax3").html(datos);
			$('#actualizar_datos3').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})
	function get_user_id(id){
		$("#user_id_mod").val(id);
	}

	function obtener_datos(id){
			var nombres = $("#nombres"+id).val();
			var apellidos = $("#apellidos"+id).val();
			var usuario = $("#usuario"+id).val();
			var email = $("#email"+id).val();
			
			$("#mod_id").val(id);
			$("#firstname2").val(nombres);
			$("#lastname2").val(apellidos);
			$("#user_name2").val(usuario);
			$("#user_email2").val(email);
		}

    function enable(){
        $('#associar_disciplinas').attr("disabled", false);
    }
</script>