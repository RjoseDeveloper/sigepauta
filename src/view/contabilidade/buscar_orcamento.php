<?php

	/*-------------------------
	Autor: rjose
	---------------------------*/
	/* Connect To Database*/
	require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
    require_once("../../Query/DocenteSQL.php");

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    $users = new DocenteSQL();

	if (isset($_GET['id'])){
		$user_id=intval($_GET['id']);

		$query=mysqli_query($con, "SELECT * from orcamento where orcamento.idorcamneto='".$user_id."'");
		$count=mysqli_num_rows($query);

		if ($count == 0){
			if ($delete1=mysqli_query($con,"DELETE FROM orcamento WHERE orcamento.idorcamneto='".$user_id."'")){
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
			  <strong>Error!</strong> Não pode eliminar possui disciplinas.
			</div>
			<?php
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('details');//Columnas de busqueda
		 $sTable = "orcamento";
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

		$sWhere.=" order by orcamento.idorcamneto desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/

		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows 
                                                  FROM $sTable  $sWhere");

		$row= mysqli_fetch_array($count_query);

		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './usuarios.php';
		//main query to fetch the data

        $queries=$users->all_orcamento();
		$sql=$queries." $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);

		//loop through fetched data
		if ($numrows>0){?>

			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Detalhes</th>
					<th>Valor do Orcamento</th>
					<th>Data de Registo</th>
					<th>Registado Pelo/</th>
					<th><span class="pull-right">Acções</span></th>
					
				</tr>
				<?php
                $i=0;
				while ($row=mysqli_fetch_array($query)){
				    $i++;

						$_id=$row['idorcamneto'];
						$fullname= utf8_encode($row['details']);
						$valor=$row['valor'];
						$date_added= date('d/m/Y', strtotime($row['data_lacamento']));
                        $nome=$row['nomeCompleto'];
						
					?>


					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $fullname; ?></td>
						<td ><?php echo $valor.' .00'; ?></td>
						<td><?php echo $date_added;?></td>
                        <td><?php echo $nome;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar Professor' data-backdrop="false"
                       onclick="obtener_datos('<?php echo $_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
					<a href="#" class='btn btn-default' title='Mostrar Disciplinas'
                       onclick="listar_Disciplinas('<?php echo $_id;?>');"
                       data-toggle="modal" data-target="#myModalx" data-backdrop="false"><i class="glyphicon glyphicon-list"></i></a>

                            <a href="#" class='btn btn-default' title='Eliminar Professor' onclick="eliminar('<?php echo $_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
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