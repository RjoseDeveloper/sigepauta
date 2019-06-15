<?php

/*-------------------------
Autor: rjose
---------------------------*/
/* Connect To Database*/
require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
require_once("../../Query/DocenteSQL.php");
require_once("funcoes.php");

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <body>
    <script type="text/javascript" src="../fragments/js/exame_extra.js"></script>
    </body>
    </head>
    </html>


<?php
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('idinscricao');//Columnas de busqueda
    $sTable = "inscricao";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }

    $sWhere .= " order by idinscricao desc";
    
    include '../ajax/pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 4; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = 'exame_extraordinario.php';
    //main query to fetch the data

    $retorno = new MYSQLConsultas();
    $tabela1 = $retorno->estudantesEscritosCorrenteAnoComDuasDisciplinasMaximo();
    $tabela2 = $retorno->utilizadoresEdisciplinas();

    $tabelaFinal12= $retorno->juntandoConsultasUmEDois($tabela1, $tabela2);

    $tabela3 = $retorno->estudantesComNegativasExameNormal();
    $tabela4 = $retorno->estudantesComNegativasExameRecorrencia();

    $tabelaFinal34= $retorno->juntandoConsultasTresEQuatro($tabela3, $tabela4);

    $tabelaFinal= $retorno->juntandoTodasConsultas($tabelaFinal12, $tabelaFinal34);

    //echo "$tabelaFinal12";
    //echo "$tabelaFinal34";
   // echo "$tabelaFinal";

    //$test12= mysqli_query($con,"select idinscricao  from ($tabelaFinal12) as tab3");
    //$test34= mysqli_query($con,"select * from ($tabelaFinal34) as tab9");

    //echo "$test->num_rows";

    $sql = "select * from ($tabelaFinal) as tba7 $sWhere LIMIT $offset,$per_page";

    $query = mysqli_query($con, $sql);

   //loop through fetched data
    if ($numrows > 0) {
        ?>

        <div class="table-responsive container">
            <table class="table">
                <th>ID</th>
                <th>NOME COMPLETO</th>
                <th>CURSO</th>
                <th>DISCIPLINA</th>
                <th>DATA DE INSCRICAO</th>
                <th>NivelDaCadeira</th>
                <th>STATUS</th>
                <!--                <th><span class="pull-right">Acções</span></th>-->

                </tr>
                <?php while ($row = mysqli_fetch_array($query)) {

                    $idinscricao = $row['idinscricao'];
                    $nomeCompleto = $row['nomeCompleto'];
                    $curso = $row['curso'];
                    $disciplina = $row['disciplina'];
                    $data_registo = $row['data_registo'];
                    $estado = $row['estado'];
                    $nivelDaCadeira= $row['nivelDaCadeira'];
                    ?>

                    <input type="hidden" value="<?php echo $idinscricao;?>"
                           id="nombre_cliente<?php echo $idinscricao;?>">
                    <input type="hidden" value="<?php echo $nomeCompleto;?>"
                           id="nombre_cliente<?php echo $nomeCompleto;?>">
                    <input type="hidden" value="<?php echo $curso;?>"
                           id="curso<?php echo $curso;?>">
                    <input type="hidden" value="<?php echo $disciplina;?>"
                           id="disciplina<?php echo $disciplina;?>">
                    <input type="hidden" value="<?php echo $data_registo;?>"
                           id="status_cliente<?php echo $data_registo;?>">
                    <input type="hidden" value="<?php echo $nivelDaCadeira;?>"
                           id="nivel<?php echo $nivelDaCadeira;?>">
                    <input type="hidden" value="<?php echo $estado;?>"
                           id="estado<?php echo $estado;?>">
                    <tr>
                        <td><?php echo $idinscricao; ?></td>
                        <td><?php echo $nomeCompleto; ?></td>
                        <td><?php echo $curso;?></td>
                        <td><?php echo $disciplina;?></td>
                        <td><?php echo $data_registo ?></td>
                        <td><?php echo $nivelDaCadeira ?></td>
<!--                        <td>--><?php ////echo $status; ?><!--</td>-->

                        <?php if($estado=='HABILITADO'){?>
                            <td>
                                <button data-toggle='tab' title="DESABILITAR O ESTADO" class='btn btn-info btn-sm'
                                        onclick="enable_desable_status(this.value)" value="<?php echo $idinscricao;?>">
                                    <span class='glyphicon glyphicon-check'><?php echo " " .$estado;?></span>
                                </button>
                            </td>
                        <?php }else{?>
                            <td>
                                <button data-toggle='tab' title="HABILITAR O ESTADO" class='btn btn-warning btn-sm'
                                        onclick="enable_desable_status(this.value)" value="<?php echo $idinscricao;?>">
                                    <span class='glyphicon glyphicon-edit'><?php echo " " .$estado;?></span>
                                </button>
                            </td>
                        <?php } ?>
                    </tr>

                <?php } ?>
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
