<?php

	/*-------------------------
	Autor: rjose
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
    require_once("../../../QuerySql/ContabilidadeSQL.php");
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    $contas = new ContabilidadeSQL();

	if (isset($_GET['id'])){

		$numero_factura=intval($_GET['id']);
		$del1="delete from prestacao where idinscricao='".$numero_factura."'";

        $query=mysqli_query($con, "SELECT  DISTINCT * FROM prestacao WHERE idinscricao='".$numero_factura."'");
        $rw_user=mysqli_fetch_array($query);
		if ($delete1=mysqli_query($con,$del1)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Dados Eliminados com sucesso
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Não é possivel eliminar dados.
			</div>
			<?php
		}
	}
	if($action == 'ajax'){

        // escaping, additionally removing everything that could be (html/javascript-) code
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $aColumns = array('prestacao.modepay');//Columnas de busqueda
        $sTable = "prestacao";
        $sWhere = "";
        $sWhere.="";

//        if ( $_GET['q'] != "" )
//        {
//            $sWhere = "WHERE (";
//            for ( $i=0 ; $i<count($aColumns) ; $i++ )
//            {
//                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
//            }
//            $sWhere = substr_replace( $sWhere, "", -3 );
//            $sWhere .= ')';
//        }


        $sWhere.=" order by prestacao.datapay desc";
        include 'pagination.php'; //include pagination file
        //pagination variables

        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 6; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");

        $consulta = $contas->all_paymantes(-1);
        //echo  $contas->all_paymantes(-1);
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];

        $total_pages = ceil($numrows/$per_page);
        $reload = './facturas.php';
        //main query to fetch the data
        $sql="$consulta $sWhere LIMIT $offset, $per_page";

        //echo $sql;
        $query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive tbl_cursosx">
			  <table class="table">

				<tr  class="info">
					<th>#</th>
					<th>Datalhes</th>
                    <th>Aluno(a)</th>
                    <th>Valor</th>
                    <th>Status</th>
					<th>Modalidade</th>
                    <th>Juro</th>
                    <th>Data de Pag.</th>
					<th class='text-center'>Total Pagamentos </th>
					<th class='text-right'>Acções</th>
				</tr>

				<?php $i=0;

				while ($row=mysqli_fetch_array($query)){

                        $i++;
						$id_factura=$row['idaluno'];
						$numero_factura=$row['valor'];
						$data_aded=date("d/m/Y",strtotime($row['datapay']));
						$nombre_cliente=$row['nomeCompleto'];
						$telefono_cliente=$row['celular'];
						$email_cliente=$row['email'];
						$juro=$row['juro'];
						$estado_factura=$row['status'];
                        $modopay = $row['modepay'];
                        $finalidade = $row['finalidade'];

						if ($estado_factura == 1){$text_estado="Paga";$label_class='label-success';}
						else{$text_estado="Pendente";$label_class='label-warning';}
						$total_venta=$row['valor'];

					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $finalidade; ?></td>
						<td>
                            <a href="#" data-toggle="tooltip" data-placement="top"
                               title="<i class='glyphicon glyphicon-phone'></i><?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i> <?php echo $email_cliente;?>"> <?php echo $nombre_cliente;?></a>
                        </td>

                        <td><?php echo $numero_factura; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
                        <td class='text-center'><?php echo $modopay; ?></td>
						<td class='text-right'><?php echo number_format ($juro,2); ?></td>
                        <td class='text-center'><?php echo $data_aded; ?></td>
                        <td class='text-center'><?php echo number_format ($total_venta,2); ?></td>
                        <td class="text-right">
						<a href="editar_factura.php?id_factura=<?php echo $id_factura;?>" target="frm_content" class='btn btn-default' title='Editar Factura' ><i class="glyphicon glyphicon-edit"></i></a>
						<a href="#" class='btn btn-default' title='Baixa Factura' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a>
						<a href="#" class='btn btn-default' title='Apagar Factura' onclick="eliminar('<?php echo $id_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					</td>
					</tr>

					<?php
				}
				?>
				<tr>
					<td colspan=10><span class="pull-left"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>