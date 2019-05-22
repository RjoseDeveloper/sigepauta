<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 1/16/2018
 * Time: 2:54 AM
 */

require '../functions/Conexao.php';
$db = new mySQLConnection();

class Classes {

    function find_distritos($idprovincia){

        return "SELECT  distrito.iddistrito, distrito.descricao
FROM distrito INNER JOIN provincia ON provincia.idprovincia = distrito.idprovincia
WHERE provincia.idprovincia = '$idprovincia'";
    }

    function find_periodos($idcurso){
        $db = new mySQLConnection();
        $query = 'SELECT  periodo.descricao
FROM curso INNER JOIN periodo ON curso.idcurso = periodo.idcurso
WHERE curso.idcurso='.$idcurso;

        $rs = mysqli_query($db->openConection(), $query);
        while ($linhas = mysqli_fetch_assoc($rs)){
            echo $linhas['descricao'].'<br>';
        }
    }

    function find_formandos(){
        return 'SELECT formando.idformando, formando.bi_recibo, formando.fullname, formando.celular, formando.email,
endereco.bairro, sexo.descricao as sexo,nivelescolar.descricao as nive, curso.descricao as curso

FROM formando INNER JOIN sexo on sexo.idsexo = formando.idsexo
INNER JOIN endereco ON endereco.idendereco = formando.idendereco
INNER JOIN nivelescolar ON nivelescolar.idnivel = formando.idnivelescolar
INNER JOIN inscricao ON formando.idformando = inscricao.idformando
INNER JOIN curso ON curso.idcurso = inscricao.idcurso';
    }

    function find_frm_periodos_or_mes($curso, $turma, $disp, $aluno, $ctr)
    {
        $html = '';
        $html = "SELECT DISTINCT aluno.idaluno, aluno.nr_mec,inscricao.idinscricao, utilizador.nomeCompleto, turma.descricao as turma,aluno.bi_recibo,
                  turno.descricao as turno,utilizador.sexo, disciplina.descricao as disciplina,regime.descricao as regime,
                   inscricao.data_registo, utilizador.email, aluno.idnivelescolar as nivel, aluno.idendereco as endereco,curso.descricao,
                   curso.taxa_matricula as taxa, utilizador.celular

        FROM utilizador
        INNER JOIN aluno on aluno.idutilizador = utilizador.id
        INNER JOIN inscricao ON inscricao.idutilizador = utilizador.id
        INNER JOIN turma ON turma.idturma = inscricao.idturma
				INNER JOIN turno ON turno.idturno = inscricao.idturno
INNER JOIN disciplina on disciplina.idDisciplina = inscricao.iddisciplina
INNER JOIN regime ON regime.idregime = inscricao.idregime
INNER JOIN curso ON curso.idcurso = turma.idcurso
		WHERE turma.idcurso = '$curso'";

        if ($ctr == 0) {
            $html .= " AND inscricao.idturma ='$turma' GROUP BY aluno.nr_mec ";
        } else if($ctr == 1) {
            $html .= " AND inscricao.iddisciplina ='$disp' GROUP BY aluno.nr_mec ";
        }elseif($ctr == 2){
            $html .= " AND inscricao.idutilizador ='$aluno' GROUP BY disciplina.descricao ";
        }
        return $html.' ORDER BY inscricao.data_registo LIMIT 10' ;
    }

    function find_frm_inscricao($formando, $curso){
      return "";

    }

    function find_formando_by($string){
        return "SELECT formando.idformando, formando.bi_recibo, formando.fullname as fullname
FROM formando WHERE formando.fullname LIKE '$string'";
    }

    function find_formaando_list(){
        return 'SELECT idformando,bi_recibo,fullname FROM formando LIMIT 4';
    }

    function find_users($q, $ctr){
        if ($ctr ==0){
            return "SELECT id, nomeCompleto as fullname FROM utilizador WHERE idprevilegio > 1 AND nomeCompleto LIKE '%$q%' LIMIT 3";
        }else if($ctr == 5){
            return "SELECT id, nomeCompleto as fullname FROM utilizador WHERE idprevilegio < 2 AND nomeCompleto LIKE '%$q%' LIMIT 3";
        }else{
            return "SELECT aluno.idaluno as id, CONCAT(aluno.nome,' ', aluno.apelido) as fullname FROM aluno WHERE CONCAT(aluno.nome,' ', aluno.apelido) LIKE '%$q%' LIMIT 3";
        }
    }

    public function return_mes()
    {
        if (date('m')== 1){return 'Janeiro';}
        if (date('m')== 2){return 'Fevereiro';}
        if (date('m')== 3){return 'Março';}
        if (date('m')== 4){return 'Abril';}
        if (date('m')== 5){return 'Maio';}
        if (date('m')== 6){return 'Junho';}
        if (date('m')== 7){return 'Julho';}
        if (date('m')== 8){return 'Agosto';}
        if (date('m')== 9){return 'Setembro';}
        if (date('m')== 10){return 'Outubro';}
        if (date('m')== 11){return 'Novembro';}
        if (date('m')== 12){return 'Dezembro';}
    }
    function find_periodos_curso($idcurso){
        return 'SELECT turma.idturma, turma.descricao
                FROM turma WHERE turma.idcurso='.$idcurso;
    }

    function find_disciplina($idcurso){
        return "SELECT disciplina.idDisciplina, disciplina.descricao
                FROM disciplina WHERE disciplina.idcurso='$idcurso'";
    }

    function find_estudante($idcurso){

        return 'SELECT DISTINCT inscricao.idutilizador as id, utilizador.nomeCompleto as fullname
                FROM inscricao INNER JOIN utilizador on utilizador.id=inscricao.idutilizador
                INNER JOIN turma on turma.idturma = inscricao.idturma
                  WHERE turma.idcurso ='.$idcurso;
    }

    function sql_update_user(){
        return "UPDATE utilizador SET username = ?, password = ?,
  fullname = ?, previlegio =?, descricao = ?
WHERE iduser = ? ";
    }

    function sql_update_pagamento(){
        return "UPDATE inscricao SET prestacao = prestacao + ?
WHERE idformando = ?";
    }

    function insert_encarregado(){
        return "INSERT INTO `encarregado_educacao`(`idlocaltrabalho`, `idpessoa`, `nrdocumento`,
                                                  `nivel_escolar`, `contacto`, `idade`, `parentesco`, `nomeCompleto`)
                                                  VALUES (?,?,?,?,?,?,?,?)";
    }
}