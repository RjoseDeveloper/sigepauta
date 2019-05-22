
<?php

session_start();
require_once('../QuerySql/PublicacaoPautaSQL.php');
require_once('../QuerySql/PublicacaoPautaSQL.php');
require_once("../functions/Conexao.php");
require_once('../controller/EstudanteNotaCtr.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../QuerySql/AllQuerySQL.php');
require_once('../QuerySql/EstudantesSQL.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../QuerySql/PublicacaoPautaSQL.php');
require_once('../controller/EstudanteCtr.php');

$est_ctr = new EstudantesSQL();
$controller_est = new EstudanteController();
$query = new QuerySql();
$idDoc = $query->getDoc_id($_SESSION['username']);
$db = new mySQLConnection();
$nome=""; $apelido ="";
$acao = $_POST['acao'];

switch($acao){

    case 1:

        $keyword = '%'.$_POST['keyword'].'%';
        $disciplina = $_REQUEST['disciplina'];
        $curso = $query->getDocenteIdCurso($disciplina, $idDoc);
        $consulta = $query->queryAutoComplete($keyword, $curso, $disciplina);
        $result = mysqli_query($db->openConection(), $consulta);

        $t=0;

        while ($row = mysqli_fetch_assoc($result)){
            $vetor[] = array('nome'=>$row['nomeCompleto']);

        }
        echo json_encode($vetor);
        break;

    case 3:
        $curso = $_POST['idcurso'];
        $nome = '%'.$_POST['keyword'].'%';

        $query = $est_ctr->list_estudante_disciplina($curso, $nome);
        $result = mysqli_query($db->openConection(), $query);
        $t=0;
        while ($row = mysqli_fetch_assoc($result)){
            ++$t;
            $estudante = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row['nomeCompleto']);
            echo '<li class="ui-body ui-body-a" onclick="set_item_estd(\''.str_replace("'", "\'", $row['nomeCompleto']).'\')">'.$estudante.'</li>';
        }
        $db->closeDatabase();

        break;


    case 4:
        $aluno = $_POST['nomec'];
        $idAluno =  $est_ctr->getIdEstByNameApelido($aluno,1);
        $_SESSION['aluno'] = $idAluno;

        $query = $est_ctr->estudanteRec($idAluno,1);
        $result = mysqli_query($db->openConection(), $query);
        $t=0;

        while ($row= mysqli_fetch_assoc($result)) {

            $vetor_x[] = array('codigo'=>$row['codigo'],
                'descricao'=>$row['descricao'],
                'nota'=>$row['nota'],
                'idnota'=>$row['idNota'],
                'idDisp'=>$row['idDisciplina']) ;
        }
        echo json_encode($vetor_x);

        $db->closeDatabase();
        break;

    case 5:

        $estado = 2;
        $idnota =  $_POST['disp'];
        $_SESSION['idnota_ass']= $idnota;

        $query = "UPDATE `examerecorrencia` SET  `estado`= '$estado'  WHERE  `idExameRec`= '$idnota'";

        $stmt = mysqli_prepare($db->openConection(),$query);
        $result = mysqli_stmt_bind_param($stmt,'ii',$estado, $idnota);

        if (mysqli_stmt_execute($stmt)){

            echo('Pauta publicada com sucesso');
        }else{
            echo('Nao foi possivel publicar a pauta');
        }

        break;

    case 6:

        $nome = '%'.$_POST['keyword'].'%';
        $query ="SELECT docente.idDocente, docente.nomeCompleto FROM docente
                            WHERE nomeCompleto LIKE '$nome'";
        $result = mysqli_query($db->openConection(), $query);

        while ($row = mysqli_fetch_assoc($result)){
            $docente = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row['nomeCompleto']);
            echo '<li  class="ui-body ui-body-d" onclick="sub_item_docente(\''.str_replace("'", "\'", $row['nomeCompleto']).'\')"><a>'.$docente.'</a></li>';

        }

        $db->closeDatabase();

        break;

    case 7:

        $fullname= $_POST['estudante'];
        $idest= $query->getIdEstByNameApelido($fullname, 0);

        $query = "SELECT COUNT(estudante_nota.idEstudante) as qtd FROM estudante_nota
INNER JOIN examerecorrencia ON estudante_nota.idNota = examerecorrencia.idExameRec
WHERE estudante_nota.idEstudante = '$idest'" ;
        $result = mysqli_query($db->openConection(), $query);

        if($row = mysqli_fetch_assoc($result)){
            echo $row['qtd'];
        }
        break;

    case 8:
        $controller_est->incluir_estudante($_POST['nrc'],$_POST['nota'],$_POST['cmt'],1,$_POST['ptn'], $_POST['idTipoAvaliacao']);
        break;
    case 9 :
        $controller_est->update_inclusao($_POST['ptn'],2);
        break;
}?>



