<?php

/*-------------------------
Autor: rjose
---------------------------*/
/* Connect To Database*/
require_once ("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
require_once ("../../Query/DocenteSQL.php");

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if (isset($_GET['id'])){
    $user_id=intval($_GET['id']);

    $query=mysqli_query($con, "SELECT * FROM tipoavaliacao 
                                    WHERE tipoavaliacao.idTipoAvaliacao='".$user_id."'");

    $count=mysqli_num_rows($query);
    // echo $user_id;

    if ($count == 0){

        if ($delete1=mysqli_query($con,"DELETE FROM tipoavaliacao WHERE  tipoavaliacao.idTipoAvaliacao='".$user_id."'")){
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
    $aColumns = array('descricao');//Columnas de busqueda
    $sTable = "tipoavaliacao";
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

    $sWhere.=" order by idTipoAvaliacao desc";
    include '../ajax/pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 6; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
    //echo "SELECT count(*) AS numrows FROM $sTable  $sWhere";
    $row= mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './avaliacao.php';
    //main query to fetch the data


    $sql=" select * from tipoavaliacao $sWhere LIMIT $offset,$per_page";

    $query = mysqli_query($con, $sql);
    //echo $sql;

    //loop through fetched data
    if ($numrows>0){?>

        <div class="table-responsive container">
            <table class="table">
                <tr  class="info">
                    <th>ID</th>
                    <th>Descricao</th>
                    <th>Estado</th>

                    <th><span class="pull-right">Acções</span></th>

                </tr>
                <?php $i=0;
                while ($row=mysqli_fetch_array($query)){
                    $i++;
                    $user_id=$row['idTipoAvaliacao'];
                    $fullname= utf8_encode($row['descricao']);

                    $status=$row['estado'];


                    if ($status==2){

                        $txt = "<span class='panel panel-success'>Confirmada</span>";

                    }else{
                        $txt = "<span class='alert-danger'>Nao Confirmada</span>";
                    }



                    ?>

                    <input type="hidden" value="<?php echo $row['idTipoAvaliacao'];?>" id="nombres<?php echo $user_id;?>">
                    <input type="hidden" value="<?php echo $row['descricao'];?>" id="apellidos<?php echo $user_id;?>">



                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $fullname; ?></td>
                        <td ><?php echo $txt; ?></td>


                        <td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar Avaliacao' data-backdrop="false"
                       onclick="obtener_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>


                            <a href="#" class='btn btn-default' title='Eliminar Professor' onclick="eliminar('<?php echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

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