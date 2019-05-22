<?php
	/*-------------------------
	Autor:rjose
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: index.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Clientes | Sistema de Pautas";
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
	
    <div class="container col-xl-9">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">

				<a href="../../view/GestaoFormando.php" type='button' target="frm_content" class="btn btn-info">
                    <span class="glyphicon glyphicon-plus"  ></span>  Adiccionar</a>
			</div>

			<h4><i class='glyphicon glyphicon-search'></i> Gestão de Alunos</h4>
		</div>
		<div class="panel-body">

			<?php
				include("modal/form_clientes.php");
				include("modal/form_encarregado.php");
                 include("modal/list_encarregado.php");

			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Numero Mecanografico:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nome do Estudante" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/clientes.js"></script>

  </body>
</html>
