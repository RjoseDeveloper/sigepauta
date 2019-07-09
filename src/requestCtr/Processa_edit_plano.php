<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 7/25/2018
 * Time: 11:40 AM
 */

session_start();

require_once('../dbconf/getConection.php');
require_once('../controller/ActividadeCtr.php');
require_once('../Query/AllQuerySQL.php');
require_once '../controller/PlanoAvaliacaoCtr.php';
require_once('../controller/TipoAvaliacaoCtr.php');
require_once('../Query/EstudantesSQL.php');
require_once('../Query/PublicacaoPautaSQL.php');
require_once('../controller/EstudanteCtr.php');
require_once('../Query/DocenteSQL.php');

$QueryCtr = new QuerySql();
$docente_sql = new DocenteSQL();
$estudanteQueryCtr = new EstudantesSQL();
$db = new mySQLConnection();
$tipo_avaliacao = new TipoAvaliacaoController();
$plano_avaliacao = new PlanoAvaliacaoController();
$publicar_pauta = new PublicarPauta();
$manager = new MannagerController();
$avaliacao = new TipoAvaliacaoController();

$estado = 1;
$idDoc = $query->getDoc_id($_SESSION['username']);
$acao =  $_POST['acao'];

switch($acao){

    case 1:

        $plano_avaliacao->update_table_plano($_POST['avaliacao'],$_POST['peso'],$_POST['qtd'],$db);
        break;

    case 2:

        $plano_avaliacao->update_data($db,$_POST['data'], $_POST['idplano']);
        break;

    case 3:

        $idplano = $_POST['idplano'];
        $id_av = $_POST['avaliacao'];

        $q = $docente_sql->sql_update_plano($idplano,0);
        $result = mysqli_query($db->openConection(),$q );
        while ($row= mysqli_fetch_assoc($result)) {

            echo '<div class="col-lg-8 pull-right pl_registar">';
            echo '<label for="tipo_av">Selecionar tipo de avaliação:</label>';
            echo '<select class="form-control" id="tipo_av" name="tipo_av">';

            $result = mysqli_query($db->openConection(),"select * from tipoavaliacao");
            while ($rw= mysqli_fetch_assoc($result)) {
                echo "<option value=".$rw['idTipoAvaliacao'].">".$rw['descricao']."</option>";
            }

            echo "</select>";
            echo '<label for="chk_qtd">Quantidade de Avaliações:</label>
        <input   type="text" id="qtd_avaliacao" value="'.$row['qtdMaxAvaliacao'].'" class="qtd_avaliacao form-control"/>

        <label for="chk_peso">Indicar o Peso: </label>
        <input type="number" value="'.$row['peso'].'" name="peso_avaliacao" id="peso_avaliacao" class="peso_avaliacao form-control"/>';
        }

        $q1 = $docente_sql->sql_update_plano($idplano,1);
        $result = mysqli_query($db->openConection(),$q1 );

        while ($row= mysqli_fetch_assoc($result)) {
            echo '<label for="datas_avaliacao">Indicar as Datas: </label>
            <input class="form-control" id="datas_avaliacao"  type="date" placeholder="aaaa-mm-dd" value="'.$row['dataRealizacao'] . '">';
        }

        echo '<div class="pull-right a_modal"> <p style="cursor: pointer; color:blue"
                class="btn_criar_cdatas">Adicionar Datas</p></div>';
        echo '<p class="data_dinamics"></p>';
        echo '<br> <button value="edit" class="btn btn-info sv_plano" onclick="registar_plano();" id="sv_plano" >Guadar e Listar</button></div>';
        break;

    default: 'nenhum paramentro enviado';
}