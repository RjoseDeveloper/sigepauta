<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 12/23/2018
 * Time: 3:22 PM
 */

class ContabilidadeSQL
{

    function buscar_pagamentos($fullname, $nmerc)
    {
        $sql = "";

        if (!isset($fullname) or !isset($nmerc)) {

            $sql = "";

        } else {
            //$sql.="WHERE utilizador.nomeCompleto like="'$fullna'" OR estudante.nr_mec =";
        }
        return $sql;
    }

    public function all_paymantes($_ctr)
    {
        $sql = 'SELECT';
        if($_ctr == -1){
            $sql.= ' SUM(prestacao.valor) as valor,';
        }else{
            $sql.= ' prestacao.valor,';
        }

      $sql.= 'prestacao.datapay, prestacao.modepay, juro.juro,
  pay_finality.finalidade,CONCAT(aluno.nome," ",aluno.apelido) as nomeCompleto, utilizador.celular,prestacao.status,
   utilizador.email, aluno.idaluno, aluno.nr_mec, pay_finality.idfinalidade
FROM prestacao INNER JOIN juro
    ON juro.idjuro = prestacao.idjuro INNER JOIN pay_finality
    ON pay_finality.idfinalidade = prestacao.idfinalidade
INNER JOIN utilizador ON utilizador.id = prestacao.user_session_id
INNER JOIN aluno ON aluno.idaluno = prestacao.idaluno';

        if ($_ctr != -1) {
            $sql .= ' WHERE aluno.idaluno =' . $_ctr;
        } else {
            $sql .= ' GROUP BY aluno.idaluno';
        }
        return $sql;
    }

    public function consult_actividade ($curso){

        return "SELECT DATEDIFF(actividade.data_inicio,actividade.data_fim) as periodo from actividade
INNER JOIN curso ON curso.idcurso = actividade.idcurso WHERE curso.idcurso = '$curso'
ORDER BY actividade.idactividade DESC LIMIT 1";

    }
}




