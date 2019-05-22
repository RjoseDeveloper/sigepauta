<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 12/5/2018
 * Time: 7:23 AM
 */

class PessoaSQL {


    function get_all_pessoa($ctr, $iduser){

        $sql ='SELECT DISTINCT aluno.idaluno as idpessoa, utilizador.nomeCompleto as fullname,
                aluno.bi_recibo, aluno.nr_mec, distrito.descricao as distrito, endereco.bairro,
                aluno.docenca_freq, aluno.data_nascimento, utilizador.sexo

                 from aluno INNER JOIN endereco ON endereco.idendereco = aluno.idendereco
                 INNER JOIN distrito ON distrito.iddistrito = aluno.iddistrito INNER JOIN utilizador
                ON utilizador.id = aluno.idutilizador';

        if ($ctr != 0){ $sql.=" WHERE aluno.idaluno ='$iduser' OR utilizador.username='$iduser'"; }
        return $sql;
    }

    public function list_emcarregado($id){

        return "SELECT * FROM encarregado_educacao INNER JOIN localtrabalho
ON localtrabalho.idlocaltrabalho = encarregado_educacao.idlocaltrabalho INNER JOIN nivelescolar
ON nivelescolar.idnivel = encarregado_educacao.nivel_escolar
WHERE encarregado_educacao.idpessoa = '$id'";

    }


    function get_disciplina_aluno($iduser){

        $sql ="SELECT disciplina.codigo,inscricao.data_registo, inscricao.status, disciplina.creditos, disciplina.natureza, disciplina.idDisciplina, disciplina.descricao
                 from disciplina INNER JOIN inscricao ON inscricao.iddisciplina = disciplina.idDisciplina
                  INNER JOIN utilizador ON utilizador.id = inscricao.idutilizador
                WHERE utilizador.username='$iduser'";
        return $sql;
    }

}