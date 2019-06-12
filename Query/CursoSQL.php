<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 1/10/2019
 * Time: 11:22 PM
 */

class CursoSQL {

    function all_curso(){

        return "SELECT curso.idcurso,curso.codigo, curso.descricao,
              utilizador.nomeCompleto, curso.qtd_turmas,
              curso.taxa_matricula, curso.data_registo, periodo.descricao as regime
FROM curso INNER JOIN utilizador
ON utilizador.id = curso.idresponsavel INNER JOIN periodo ON periodo.idperiodo = curso.idperiodo";

    }

    function check_inserted_row($idcurso){

        return "SELECT DISTINCT curso.idcurso FROM curso INNER JOIN turma ON turma.idcurso=curso.idcurso
                INNER JOIN inscricao ON inscricao.idturma = turma.idturma
                WHERE curso.idcurso = '$idcurso'";
    }

}