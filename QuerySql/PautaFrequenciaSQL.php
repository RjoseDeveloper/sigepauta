<?php

require_once('../functions/Conexao.php');
require_once('../controller/EstudanteNotaCtr.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../QuerySql/PublicacaoPautaSQL.php');

require_once('../controller/SexoCtr.php');
require_once('../QuerySql/AllQuerySQL.php');
require_once('../QuerySql/EstudantesSQL.php');

$ctr_est = new EstudantesSQL();
$query = new QuerySql();

class PautaFrequencia {

    private $db;
    private $row;
    private $query;
    private $result;
    private static $item;
    private $vetor_nrmec;
    private $json_data;
    private $json_php;
    private $array;
    private $arrayd;

    /*
     *
     * Permite obter a media de frequencia para admissao ao exame normal e de exame de recorrencia;
     * */

    public function obterMediaFrequecia($disciplina, $aluno, $estado,$curso, $ctr)
    {
        $db = new mySQLConnection();
        //$intenal = new PautaFrequencia();

        $query = "SELECT DISTINCT AVG(estudante_nota.nota) as media, data_avaliacao.idplano as tipo, disciplina.idDisciplina from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
INNER JOIN inscricao ON disciplina.idDisciplina = inscricao.iddisciplina

                        INNER JOIN curso ON curso.idcurso = pautanormal.idcurso
                        INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disciplina' AND estudante_nota.idaluno = '$aluno'
                        AND pautanormal.estado= '$estado' AND pautanormal.idcurso= '$curso'";

        if ($ctr == 0){
            $query.='GROUP BY data_avaliacao.id_data';
        }

        $result = mysqli_query($db->openConection(), $query);
        if (mysqli_num_rows($result) > 0){
            $soma =0;

            while ($row = mysqli_fetch_assoc($result)) {

                $ppeso = self::returnPesoAvaliacao($disciplina, $row['tipo'])/100;

                $soma = $soma+ ($row['media']*$ppeso);
            }
            return (round($soma));
        }else{
            return 'Sem Notas Completas';
        }

    }

    public function getNotaExame($disciplina, $aluno, $estado,$curso, $ctr)
    {
        $db = new mySQLConnection();

        $query = "SELECT DISTINCT  estudante_nota.nota,tipoavaliacao.descricao from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                        INNER JOIN inscricao ON disciplina.idDisciplina = inscricao.iddisciplina

                        INNER JOIN curso ON curso.idcurso = pautanormal.idcurso
                        INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
                        WHERE disciplina.idDisciplina = '$disciplina' AND estudante_nota.idaluno = '$aluno'
                        AND pautanormal.estado= '$estado' AND pautanormal.idcurso= '$curso'";

        if ($ctr == 0){
            $query.= 'AND data_avaliacao.descricaoteste LIKE "% Exame Normal"
                            GROUP BY data_avaliacao.id_data';
        }else{
            $query.='AND data_avaliacao.descricaoteste LIKE "% Exame de Recorrencia"
                            GROUP BY data_avaliacao.id_data';
        }
        $ctr_est = new EstudantesSQL();
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            if ($ctr_est->returnMediaEstudante($aluno, $disciplina, $curso) < 16
                || $ctr_est->validar_busca_recorrencia($aluno, $disciplina, $curso, 5) < 10){
                return ($row['nota']);
            }
        }

    }
    public function getMecaEstudante($id)
    {
        $link =new mySQLConnection();

        $result = mysqli_query($link->openConection(), "SELECT aluno.nr_mec as nrEstudante FROM aluno
                                                                WHERE aluno.idaluno = '$id';");
        if ($row = mysqli_fetch_assoc($result)) {
            return ($row['nrEstudante']);
        }

    }

    public function getnomeDisp($id)
    {
        $link =new mySQLConnection();

        $result = mysqli_query($link->openConection(), "SELECT  descricao FROM disciplina
                                                                WHERE idDisciplina = '$id';");
        if ($row = mysqli_fetch_assoc($result)) {
            return ($row['descricao']);
        }

    }

    public function ordenacaoTestes($disciplina, $aluno, $estado,$curso, $ctr)
    {
        $sql1 = "SELECT DISTINCT ";
        $sql2 = "estudante_nota.nota,";

        $query ="";
        $sql3 = "data_avaliacao.id_data as tipo, pautanormal.idPautaNormal,
                               data_avaliacao.descricaoteste as descricao from estudante_nota

        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
        INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
        WHERE  pautanormal.idDisciplina= '$disciplina' AND pautanormal.idcurso = '$curso' AND pautanormal.estado= '$estado'";

        if ($ctr == 0) {

           $query.= $sql1.' '.$sql2.' '.$sql3." AND estudante_nota.idaluno = '$aluno'";

        }elseif($ctr == 2){

            $query.= $sql1.' '.$sql3." GROUP BY pautanormal.idPautaNormal";
        }
        $query.=" ORDER BY data_avaliacao.descricaoteste";

        return ($query);
    }

    public function obterAlunoCurso($displina, $curso)
    {
        return("SELECT estudante.nrEstudante,
                    estudante.nomeCompleto,
                    estudante_disciplina.dataReg,
                    estudante.idEstudante,
                    curso.descricao
                    FROM
                    estudante INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante
                    INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
INNER JOIN disciplina ON disciplina.idDisciplina = estudante_disciplina.iddisciplina
                    WHERE estudante_disciplina.iddisciplina = '$displina'
AND estudante_disciplina.idcurso='$curso'");
    }

    public function returnPesoAvaliacao($disp, $idplano)
    {
        $query ="SELECT planoavaliacao.peso FROM planoavaliacao
                 INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = planoavaliacao.idTipoAvaliacao
        WHERE planoavaliacao.idDisciplina = '$disp' AND planoavaliacao.idplano = '$idplano'";

        $link =new mySQLConnection();

        $result = mysqli_query($link->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return ($row['peso']);
        }
    }

    function disciplina_docente_curso (){
        return "SELECT disciplina.idDisciplina, disciplina.descricao FROM disciplina
                INNER JOIN docentedisciplina ON disciplina.idDisciplina = docentedisciplina.iddisciplina
                WHERE docentedisciplina.idCurso =".$_POST['curso'] ;
    }

}
