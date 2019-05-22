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
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$active_usuarios="active";	
	$title="Software| Pautas";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("head.php");?>
  </head>
  <body>

    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
			<h4><span class="glyphicon glyphicon-bookmark"></span>Gestao de Disciplina</h4>
		</div>			
			<div class="panel-body">

			<?php
			include("../../view/Disciplina.php");
			?>

			<form class="form-horizontal" role="form" id="datos_cotizacion">

                <div class="form-group row">
                    <label for="q" class="col-md-2 control-label">Nome:</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="q" placeholder="Nome" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/disciplina.js"></script>


  </body>
</html>
<script>

$( "#guardar_disciplina" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nova_disciplina.php",
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
});

$( "#editar_usuario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_professor.php",
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
</script>