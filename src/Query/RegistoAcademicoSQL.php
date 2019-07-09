<?php
/**
 * Created by PhpStorm.
 * User: rjose
 * Date: 7/16/2016
 * Time: 5:39 PM
 */

class RegistoAcademicoSQL
{


    public function obter_registos_disp_curso($idcurso){
        return "Select DISTINCT disciplina.idDisciplina, disciplina.descricao from disciplina INNER JOIN disciplina_curso
ON disciplina.idDisciplina = disciplina_curso.iddisciplina
WHERE disciplina_curso.idcurso='$idcurso'";
    }


    Public function controlar_recorrencias($idcurso)
    {

        return "SELECT DISTINCT examerecorrencia.idExameRec,disciplina.ano, estudante.nrEstudante,disciplina.descricao,
                utilizador.nomeCompleto FROM estudante INNER JOIN estudante_nota
                ON estudante.idEstudante=estudante_nota.idEstudante INNER JOIN examerecorrencia
                ON examerecorrencia.idExameRec = estudante_nota.idNota INNER JOIN pautanormal
                ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal INNER JOIN disciplina
                ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN utilizador
                ON utilizador.id = estudante.idUtilizador
                WHERE pautanormal.idcurso ='$idcurso' AND examerecorrencia.estado = 1";
    }

    /***
     * @param $ctr
     * @return string esta funcao existe numa das classes retirar
     */
    public function getDiretorFaculdade($ctr)
    {
        $db = new mySQLConnection();
        switch ($ctr) {
            case 1:
                /* retorna o nome do diretor da faculdade e nome da faculdade;*/

                return "SELECT faculdade.idFaculdade, faculdade.descricao, utilizador.nomeCompleto
FROM faculdade INNER JOIN utilizador ON utilizador.id = faculdade.idDirector
  INNER JOIN docente ON utilizador.id = docente.idUtilizador";
                break;
            case 2;
                /* retorna o nome do diretor adjunto da faculdade*/

                $query = "SELECT utilizador.nomeCompleto AS descricao_s FROM faculdade
INNER JOIN utilizador ON utilizador.id = faculdade.idDiretorAdjunto
 INNER JOIN docente ON utilizador.id = docente.idUtilizador";

                $http = mysqli_query($db->openConection(), $query);
                if ($r = mysqli_fetch_assoc($http))
                    return $r['descricao_s'];
                break;
            case 3:
        }
    }

    function buscar_dados_estudantes()
    {
        return "SELECT DISTINCT estudante.idEstudante,utilizador.nomeCompleto from estudante
                INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante
                INNER JOIN utilizador ON  utilizador.id = estudante.idUtilizador
                WHERE estudante_disciplina.idcurso = 2";
    }

    function obter_idalunos_pauta($displina, $curso){

        return "SELECT DISTINCT estudante_nota.idaluno,
                aluno.nr_mec as nrEstudante,utilizador.nomeCompleto from estudante_nota
  INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
  INNER JOIN aluno ON aluno.idaluno = estudante_nota.idaluno
  INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
WHERE pautanormal.idDisciplina= '$displina'
      AND pautanormal.idcurso = '$curso' LIMIT 5";

    }

    function query_filter_aluno($curso,$texto){

    return "SELECT DISTINCT aluno.idaluno as idEstudante, aluno.nr_mec as nrEstudante, utilizador.nomeCompleto
            FROM aluno INNER JOIN utilizador ON aluno.idutilizador = utilizador.id
            WHERE utilizador.nomeCompleto LIKE '$texto'";
    }

    public function select_curso(){
        return "SELECT curso.idcurso, curso.descricao from curso";
    }

}