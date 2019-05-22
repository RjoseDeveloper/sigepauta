<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 4/14/2018
 * Time: 1:20 PM
 */

class DocenteSQL {

    public function disciplinas_docente($iddocente,$semeste,$ano){

        return "SELECT professor.idprofessor as idDocente,disciplina.idDisciplina, disciplina.descricao
FROM disciplina_curso INNER JOIN disciplina ON disciplina.idDisciplina = disciplina_curso.iddisciplina
  INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
  INNER JOIN professor ON utilizador.id = professor.idutilizador
                     WHERE  YEAR(disciplina_curso.data) ='$ano' AND professor.idprofessor = '$iddocente'";
    }

    function disciplinas_professor($id){

        return "SELECT disciplina.descricao as disp, curso.descricao as c, periodo.descricao as periodo,
  turma.descricao as sessao, disciplina_curso.data
FROM disciplina INNER JOIN disciplina_curso ON disciplina.idDisciplina = disciplina_curso.iddisciplina
  INNER JOIN curso ON curso.idcurso = disciplina_curso.idcurso
  INNER JOIN periodo ON periodo.idperiodo = curso.idperiodo
  INNER JOIN turma on turma.idcurso = curso.idcurso
WHERE disciplina_curso.idutilizador = '$id' GROUP BY disciplina_curso.idturma ";

    }

    function filter_docente($keyword){

        return "SELECT professor.idprofessor as idDocente, utilizador.nomeCompleto
                    FROM professor INNER JOIN utilizador ON professor.idutilizador = utilizador.id
                     WHERE utilizador.nomeCompleto LIKE '$keyword'";
    }

    public function sql_update_plano($idplano, $ctr){
        if ($ctr ===0){
            return "SELECT * FROM planoavaliacao WHERE planoavaliacao.idplano = '$idplano'";
        }elseif($ctr === 1){
            return "SELECT * FROM data_avaliacao WHERE data_avaliacao.idplano = '$idplano'";
        }
        else{
          return '';
        }
    }

    public function all_professor(){
        return 'SELECT professor.idprofessor, utilizador.id, professor.dataregisto, professor.tempo,
  utilizador.nomeCompleto, utilizador.sexo, grau_academico.descricao
FROM professor INNER JOIN utilizador ON utilizador.id = professor.idutilizador
INNER JOIN grau_academico ON grau_academico.idGrau = professor.idgrau';
    }

    public function all_actividade(){
        return 'SELECT actividade.idactividade, actividade.descricao, actividade.data_inicio,
actividade.data_fim, actividade.data_added, utilizador.nomeCompleto, curso.descricao as curso 
FROM actividade INNER JOIN curso ON curso.idcurso = actividade.idcurso
INNER JOIN utilizador ON utilizador.id = actividade.idutilizador';
    }

    public function all_despesas(){
        return 'SELECT despesa.iddespesa, despesa.valor, despesa.data_reg, despesa.details,
  orcamento.valor as orcamento, utilizador.nomeCompleto
FROM utilizador INNER JOIN despesa ON utilizador.id = despesa.idutilizador
INNER JOIN orcamento ON orcamento.idorcamneto = despesa.idorcamento';
    }

    public function all_orcamento(){
        return 'SELECT orcamento.idorcamneto,orcamento.valor, orcamento.details,
 orcamento.data_lacamento, utilizador.nomeCompleto
 from orcamento INNER JOIN utilizador
ON utilizador.id = orcamento.idutilizador';
    }

}