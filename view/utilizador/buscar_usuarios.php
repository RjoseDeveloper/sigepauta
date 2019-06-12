<?php

	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	/* Connect To Database*/
	require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
	include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
    require_once("../../Query/UtilizadorSQL.php");

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    $users = new UtilizadorSQL();

	if (isset($_GET['id'])){
		$user_id=intval($_GET['id']);

		$query=mysqli_query($con, "SELECT DISTINCT * FROM utilizador WHERE id='".$user_id."'");
		$rw_user=mysqli_fetch_array($query);

		$count=$rw_user['id'];
		if ($user_id!=1){
			if ($delete1=mysqli_query($con,"DELETE * FROM utilizador WHERE id='".$user_id."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Dados Removidos com sucesso.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Não é possivel eliminar os dados.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Não pode eliminar um administrador.
			</div>
			<?php
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nomeCompleto', 'username');//Columnas de busqueda
		 $sTable = "utilizador";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sWhere.=" order by id desc";
		include '../ajax/pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 8; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './usuarios.php';
		//main query to fetch the data

        $queries=$users->list_utilizador();

		$sql="SELECT ".$queries." $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);

		//loop through fetched data
		if ($numrows>0){?>

			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>ID</th>
					<th>Nome Completo</th>
					<th>Username</th>
					<th>Previlegio</th>
					<th>Data de Registo</th>
                    <th>Sexo</th>
					<th><span class="pull-right">Acções</span></th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$user_id=$row['id'];
						$fullname=$row['nomeCompleto'];
						$user_name=$row['username'];
						$user_role=$row['descricao'];

						$date_added= date('d/m/Y', strtotime($row['data_ingresso']));
                        $sexo=$row['sexo'];
						
					?>
					
					<input type="hidden" value="<?php echo $row['nomeCompleto'];?>" id="nombres<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $row['estado'];?>" id="apellidos<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $user_role;?>" id="email<?php echo $user_id;?>">
				
					<tr>
						<td><?php echo $user_id; ?></td>
						<td><?php echo $fullname; ?></td>
						<td ><?php echo $user_name; ?></td>
						<td ><?php echo $user_role; ?></td>
						<td><?php echo $date_added;?></td>
                        <td><?php echo $sexo;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar utilizador' data-backdrop="false" onclick="obtener_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
					<a href="#" class='btn btn-default' title='Inserir Palavra Passe' data-backdrop="false" onclick="get_user_id('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog"></i></a>
					<a href="#" class='btn btn-default' title='Eliminar Utilizador'  onclick="eliminar('<? echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>



                        </span>
                        <?php

                        if ($row['idprevilegio'] == 1){
                            echo '<br><br><a href="../aluno/Aluno.php?acao="' .$user_id.'  target="frm_content" style="color: #ff33cc;" >Add As Estudant </a>';
                        }
                        ?>

                    </td>



					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=9><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>