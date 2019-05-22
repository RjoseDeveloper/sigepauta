<?php

/*-------------------------
Autor: rjose
---------------------------*/
include('is_logged.php');//
/* Connect To Database*/
require_once("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php");//Contiene funcion que conecta a la base de datos
require_once('../../../QuerySql/PessoaSQL.php');

$pessoa = new PessoaSQL();

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_pessoa = intval($_GET['id']);

    $query = mysqli_query($con,$pessoa->get_all_pessoa(1,$id_pessoa));
    $count = mysqli_num_rows($query);

    if ($count == 0) {

        if ($delete1 = mysqli_query($con, "DELETE * FROM aluno WHERE idaluno ='" . $id_pessoa . "'")) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <strong>Aviso!</strong> Dados Removidos com sucesso.
            </div>
        <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> Erro tente novamente.
            </div>
        <?php

        }

    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Não pode eliminar este aluno tem dados associados.
        </div>
    <?php
    }


}
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));


    $aColumns = array('nr_mec');//Columnas de busqueda
    $sTable = "aluno";
    $sWhere = "";
    if ($_GET['q'] != "") {

        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%".$q."%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -4);
        $sWhere .= ')';
    }
    $sWhere .= " order by aluno.idaluno DESC";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 4; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/

    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
    $row = mysqli_fetch_assoc($count_query);

    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './alunos.php';
    //main query to fetch the data

    $queries = $pessoa->get_all_pessoa(0,0)." $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $queries);

    //loop through fetched data
    if ($numrows > 0) { ?>

        <div class="table-responsive">
            <table class="table">
                <tr class="info">

                    <th>Codigo</th>
                    <th>Nome Completo</th>
                    <th>Naturalidade</th>
                    <th>Morada</th>
                    <th>Sexo</th>
                    <th>Docença Frequente</th>
                    <th>Data de Ingresso</th>
                    <th class='text-right'>Acções</th>

                </tr>

                <?php while ($row = mysqli_fetch_array($query)) {

                    $id_pessoa = $row['idpessoa'];
                    $codigo = $row['nr_mec'];
                    $fullname = $row['fullname'];
                    $sexo = $row['sexo'];
                    $endereco = $row['bairro'];
                    $docenca = $row['docenca_freq'];
                    $distrito = $row['distrito'];
                    //$data = $row['data_nascimento'];
                    $date_added = date('d/m/Y', strtotime($row['data_nascimento']));

                    ?>

                    <input type="hidden" value="<?php echo $codigo;?>"
                           id="nombre_cliente<?php echo $codigo;?>">
                    <input type="hidden" value="<?php echo $sexo;?>"
                           id="telefono_cliente<?php echo $sexo;?>">
                    <input type="hidden" value="<?php echo $docenca;?>"
                           id="email_cliente<?php echo $docenca;?>">
                    <input type="hidden" value="<?php echo $endereco;?>"
                           id="direccion_cliente<?php echo $endereco;?>">
                    <input type="hidden" value="<?php echo $date_added;?>"
                           id="status_cliente<?php echo $date_added;?>">
                    <tr>

                        <td><?php echo $codigo; ?></td>
                        <td><?php echo $fullname; ?></td>
                        <td><?php echo $distrito;?></td>
                        <td><?php echo $endereco;?></td>
                        <td><?php echo $sexo;?></td>
                        <td><?php echo $docenca;?></td>
                        <td><?php echo $date_added;?></td>

                        <td><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar Pessoa'
                       onclick="obtener_datos('<?php echo $id_pessoa;?>');"><i class="glyphicon glyphicon-edit"></i></a>

                                <a href="#" class='btn btn-default' title='Listar Encarregado' data-toggle="modal"
                                   data-target="#list_encarregado" data-backdrop="false"
                                   onclick="listar_Encarregado('<?php echo $id_pessoa; ?>')"><i class="glyphicon glyphicon-list"></i>
                                </a>
                                <a href="#" class='btn btn-default' title='Apagar Estudante'
                                   onclick="eliminar('<?php echo $id_pessoa; ?>')"><i class="glyphicon glyphicon-trash"></i>
                                </a>

                                <a href="#" onclick="get_item_val('<?php echo $id_pessoa;?>')" style="color:darkred"
                                   data-toggle="modal" data-target="#registar_encarregado" data-backdrop="false"><div>Add Encarregado</a>


                            </span>

                        </td>

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