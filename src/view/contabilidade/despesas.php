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
		    <div class="btn-group pull-right">

				<a href="orcamento.php" type='button' class="btn btn-primary" target="frm_content" >
                    <span class="glyphicon glyphicon-plus" ></span> Novo Orçamento</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i>Despesas e Orçamento</h4>
		</div>

		<div class="panel-body">
			
			<?php
			include("modal/form_curso.php");
			?>
            <div class="container jumbotron col-lg-12">

                <form class="form-horizontal" id="guardar_despesa" name="guardar_despesa">
                    <div id="resultados_ajax_productos"></div><!-- Carga los datos ajax -->

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email"> Detalhes da Despesa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="detalhe" name="detalhe" placeholder="Enter details">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Orçamento Associado:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="orcamento" name="orcamento">
                                <?php

                                $result = mysqli_query($con, "select * from orcamento");
                                while ($row= mysqli_fetch_assoc($result)){ ?>
                                    <option value="<?php echo $row['idorcamneto']?>"><?php echo $row['details']?></option>

                                <?php }?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Valor:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="valor" id="valor" placeholder="Enter money">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 pull-right">
                            <button type="submit" id="guardar_datos" class="btn btn-primary">Guardar Dados</button>
                        </div>
                    </div>
                </form>
        </div>


			<form class="form-horizontal" role="form" id="datos_cotizacion">

						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Gestao de Despesas</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Código ou nome do Curso" onkeyup='load(1);'>
							</div>

							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>

			</form>
				<div id="resultados">
                </div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->

  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>

    <script type="text/javascript" src="../fragments/js/despesas.js"></script>
  </body>
</html>

<script>
$( "#guardar_despesa" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
    //alert(parametros)

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

    function listar_turmas(item){

}

function ctr_time(item){

    if(item == 5){
        $('.periodo_ctr').html("Inserir as Horas").show("slow").css({'color':'red'});
        $('#horas').focus();
    }
}

</script>