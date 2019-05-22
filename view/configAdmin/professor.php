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
		    <div class="btn-group pull-right">

				<button type='button' class="btn btn-default" data-toggle="modal" data-backdrop="false" data-target="#myModal">
                    <span class="glyphicon glyphicon-plus" ></span> Adiccionar</button>
			</div>

			<h4><span class="glyphicon glyphicon-bookmark"></span>Professor</h4>
		</div>			
			<div class="panel-body">
			<?php
			include("modal/form_professor.php");
			include("modal/editar_professor.php");
			include("modal/docente_disciplina.php");
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
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/professor.js"></script>


  </body>
</html>
<script>

$("#guardar_professor" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();

	 $.ajax({
			type: "POST",
			url: "ajax/novo_professor.php",
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


$("#guardar_professor_disciplinas" ).submit(function( event ) {

    var valor = $('#user_id').val();
    //alert(valor);
    
    var parametros = $(this).serialize();

    //--alert(parametros);

    $.ajax({
        type: "POST",
        url: "ajax/associar_disciplina.php",
        data: parametros,
        beforeSend: function(objeto){
            $(".success_result").html("Mensagem: Carregando...");
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

function buscar_turma(item){

    $('.static_turma').html('');

    $.ajax({
        url:"../../requestCtr/Processa_docente.php",
        type:'POST',
        data:{curso:item, acao:12},
        success:function(data){
            $('.dinamic_turma').html(data)
        }
    });
}
</script>