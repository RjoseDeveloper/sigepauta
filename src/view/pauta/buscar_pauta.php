<?php

	/*-------------------------
	Autor: rjose
	---------------------------*/
	/* Connect To Database*/
	require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
	include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
    require '../../Query/AllQuerySQL.php';
    require '../../Query/DocenteSQL.php';

    $all_query = new QuerySql();

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    $users = new DocenteSQL();

	if (isset($_GET['id'])){
		$_id=intval($_GET['id']);

		$query=mysqli_query($con, "SELECT * from pauta WHERE pautanormal.idPautaNormal='".$_id."'");
		$count=mysqli_num_rows($query);
       // echo $_id;

		if ($count == 0){

			if ($delete1=mysqli_query($con,"DELETE FROM pautanormal WHERE pautanormal.idPautaNormal='".$_id."'")){
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
		 $aColumns = array('dataReg');//Columnas de busqueda
		 $sTable = "pautanormal";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sWhere.="";
		include '../ajax/pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 4; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
        $session_id= $_SESSION['id'];
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable WHERE pautanormal.idusers = '.$session_id.'  $sWhere");

		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = 'pautas.php';
		//main query to fetch the data

        $queries=$all_query->get_all_pauta($_SESSION['id'],2);

		$sql=$queries." $sWhere LIMIT $offset,$per_page";
        //echo $sql;
		$query = mysqli_query($con, $sql);

		//echo $sql;

		//loop through fetched data
		if ($numrows>0){?>

			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>ID</th>
					<th>Disciplina</th>
					<th>Curso</th>
					<th>Tipo de Avaliacao</th>
					<th>Data de Registo</th>
                    <th>Status</th>
					<th><span class="pull-right">Acções</span></th>
					
				</tr>
				<?php $i=0;
				while ($row=mysqli_fetch_array($query)){
                    $i++;

						$_id=$row['pauta'];
						$fullname= utf8_encode($row['disp']);
						$creditos=$row['curso'];
						$natureza=$row['descricao'];
						$date_added= date('d/m/Y', strtotime($row['dataReg']));
                    $datapub=$row['dataPub'];

                    $status=$row['estado'];


                    if ($status != 1 ){$text_estado="Publicada";$label_class='label-success';}
                    else{$text_estado="Não Publicada";$label_class='label-warning';}

						
					?>
					
					<input type="hidden" value="<?php echo $row['descricao'];?>" id="nombres<?php echo $_id;?>">
					<input type="hidden" value="<?php echo $row['creditos'];?>" id="apellidos<?php echo $_id;?>">
					<input type="hidden" value="<?php echo $natureza;?>" id="usuario<?php echo $_id;?>">
					<input type="hidden" value="<?php echo $text_estado;?>" id="email<?php echo $_id;?>">
				
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $fullname; ?></td>
						<td ><?php echo $creditos; ?></td>
						<td ><?php echo $natureza; ?></td>
						<td><?php echo $date_added;?></td>
                        <td class='text-center'><span class="label <?php echo $label_class;?>"><?php echo $text_estado;?></span></td>

						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar Pauta' data-backdrop="false"
                      onclick="editar_pauta('<?php echo $_id;?>');" data-toggle="modal" data-target="#md_edit_pauta"><i class="glyphicon glyphicon-edit"></i></a>

                            <a href="#" class='btn btn-default' title='Imprimir Pauta' data-backdrop="false"
                      onclick="print_lista_pauta('<?php echo $_id?>','html');">
                                <i class="glyphicon glyphicon-print"></i></a>
				     <a href="#" class='btn btn-default' title='Eliminar Pauta' onclick="eliminar_pauta('<?php echo $_id; ?>')">
                         <i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
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