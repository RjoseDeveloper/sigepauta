<?php

require_once("../functions/Conexao.php");
require_once('../controller/EstudanteNotaCtr.php');
require_once('../controller/PautaNormalCtr.php');

class PublicarPauta{

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

    /*-------------Mostra a lista de pautas nao/ou publicadas por curso, caso seja passado valor 1 retorna  ----*/

    public function listapautaCurso($estado, $idDoc){
        $db = new mySQLConnection();

        $query = "SELECT DISTINCT  pautanormal.idcurso, curso.descricao as curso FROM curso
  INNER JOIN pautanormal ON pautanormal.idcurso = curso.idcurso
  INNER JOIN utilizador ON utilizador.id = curso.coordenador
  INNER JOIN professor ON utilizador.id = professor.idutilizador
WHERE pautanormal.estado = '$estado' AND professor.idprofessor='$idDoc' OR utilizador.idprevilegio=3 OR utilizador.idprevilegio=6";

        $result = mysqli_query($db->openConection(),$query);
        $vector[] = null;
        while ($row = mysqli_fetch_assoc($result)){;
            $vector[] = array('idcurso' =>$row['idcurso'], 'curso'=>$row['curso']);
        }
        return ($vector);
    }

    public function listaDisciplinaCurso($estado, $curso){

        $db = new mySQLConnection();
        $query = "SELECT DISTINCT disciplina.descricao, disciplina.idDisciplina,
                    pautanormal.idPautaNormal as ptn, data_avaliacao.descricaoteste as avaliacao

          FROM pautanormal

                INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                INNER JOIN disciplina_curso ON disciplina.idDisciplina = disciplina_curso.iddisciplina
                INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao

    WHERE pautanormal.estado = '$estado' and pautanormal.idcurso = '$curso' AND data_avaliacao.status=2";

        $result = mysqli_query($db->openConection(),$query);
        while ($row[] = mysqli_fetch_assoc($result)){;}
        return ($row);
    }

    public function qtdAvaliacaoPublicada($estado, $curso)
    {
        $query ="SELECT  COUNT(DISTINCT pautanormal.idDisciplina) as quantidade
   FROM pautanormal INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
WHERE pautanormal.estado = '$estado' AND pautanormal.idcurso = '$curso'";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),$query);
        if ($row= mysqli_fetch_assoc($result)){
            return ($row['quantidade']);
        }

        $db->closeDatabase();


    }

    public function listaAvaliacaoDisciplina($estado, $disciplina, $curso, $ptn){

        //obtem somente pauta normal
        return "SELECT DISTINCT data_avaliacao.descricaoteste as avaliacao,data_avaliacao.id_data as tipo, disciplina.idDisciplina,
  pautanormal.idPautaNormal as ptn,pautanormal.idcurso, pautanormal.dataReg FROM data_avaliacao
  INNER JOIN pautanormal ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
  INNER JOIN disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina
  INNER JOIN estudante_nota ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
        			WHERE disciplina.idDisciplina= '$disciplina' AND pautanormal.estado = '$estado'
        			 AND pautanormal.idcurso= '$curso' AND pautanormal.idPautaNormal = '$ptn'";
    }

    public function listaNotaEstudante($disciplina,$pautaNormal,$curso, $estado){
        $db = new mySQLConnection();

        $query = "SELECT DISTINCT utilizador.nomeCompleto, estudante_nota.nota, disciplina.descricao,
                    estudante_nota.idNota,aluno.nr_mec as nrEstudante
                    FROM estudante_nota

    INNER JOIN aluno ON aluno.idaluno = estudante_nota.idaluno
                    INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                    INNER JOIN disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina
                    INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
  INNER JOIN inscricao ON inscricao.idutilizador = utilizador.id
                    WHERE disciplina.idDisciplina ='$disciplina'  AND pautanormal.estado= '$estado' AND pautanormal.idcurso= '$curso'
AND pautanormal.idPautaNormal = '$pautaNormal'";

        $result = mysqli_query($db->openConection(),$query);
        while ($row[] = mysqli_fetch_assoc($result)){;}
        return ($row);
        $db->closeDatabase();

    }

