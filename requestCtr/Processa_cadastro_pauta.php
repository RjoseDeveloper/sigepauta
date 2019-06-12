<?php

session_start();

require_once('../dbconf/getConection.php');
require_once('../controller/EstudanteNotaCtr.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../Query/AllQuerySQL.php');
require_once("../controller/PautaRecorrenciaCtr.php");
require_once '../controller/PlanoAvaliacaoCtr.php';
require_once('../controller/TipoAvaliacaoCtr.php');
require_once('../Query/EstudantesSQL.php');
require_once('../Query/PublicacaoPautaSQL.php');
require_once('../controller/EstudanteCtr.php');

$db = new mySQLConnection();
$all_query = new QuerySql();
$sql_estudante = new EstudantesSQL();
$estudante_nota = new EstudanteNotaController();
$pauta_normal =   new PautaNormalController();
$exame_recorrencia = new PautaExameRecorrenciaController();
$tipo_avaliacao =    new TipoAvaliacaoController();
$plano_avaliacao = new PlanoAvaliacaoController();
$publicacao_pauta = new PublicarPauta();
$estudnteCtr = new EstudanteController();

$idDoc = $all_query->getDoc_id($_SESSION['username']);
$ctr =  $_POST['acesso'];

switch($ctr){

    case 1:
        // insere inicialmente a pauta normal

         $_SESSION['avaliacao'] = $_POST['avaliacao'];
         $_SESSION['disciplina']   = $_POST['disciplina'];
         $_SESSION['curso'] = $_POST['curso'];
         echo 'sucess inserted one row';

        break;
    case 13:

        $pauta_normal->insert($_SESSION['disciplina'],$_SESSION['avaliacao'],$_SESSION['curso']);
        //echo $_SESSION['disciplina'].' '.$_SESSION['avaliacao'].' '.$_SESSION['curso'];

        break;

    case 2:

        $nota = $_POST['nota'];
        $id_aluno = $_POST['id_aluno'];
        $estudante_nota->insertF1( $_SESSION['last_id'],$nota, $id_aluno);

       /* if ($_SESSION ['tipo_avaliacao'] == 'recorrencia' && $nota < 10){

            $result = mysqli_query($db->openConection(),
                "SELECT MAX(estudante_nota.idNota) as max FROM estudante_nota");
            $row= mysqli_fetch_assoc($result);
            $exame_recorrencia->insertRec($row['max'], $nota, $estado);
        }*/
        break;

    case 5:

        //$plano_avaliacao->update_peso(1,$_POST['peso'], $_POST['avaliacao']);
        break;

    case 6:

        $max = $all_query->seletMaxIndex();
        $_SESSION['max']= $max;
        echo $max;
        break;

    case 7:

        $_SESSION['nome_disp'] = $myvar->getNomeDsciplina($_POST['disp']);
        $_SESSION['idDisp'] = $_POST['disp'];
        $consulta = $est_ctr->getPlanoAvaliacao($_POST['disp'], 0);
        $vdp = (int)($_POST['disp']);
        $ctr= $_POST['ctr'];

        $result = mysqli_query($db->openConection(), $consulta);
        $t=0;
        $dp ="";
        while ($row = mysqli_fetch_assoc($result)) {
            $dp = $row['disp'];
            echo '<tr class="ui-bar-d">';
            echo '<th align="left">'.$row['descricao'].'</th>';
            echo '<th align="center">'.$row['peso'].'</th>';
            echo '<th align="center">'.$row['qtd'].'</th>';
            echo '</tr>';
        }
        break;

    case 12:

        $idEst = $sql_estudante->getIdEstudante($_POST['nraluno'],0);
        $estudante_nota->insertF1($_POST['idpauta'],$_POST['nota'], $idEst);
        $estudnteCtr->update_inclusao($_POST['idpauta']);

        break;
    default:
        echo('Nenhum parametro enviado!<br>');
}


