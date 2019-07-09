<?php

	/*-------------------------
	Autor: rjose
	---------------------------*/
	include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos

    require_once '../../Query/CursoSQL.php';
    $cursox = new CursoSQL();

	//Archivo de funciones PHP

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$idcurso=intval($_GET['id']);

		$query=mysqli_query($con, $cursox->check_inserted_row($idcurso));
        $count = mysqli_num_rows($query);

        //echo $cursox->check_inserted_row($idcurso);

		if($count == 0 ){

			if ($delete1=mysqli_query($con,"DELETE FROM curso WHERE idcurso='".$idcurso."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Dados Eliminados com sucesso.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Erro tente novamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Não pode eliminar este curso existem registos associadas ao mesmo.
			</div>
			<?php
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('curso.descricao');//Columnas de busqueda
		 $sTable = "curso";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3);
			$sWhere .= ')';
		}
		$sWhere.=" order by curso.idcurso desc";

		include '../ajax/pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);

        //echo "SELECT count(*) AS numrows FROM $sTable  $sWhere";

		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = 'cursos.php';
		//main query to fetch the data

		$sql= $cursox->all_curso()." $sWhere LIMIT $offset,$per_page";
      		$query = mysqli_query($con, $sql);

		//loop through fetched data

		if ($numrows>0){
			$simbolo_moneda="MZN";
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Código</th>
					<th>Nome Curso</th>
					<th>Responsavel</th>
					<th>Data Registo</th>
                    <th>Qtd. Turmas/</th>
                    <th>Regime</th>
					<th class='text-right'>Taxa da Matricula</th>
					<th class='text-right'>Acções</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_assoc($query)){
						$idcurso=$row['idcurso'];
                        $nome_curso= utf8_encode($row['descricao']);
						$codigo_producto=$row['codigo'];
						$nombre_completo= utf8_encode($row['nomeCompleto']);
						$qtd_prod=$row['qtd_turmas'];
                        $regime=$row['regime'];
						$date_added= date('d/m/Y', strtotime($row['data_registo']));
						$precio_producto=$row['taxa_matricula'];
					?>
					
					<input type="hidden" value="<?php echo $codigo_producto;?>" id="codigo_producto<?php echo $idcurso;?>">
					<input type="hidden" value="<?php echo $nome_curso;?>" id="nombre_producto<?php echo $nome_curso;?>">
					<input type="hidden" value="<?php echo $regime;?>" id="regime">
                    <input type="hidden" value="<?php echo $nombre_completo;?>" id="fullname">
					<input type="hidden" value="<?php echo number_format($precio_producto,2,'.','');?>" id="precio_producto<?php echo $idcurso;?>">

                    <tr>
						
						<td><?php echo $codigo_producto; ?></td>
						<td ><?php echo $nome_curso; ?></td>
						<td><?php echo $nombre_completo;?></td>
						<td><?php echo $date_added;?></td>
						<td style="text-align: center"><?php echo $qtd_prod;?></td>
                        <td><?php echo $regime;?></td>
                        <td><span class='pull-right'><?php echo number_format($precio_producto,2);?></span></td>

                        <td ><span class="pull-right">
					<a href="#" class='btn btn-default' data-backdrop="false" title='Editar Curso' onclick="obtener_datos('<?php echo $idcurso;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
                            <a href="#" class='btn btn-default' title='Eliminar Curso' onclick="eliminar('<?php echo $idcurso; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=8><span class="pull-right">
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