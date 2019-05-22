<?php

session_start();
require_once('../functions/Conexao.php');
require_once('../controller/ActividadeCtr.php');
require_once('../QuerySql/AllQuerySQL.php');
require_once '../controller/PlanoAvaliacaoCtr.php';
require_once('../controller/TipoAvaliacaoCtr.php');
require_once('../QuerySql/EstudantesSQL.php');
require_once('../QuerySql/PublicacaoPautaSQL.php');
require_once('../controller/EstudanteCtr.php');
require_once('../QuerySql/DocenteSQL.php');

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
$acao =  $_POST['acesso'];

switch($acao){

    case 1:
        $plano_avaliacao->insert($_POST['tipo_av'],$_POST['disp'],$_POST['qtd_av'],$_POST['peso'], $db);
        break;
    case 2:
        $plano_avaliacao->insert_data_avaliacao($_POST['data_av'],$_POST['descricao'],$db);
        break;

    case 4:
        $t=0;
        $consulta = $QueryCtr->listarPlanoActual($_SESSION['max']);
        $result = mysqli_query($db->openConection(), $consulta);
        while ($row = mysqli_fetch_assoc($result)) {

            $vdp= $row['idDisciplina'];
            $tipo= $row['av'];
            $_SESSION['disp']= $row['av'];
            echo '<tr class="ui-bar-d">';
            echo '<th align="left" >'.++$t.'</th>';
            echo '<td>'.$row['descricao'].'</td>';
            echo '<td>'.$row['tipo'].'</td>';
            echo '<td align="center" >'.$row['qtd'].'</td>';
            echo '<td align="center"><button  value="'.$tipo.'" onclick="edit_qtd (this.value)" class="emails"
                 id="edit_qtd"> Editar Qtd.</button></td> </tr>';
        }
        break;

    case 6:

        $max = $QueryCtr->seletMaxIndex();
        $_SESSION['max']= $max;
        echo $max;

        break;
    case 7:

        $disp = $_POST['disp'];
        $_SESSION['nome_disp'] = $publicar_pauta->getNomeDsciplina($disp);
        $_SESSION['idDisp'] = $disp;
        $ano = $_POST['ano'];

        if($_POST['ctr'] !=0){
            $consulta2 = $estudanteQueryCtr->consultarOrdemAvaliacao($disp,$ano, 1);
        }else{
            $consulta2 = $estudanteQueryCtr->consultarOrdemAvaliacao($disp,$ano, 0);
        }
        //$semestre = $_POST['semestre'];

        //$consulta1 = $estudanteQueryCtr->getPlanoAvaliacao($disp,$ano, 1);


        $result = mysqli_query($db->openConection(), $consulta2);
        $t=1;
        $dp ="";

        while ($row = mysqli_fetch_assoc($result)) {

            //$dp = $row['disp'];
            echo '<tr class="ui-bar-d">';
            echo '<td align="center" class="nome_tabela">'.$t.'</td>';
            echo '<td style="text-align: left">'.$row['descricaoteste'].'</td>';

            echo '<td style="">'.$row['dataRealizacao'].'</td>';
            $status=$row['status'];
            ++$t;
            if ($status == 1){$text_estado="Não Realizado";$label_class='label-warning';}
            else{$text_estado="Realizado"; $label_class='label-success';}
            echo '<td style="color:blue">'.$text_estado.'</td>';

            echo '<td style="text-align: center">';

            if ($_SESSION['tipo'] == 'docente' || $_SESSION['tipo'] == 'coordenador') {
                echo '<input type="hidden" name="campo_idplano" id="campo_idplano" value="'.$row['idplano'].'">';
                echo '<button value="" onclick="edit_plano('.$row['idplano'].')" class="btn btn-default btn-sm glyphicon glyphicon-edit"></button>&nbsp;';
//                echo'<button value="" onclick="remove_plano('.$row['idplano'].')"  class="btn btn-warning btn-sm glyphicon glyphicon-remove"></button> &nbsp;</td>';
            }else{
                echo '---';
            }
            echo '</tr>';
        }
        break;

    case 8:
        // este codgio retorna o nomes de docente usado no menu procurar planos de avaliacao de docentes
        $texto = "%".$_POST['texto']."%";
        $q= $docente_sql->filter_docente($texto);

        $result = mysqli_query($db->openConection(), $q);
        while ($row= mysqli_fetch_assoc($result)) {
            echo '<li style="color:#0000CC;" class="list-group-item" value="'.$row['idDocente'].'">'.$row['nomeCompleto'].'
                            <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';
        }
        break;

    case 10:

        $disp = $_POST['disp'];
        $nome_disp = $publicar_pauta->getNomeDsciplina($disp);
        $_SESSION['nome_disp'] = $nome_disp;
        echo '<div align="right"><h3>Disciplina a Notificar _'.$nome_disp.'</h3></div>';

        $t=0; $doc="";
        $proc = $QueryCtr->listaDocentesDisciplina($disp);
        $result = mysqli_query($db->openConection(), $proc);

        while ($row = mysqli_fetch_assoc($result)){
            if ($t > 1)
                echo " e "; $t++;
            $doc.= $row['nomeCompleto'];
        }
        echo '<div style="color:blue">Docente/s da disciplina  [ '.$doc.'  ]<div>';

    break;

    case 11:

        if ($_POST['ctr'] == 1){
            $tipo_avaliacao->create($_POST['avaliacao'], $db);
        }else{
            $manager->create($_POST['avaliacao'], $db);
        }
        break;

    case 12:

        $rs = mysqli_query($db->openConection(),"select * from tipoavaliacao WHERE estado = 2");
        while ($row= mysqli_fetch_assoc($rs)){
            $vetor[] = array('idavaliacao'=>$row['idTipoAvaliacao'],
                'descricao'=>$row['descricao']);
        }
        echo json_encode($vetor);
        break;

    case 13:

        $id =$_POST['docente_id'];
        $semestre = ""; //$_POST['semestre'];
        $ano =$_POST['ano'];

        $q= $docente_sql->disciplinas_docente($id,$semestre,$ano);
        $result = mysqli_query($db->openConection(), $q);
        while ($row= mysqli_fetch_assoc($result)) {
            echo '<li style="color:#0000CC"; class="list-group-item" value="'.$row['idDisciplina'].'">'.$row['descricao']. '
                        <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';
        }
        break;
    case 14:

        $disp = $_POST['disp'];
        $ano = $_POST['ano'];

        if($_POST['ctr'] != 0){
            $consulta = $estudanteQueryCtr->getPlanoAvaliacao($disp,$ano,1);
        }else{
            $consulta = $estudanteQueryCtr->getPlanoAvaliacao($disp,$ano,0);
        }

        $result = mysqli_query($db->openConection(), $consulta);
        $t=1;

        while ($row = mysqli_fetch_assoc($result)) {

            echo '<tr class="ui-bar-d">';
            echo '<td align="center">'.$t.'</td>';
            echo '<td align="center">'.$row['disp'].'</td>';
            echo '<td align="left">'.$row['descricao'].'</td>';
            echo '<td >'.$row['peso'].'</td>';

            if ($_SESSION['tipo'] == 'docente' || $_SESSION['tipo'] == 'coordenador') {

                echo '<td><button value="" onclick="edit_plano('.$row['idplano'].')" class="btn btn-default glyphicon glyphicon-edit"></button></td>';
//                echo'<button value="" onclick="remove_plano('.$row['idplano'].')"  class="btn btn-warning btn-sm glyphicon glyphicon-remove"></button> &nbsp;</td>';
            }else{
                echo '<td align="center">--</td>';
            }

            echo '</tr>';
        }
        break;

    default:
        echo 'Nenhum parametro enviado!<br>';
}
?>