    public function getNomeDsciplina($idDisp){
        $db = new mySQLConnection();
        $query = "SELECT disciplina.descricao FROM disciplina
					WHERE disciplina.idDisciplina = '$idDisp';";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['descricao'];
        }
        $db->closeDatabase();
    }

    public function pautaNormal($ptn, $ctr)
    {
        if( $ctr==0){

            $query ="SELECT disciplina.descricao as valor FROM disciplina
 INNER JOIN pautanormal ON pautanormal.idDisciplina = disciplina.idDisciplina
WHERE pautanormal.idPautaNormal = '$ptn'";
        }

        if ($ctr== 2){
            $query = "SELECT pautanormal.idcurso as valor FROM pautanormal
WHERE pautanormal.idPautaNormal = '$ptn'";

        }
        if ($ctr== 1){
            $query ="SELECT disciplina.idDisciplina as valor FROM disciplina
INNER JOIN pautanormal ON pautanormal.idDisciplina = disciplina.idDisciplina
WHERE pautanormal.idPautaNormal = '$ptn'";
        }

        if ($ctr== 3){
            $query = "SELECT curso.descricao as valor FROM curso
          INNER JOIN pautanormal on pautanormal.idcurso = curso.idCurso
WHERE pautanormal.idPautaNormal ='$ptn'";

        }
        if ($ctr== 4){
            $query ="SELECT data_avaliacao.descricaoteste as valor FROM data_avaliacao
          INNER JOIN pautanormal ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
WHERE pautanormal.idPautaNormal =  '$ptn'";
        }

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['valor'];
        }
        $db->closeDatabase();
    }


    /*--------------------------Lista de disciplina curso estudante ---------------------------------*/

    public function listaEstudanteDisp($idEst, $disp){
        $db = new mySQLConnection();

        return("SELECT DISTINCT disciplina.descricao, disciplina.idDisciplina FROM  disciplina
                                        INNER JOIN docentedisciplina ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                                                  INNER JOIN curso on curso.idCurso = docentedisciplina.idCurso INNER JOIN inscricaodisciplina
                                                  on inscricaodisciplina.iddisciplina = disciplina.idDisciplina INNER JOIN inscricao
                                                  ON inscricao.idinscricao = inscricaodisciplina.idinscricao INNER JOIN estudante
                                                  ON estudante.idEstudante = estudante.idEstudante
                                          WHERE estudante.idEstudante = '$idEst' AND disciplina.descricao LIKE '%$disp%'
                                          ORDER BY disciplina.descricao ASC;");
    }


    public  function get_Director_Curso($idcurso){
        $db = new mySQLConnection();
        $q ='SELECT CONCAT_WS(" º. ",grau_academico.descricao,utilizador.nomeCompleto) as coor_curso FROM utilizador
INNER JOIN professor ON professor.idutilizador = utilizador.id
INNER JOIN curso ON curso.idresponsavel = utilizador.id
INNER JOIN grau_academico ON grau_academico.idGrau= professor.idgrau WHERE curso.idcurso ='.$idcurso;
        $rs = mysqli_query($db->openConection(), $q);

        if ($row= mysqli_fetch_assoc($rs)) {
            return ($row['coor_curso']);
        }
    }

    /***
     * @return mixed nome dos responsaveis das instituicoes ou docentes
     */
    function get_nome_dir_adj($tipo_user){

        $db = new mySQLConnection();
        $query='SELECT perfil_instituicao.dirpedagogico as grau, utilizador.nomeCompleto
FROM utilizador INNER JOIN perfil_instituicao ON perfil_instituicao.idutilizador_resp  = utilizador.id
LIMIT 1';

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['grau']);
        }
    }

    public function buscar_docente($dip){
        $db = new mySQLConnection();

        $q = "SELECT utilizador.nomeCompleto, utilizador.sexo, grau_academico.descricao FROM professor
INNER JOIN utilizador ON professor.idutilizador = utilizador.id
 INNER JOIN grau_academico ON grau_academico.idGrau = professor.idgrau
 INNER JOIN disciplina_curso ON disciplina_curso.idutilizador = utilizador.id
            WHERE disciplina_curso.idcurso= '$dip'";

        $rs = mysqli_query($db->openConection(), $q);
        $t=0; $sexo="";
        if ($row= mysqli_fetch_assoc($rs)) {

            if ($row['sexo'] == 'M'){
                $sexo='º';

            }else{
                $sexo='ª';
            }

            return ($row['descricao'].''.$sexo.'.  '.$row['nomeCompleto']);
        }
    }


    public function mostra_datas_plano($disp,$ano,$semestre, $av)
    {
        return ("SELECT data_avaliacao.idData,data_avaliacao.descricaoteste as descricao, data_avaliacao.dataRealizacao,
  planoavaliacao.idTipoAvaliacao FROM data_avaliacao
  INNER JOIN planoavaliacao ON planoavaliacao.idplano = data_avaliacao.idplano
  INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = planoavaliacao.idTipoAvaliacao

  WHERE planoavaliacao.idDisciplina = '$disp' AND year(planoavaliacao.data_registo)= '$ano'
  AND planoavaliacao.idsemestre = '$semestre' AND tipoavaliacao.idTipoAvaliacao = '$av'");

    }

    public function contar_datas_avaliacao($av, $disp)
    {

        $db = new mySQLConnection();

        $rs = mysqli_query($db->openConection(), "SELECT COUNT(data_avaliacao.idavaliacao) as contas FROM data_avaliacao
WHERE data_avaliacao.idavaliacao = '$av' AND data_avaliacao.idDisciplina = '$disp';");
        if ($row = mysqli_fetch_assoc($rs)){
            return ($row['contas']);
        }
    }

    public function listar_notificacao($idc){
        $db = new mySQLConnection();

        $q = "SELECT DISTINCT  disciplina.descricao, disciplina.idDisciplina as idpauta,disciplina.descricao,
 curso.descricao as curso from estudante_inclusao INNER JOIN pautanormal ON
pautanormal.idPautaNormal = estudante_inclusao.idpauta INNER JOIN
disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN curso
ON curso.idCurso = pautanormal.idcurso WHERE pautanormal.idcurso ='$idc' AND estudante_inclusao.estado=1 ";
        $http = mysqli_query($db->openConection(), $q);
        while($row[] = mysqli_fetch_assoc($http)){;}
        return $row;
    }

    public function qtdEstudantesIncluidos($idpauta){

        $q="SELECT COUNT(DISTINCT estudante_inclusao.nr_estudante) as qtd from estudante_inclusao INNER JOIN
pautanormal ON pautanormal.idPautaNormal= estudante_inclusao.idpauta INNER JOIN disciplina
ON disciplina.idDisciplina= pautanormal.idDisciplina
 WHERE pautanormal.idDisciplina  = '$idpauta' AND estudante_inclusao.estado=1";

        $db = new mySQLConnection();
        $http = mysqli_query($db->openConection(), $q);
        if($row = mysqli_fetch_assoc($http)) {
            return ($row['qtd']);
        }
    }

    public function getIdCoordenador($idDoc){
        $q="SELECT curso.idcurso as c FROM curso INNER JOIN disciplina_curso
ON curso.idcurso = disciplina_curso.idcurso INNER JOIN professor
ON professor.idutilizador = disciplina_curso.idutilizador
WHERE professor.idprofessor = '$idDoc'";

        $db = new mySQLConnection();
        $http = mysqli_query($db->openConection(), $q);
        if($row = mysqli_fetch_assoc($http)) {
            return ($row['c']);
        }
    }

    public function listarInclusao($idDisp){

        $q="SELECT estudante_inclusao.id, utilizador.nomeCompleto, estudante_inclusao.comentario,
 estudante_inclusao.avaliacao, estudante_inclusao.data_reg, estudante_inclusao.nota,
 estudante_inclusao.nr_estudante, estudante_inclusao.idpauta
FROM estudante_inclusao INNER JOIN estudante ON estudante.nrEstudante = estudante_inclusao.nr_estudante
 INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_inclusao.idpauta
 INNER JOIN utilizador ON utilizador.id = estudante.idUtilizador
WHERE pautanormal.idDisciplina = '$idDisp' AND estudante_inclusao.estado = 1 ";

        $db = new mySQLConnection();
        $http = mysqli_query($db->openConection(), $q);
        while($row[] = mysqli_fetch_assoc($http)){;}
        return $row;
    }
}

?>

