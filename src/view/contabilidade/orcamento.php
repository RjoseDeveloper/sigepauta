<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_facturas="";
	$active_productos="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="Cursos | Sistema de Pautas";
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("head.php");?>
  </head>

  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-info">

		<div class="panel-heading">
<!--		    <div class="btn-group pull-right">-->
<!--				<button type='button' class="btn btn-primary" data-toggle="modal" data-backdrop="false"-->
<!--                        data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Novo Curso</button>-->
<!--			</div>-->
			<h4><i class='glyphicon glyphicon-credit-card'></i>&nbsp;&nbsp;Gestão de Orçamentos</h4>
		</div>

		<div class="panel-body">
			<?php
			    include("modal/form_curso.php");
			?>
            <div class="container col-lg-12">

                <form class="form-horizontal" id="guardar_orcamento" name="guardar_orcamento">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="detalhe"> Detalhes do Orçamento:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="detalhe" id="detalhe" placeholder="Enter details">
                        </div>
                        <input type="hidden" value="orc" name="valor" id="valor">
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="orcamento">Valor Associado:</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="orcamento" id="orcamento" placeholder="Enter money">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Guardar Dados</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>

            <input type="hidden" class="form-control" id="q" placeholder="Código ou nome do Curso" onkeyup='load(1);'>

            <div id="resultados"></div><!-- Carga los datos ajax -->
            <div class='outer_div'></div><!-- Carga los datos ajax -->
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>

    <script type="text/javascript" src="../fragments/js/orcamento.js"></script>
  </body>
</html>

<script>
$( "#guardar_orcamento" ).submit(function( event ) {

    //$('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    alert(parametros);

	 $.ajax({
			type: "POST",
			url: "ajax/nova_despesa_orcamento.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_productos").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_curso.php",
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

	function obtener_datos(id){
			var codigo_producto = $("#codigo_producto"+id).val();
			var nombre_producto = $("#nombre_producto"+id).val();
			var estado = $("#estado"+id).val();
			var precio_producto = $("#precio_producto"+id).val();
			$("#mod_id").val(id);
			$("#mod_codigo").val(codigo_producto);
			$("#mod_nombre").val(nombre_producto);
			$("#mod_precio").val(precio_producto);
		}


</script>