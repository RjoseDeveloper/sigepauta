
<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 2/26/2018
 * Time: 10:43 PM
 */

class EstudantesSQL {

    public function obter_id_estudante($fullname){
        return 'SELECT idEstudante  FROM estudante INNER JOIN utilizador
ON utilizador.id=estudante.idUtilizador
WHERE utilizador.username ='.$fullname;
    }

    public function estudanteQtdAvaliacaoDisp($idEstudante,$disciplina,$estado)
    {
        $db = new mySQLConnection();
        $query = "SELECT COUNT(tipoavaliacao.idTipoAvaliacao) AS qtd, tipoavaliacao.idTipoAvaliacao as tipo FROM tipoavaliacao
INNER JOIN pautanormal ON pautanormal.idTipoAvaliacao = tipoavaliacao.idTipoAvaliacao
INNER JOIN disciplina ON disciplina.idDisciplina= pautanormal.idDisciplina
INNER JOIN estudante_nota ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal

WHERE disciplina.idDisciplina= '$disciplina' AND estudante_nota.idEstudante = '$idEstudante'
 AND pautanormal.estado= '$estado'
GROUP BY tipoavaliacao.descricao";

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)){ ;}
        return ($row);
        $db->closeDatabase();
    }

    /*Devolve um array com a lista de estudante, notas por disciplinas e tipo de avaliacao*/
    public  function listaNotaTesteAluno($idEstudante,$disciplina, $curso, $estado){

        $db = new mySQLConnection();
        $query ="";
        $query.="SELECT estudante_nota.idNota, tipoavaliacao.descricao, tipoavaliacao.idTipoAvaliacao as av,
                  estudante_nota.nota , pautanormal.idPautaNormal as ptn,
                pautanormal.dataReg FROM tipoavaliacao INNER JOIN pautanormal
            ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
            ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
            ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
                    WHERE disciplina.idDisciplina= '$disciplina'
                    AND estudante_nota.idEstudante = '$idEstudante'
                     AND  pautanormal.estado ='$estado'";

        //AND tipoavaliacao.idTipoAvaliacao = '$avaliacao'

        if (!is_null($curso)){
            $query.= "AND pautanormal.idcurso = '$curso'";
        }
        $result = mysqli_query($db->openConection(),$query);
        while ($array[] = mysqli_fetch_assoc($result)){;}
        return ($array);

        $db->closeDatabase();
    }

    public function listar_tipo_avaliacao($disp, $curso, $av)
    {
        $query="SELECT DISTINCT data_avaliacao.descricaoteste,
                pautanormal.idPautaNormal as idNota,
                pautanormal.idTipoAvaliacao as idavaliacao
                FROM data_avaliacao INNER JOIN pautanormal

            ON pautanormal.idTipoAvaliacao=data_avaliacao.id_data  INNER JOIN disciplina
            ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
            ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
            WHERE disciplina.idDisciplina='$disp' AND pautanormal.idcurso= '$curso'";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),$query);
        while ($array[] = mysqli_fetch_assoc($result)){;}
        return ($array);

        $db->closeDatabase();
    }

    public function obterEstudantesDisciplina($disp, $curso){

        return  (

        "SELECT DISTINCT aluno.nr_mec as numero,aluno.idaluno as idEstudante, utilizador.nomeCompleto
FROM aluno
  INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
  INNER JOIN inscricao ON utilizador.id = inscricao.idutilizador
  INNER JOIN turma ON turma.idturma = inscricao.idturma
WHERE turma.idcurso = '$curso' AND inscricao.iddisciplina= '$disp'
ORDER BY utilizador.nomeCompleto ASC ");
    }

    function  get_estudante_nota($idptn, $idaluno, $ctr){
        $sql='SELECT aluno.idaluno as idEstudante,  aluno.nr_mec as numero,utilizador.nomeCompleto,
  estudante_nota.idNota, estudante_nota.nota FROM aluno INNER JOIN estudante_nota
  ON aluno.idaluno = estudante_nota.idaluno
  INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
  INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
  INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
    WHERE estudante_nota.idPautaNormal  = '.$idptn;

        if ($ctr != 0){
            $sql.=' AND aluno.idaluno='.$idaluno;
        }
        return $sql;
    }

    //	obtem o identificado do estado apartir numero mecanografico;

    public function getIdEstudante($dado, $ctr){
        $db = new mySQLConnection();
        $query ="";
        if ($ctr == 0){
            $query.= "SELECT aluno.idaluno as id FROM aluno INNER JOIN
utilizador ON utilizador.id = aluno.idutilizador
 WHERE utilizador.username ='$dado' OR aluno.nr_mec ='$dado'";
        }else{
            $query.="SELECT utilizador.id as id FROM utilizador
                    INNER JOIN aluno ON utilizador.id = aluno.idutilizador
                    WHERE  utilizador.username ='$dado'";
        }

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){return $row['id'];}
    }

    /*---------------------------------------*/

    public function obterCursoEstudante($nrmec)
    {
        $db = new mySQLConnection();

        $query ="SELECT DISTINCT estudante_disciplina.idcurso as curso FROM estudante INNER JOIN estudante_disciplina
                              ON estudante_disciplina.idEstudante = estudante.idEstudante
                              WHERE estudante.nrEstudante = '$nrmec'";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['curso'];
        }
        $db->closeDatabase();
    }

    /*-----------Retorna o identificador do estudante apartir do nome e apelido recebido -------------*/

    public function getIdEstByNameApelido($fullname, $ctr){
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),
            "SELECT aluno.idaluno as idEstudante FROM aluno INNER JOIN utilizador
            ON utilizador.id = aluno.idutilizador
              WHERE utilizador.nomeCompleto ='$fullname'");
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idEstudante'];
        }
    }
    /**-----------Retorna a lista de tipos de avaliacao e suas respectivas quantidades--------------*/

    public function obterQtdAvaliacao($disciplina, $curso, $estado){
        $db = new mySQLConnection();

        $query = "SELECT  pautanormal.dataPub, pautanormal.idPautaNormal, data_avaliacao.id_data as tipo, data_avaliacao.descricaoteste as descricao
FROM pautanormal INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
    INNER JOIN  disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
WHERE disciplina.idDisciplina = '$disciplina' AND pautanormal.idcurso = '$curso' AND pautanormal.estado='$estado'
GROUP BY tipo, pautanormal.idPautaNormal;";

        $vetor [] = null;
        $result = mysqli_query($db->openConection(), $query);
        // echo $query;
        while($row= mysqli_fetch_assoc($result)){
            $vetor[] = array('tipo'=>$row['tipo'],
                'descricao'=>$row['descricao'],
                'idptn'=>$row['idPautaNormal'],
                'datapub'=>$row['dataPub']);
        }
        return  ($vetor);
    }

    /*----------- permite obter a nota de um estudante apartir do idNota -------------------*/
    public function getEstNota($idNota){
        $db = new mySQLConnection();

        $query = "SELECT estudante_nota.nota FROM estudante_nota
					WHERE estudante_nota.idNota = '$idNota';";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['nota'];
        }else{
            return 0;
        }
    }

    function obter_ano_ingresso($username){
        $db = new mySQLConnection();
        $query = mysqli_query($db->openConection(), "SELECT YEAR(utilizador.data_ingresso) as data_r FROM utilizador WHERE
utilizador.username = '$username'");
        if ($row= mysqli_fetch_assoc($query)){
            return $row['data_r'];
        }
    }




    ///---------------------------------------------------------------------------------

    public function estudanteDisciplina($estudante, $discplina, $ctr, $semestre, $ano) {

        $db = new mySQLConnection();

        $query = "SELECT DISTINCT disciplina.descricao, disciplina.idDisciplina,
curso.descricao as curso, curso.idcurso
FROM disciplina INNER JOIN inscricao  ON disciplina.idDisciplina = inscricao.iddisciplina
  INNER JOIN turma ON turma.idturma = inscricao.idturma
  INNER JOIN curso ON curso.idcurso = turma.idcurso
WHERE inscricao.idutilizador = '$estudante' AND year(inscricao.data_registo) = '$ano'";

        if ($ctr ==0){
            $query = $query."ORDER BY disciplina.descricao ASC";

        }else{
            $query = $query."AND disciplina.descricao LIKE '$discplina' ORDER BY disciplina.descricao ASC";
            return ($query);
        }

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)) {;}
        return ($row);

    }

    public function estudanteRec($estudante, $estado)
    {
        return ("SELECT estudante_nota.idNota, estudante_nota.nota, disciplina.codigo, disciplina.descricao,examerecorrencia.estado,
                        disciplina.idDisciplina FROM estudante_nota INNER JOIN examerecorrencia
                        ON examerecorrencia.idExameRec = estudante_nota.idNota INNER JOIN pautanormal
                        ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal INNER JOIN disciplina
                        ON disciplina.idDisciplina = pautanormal.idDisciplina

                        WHERE estudante_nota.idEstudante = '$estudante'
                                AND examerecorrencia.estado = '$estado'
                                AND pautanormal.idTipoAvaliacao = 4 AND estudante_nota.nota < 10
                                GROUP BY disciplina.descricao ASC");

    }


    public function  validarRecorrencia ($idEst, $idDisp){
        $query ="SELECT COUNT(examerecorrencia.idExameRec) as conta FROM examerecorrencia

			INNER JOIN estudante_nota ON estudante_nota.idNota = examerecorrencia.idExameRec
			INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNorma
			WHERE pautanormal.idTipoAvaliacao = 4
			AND estudante_nota.idEstudante = '$idEst'
			AND pautanormal.idDisciplina = '$idDisp'
			AND examerecorrencia.estado = 1";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['conta'];
        }
    }
    public function returnTipo($idnota, $ctr){

        if ($ctr == 0){
            $query ="SELECT pautanormal.idTipoAvaliacao as tipo ";
        }else{
            $query ="SELECT pautanormal.idDisciplina as tipo ";
        }

        $query = $query."FROM pautanormal
					INNER JOIN estudante_nota ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
					WHERE estudante_nota.idNota = '$idnota'";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['tipo'];
        }
    }

    public function  listaPautaPublicada($disp,$estado, $curso) {
        $db = new mySQLConnection();

        $query = " SELECT DISTINCT tipoavaliacao.descricao as avaliacao,tipoavaliacao.idTipoAvaliacao as tipo
                    FROM pautanormal INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                    INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao
                    WHERE disciplina.idDisciplina= '$disp' AND pautanormal.estado = '$estado'  AND pautanormal.idcurso = '$curso'";
        $result = mysqli_query($db->openConection(),$query);

        while ($row[] = mysqli_fetch_assoc($result)){;}
        return ($row);

        $db->closeDatabase();
    }

    public function getpautaDate($disciplina, $estd, $estado, $curso)
    {

        return ("SELECT estudante_nota.idNota,estudante_nota.nota,  data_avaliacao.id_data as tipo, data_avaliacao.descricaoteste,
                pautanormal.idPautaNormal as ptn,pautanormal.dataReg, pautanormal.dataPub
								FROM estudante_nota INNER JOIN pautanormal ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
								INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao

                WHERE estudante_nota.idaluno = '$estd' AND pautanormal.estado= '$estado'
                AND pautanormal.idDisciplina = '$disciplina' AND pautanormal.idcurso = '$curso'

                GROUP BY estudante_nota.idNota ORDER BY data_avaliacao.dataRealizacao DESC");

    }
    public function obterIdCursoEstudante($id)
    {

        $query ="SELECT DISTINCT turma.idcurso FROM turma
INNER JOIN inscricao ON turma.idturma = inscricao.idturma
INNER JOIN utilizador ON utilizador.id = inscricao.idutilizador
WHERE inscricao.idutilizador = '$id';";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['idcurso'];
        }
    }

    public function obterQtdAvaliacaoPub($disciplina,$estado,$curso, $ctr){
        $db = new mySQLConnection();

        $query = "SELECT  data_avaliacao.id_data as tipo, disciplina.idDisciplina,data_avaliacao.descricaoteste as descricao
                    FROM pautanormal INNER JOIN data_avaliacao
                    ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao INNER JOIN  disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina
                    WHERE disciplina.idDisciplina = '$disciplina' AND pautanormal.estado= '$estado' and pautanormal.idcurso ='$curso'
GROUP BY data_avaliacao.id_data";

        $result = mysqli_query($db->openConection(), $query);
        if ($ctr == 0){
            return (mysqli_num_rows($result));

        }else{

            while($row[] = mysqli_fetch_assoc($result)){;}
            return  ($row);
        }
    }


    public function pautaPublicadas($estado, $curso)
    {
        $db = new mySQLConnection();

        $query = "
                    SELECT DISTINCT tipoavaliacao.idTipoAvaliacao as idtipo, COUNT(tipoavaliacao.idTipoAvaliacao)AS conta, disciplina.descricao

                    FROM disciplina INNER JOIN pautanormal ON pautanormal.idDisciplina = disciplina.idDisciplina
                    INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao= pautanormal.idTipoAvaliacao
                    INNER JOIN curso ON curso.idCurso = disciplina.idCurso WHERE curso.idCurso= '$curso' AND
                    pautanormal.estado = '$estado' GROUP BY disciplina.descricao";

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)) {; }
        return ($row);
    }

    public function getCursoDescricao($disp)
    {
        $db = new mySQLConnection();
        $query = "SELECT curso.descricao FROM curso INNER JOIN disciplina ON
            disciplina.idCurso = curso.idCurso
               WHERE disciplina.idDisciplina = '$disp'";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['descricao '];
        }

    }

    public function getCoutEstdPauta($value, $estado)
    {

        $db = new mySQLConnection();
        $query = "SELECT COUNT(estudante_nota.idEstudante) as conta FROM
                    estudante_nota INNER JOIN pautanormal ON pautanormal.idPautaNormal= estudante_nota.idPautaNormal
                    WHERE pautanormal.estado = '$estado' AND pautanormal.idTipoAvaliacao= '$value';";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['conta'];
        }
    }


    public function getDetalhesPauta($idCurso)
    {

        $db = new mySQLConnection();

        $query ="SELECT disciplina.descricao, disciplina.idDisciplina, COUNT(pautanormal.idTipoAvaliacao) as conta FROM disciplina
                INNER JOIN curso ON curso.idCurso = disciplina.idCurso  INNER JOIN pautanormal
                ON pautanormal.idPautaNormal = disciplina.idDisciplina INNER JOIN tipoavaliacao
                ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao
                WHERE curso.idCurso='$idCurso'
                GROUP BY tipoavaliacao.descricao";

        $result = mysqli_query($db->openConection(), $query);
        while ($row[] = mysqli_fetch_assoc($result)) {;}
        return ($row);

    }

    public function getPlanoAvaliacao($disciplina)
    {
        return("SELECT DISTINCT disciplina.descricao as disp,planoavaliacao.idplano,
                     planoavaliacao.peso, tipoavaliacao.descricao, tipoavaliacao.idTipoAvaliacao
                     FROM tipoavaliacao INNER JOIN planoavaliacao
                     ON tipoavaliacao.idTipoAvaliacao = planoavaliacao.idTipoAvaliacao INNER JOIN disciplina
                     ON disciplina.idDisciplina = planoavaliacao.idDisciplina
              WHERE planoavaliacao.idDisciplina= '$disciplina' GROUP BY disciplina.descricao,planoavaliacao.idplano,
                     planoavaliacao.peso, tipoavaliacao.descricao, tipoavaliacao.idTipoAvaliacao");
    }

    public function consultarOrdemAvaliacao($disciplina){
        return "SELECT data_avaliacao.dataRealizacao,data_avaliacao.descricaoteste,
                    planoavaliacao.idplano,data_avaliacao.status
                     FROM  planoavaliacao INNER JOIN disciplina
                     ON disciplina.idDisciplina = planoavaliacao.idDisciplina INNER JOIN data_avaliacao
                     ON planoavaliacao.idplano = data_avaliacao.idplano
              WHERE planoavaliacao.idDisciplina= '$disciplina' GROUP BY data_avaliacao.descricaoteste,data_avaliacao.dataRealizacao,
                    planoavaliacao.idplano,data_avaliacao.status ";
    }

    public function checkIdPautaNorml($disciplina, $av,$estado,$idptn, $curso , $ctr){
        $query = "SELECT estudante_nota.idNota, tipoavaliacao.idTipoAvaliacao as tipo, tipoavaliacao.descricao, estudante_nota.nota,
                pautanormal.idPautaNormal as ptn,pautanormal.dataReg, pautanormal.dataPub,estudante.nrEstudante as nrmec,
                estudante.nomeCompleto,disciplina.descricao as displ
                FROM tipoavaliacao INNER JOIN pautanormal
                ON pautanormal.idTipoAvaliacao= tipoavaliacao.idTipoAvaliacao INNER JOIN disciplina
                ON disciplina.idDisciplina= pautanormal.idDisciplina INNER JOIN estudante_nota
                ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN estudante
                ON estudante.idEstudante = estudante_nota.idEstudante INNER JOIN estudante_disciplina
                                                                        ON estudante_disciplina.idestudante = estudante.idEstudante

                WHERE pautanormal.estado= 2 AND estudante_disciplina.iddisciplina= '$disciplina'
                                        AND tipoavaliacao.idTipoAvaliacao = '$av' AND pautanormal.idcurso = '$curso' AND estudante_disciplina.idcurso= '$curso'";

        if ($ctr==0){

            $query=$query."AND pautanormal.idPautaNormal = '$idptn'";
        }else{
            $query=$query."GROUP BY pautanormal.idPautaNormal";
        }
        return ($query);

    }

    public function novo_modelo_relatorio($ptn,$estado)
    {
        return ("SELECT estudante_nota.idNota,estudante_nota.idaluno, estudante_nota.nota,
utilizador.nomeCompleto,aluno.nr_mec as nrmec, pautanormal.idDisciplina as disp,
pautanormal.idTipoAvaliacao as tipo, pautanormal.idcurso

FROM aluno INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
					 INNER JOIN estudante_nota ON estudante_nota.idaluno = aluno.idaluno
           INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
 WHERE pautanormal.idPautaNormal = '$ptn' AND pautanormal.estado= '$estado'");
    }

    public function buscarDadosDisciplina($disciplina,$curso)
    {
        return ("SELECT DISTINCT professor.idprofessor as idDocente, utilizador.sexo, grau_academico.descricao as grauAcademico,
 curso.descricao,curso.idCurso, utilizador.nomeCompleto FROM professor
					 INNER JOIN grau_academico ON grau_academico.idGrau = professor.idgrau
					 INNER JOIN utilizador ON utilizador.id = professor.idutilizador
           INNER JOIN disciplina_curso ON disciplina_curso.idutilizador = professor.idutilizador
           INNER JOIN curso ON curso.idcurso = disciplina_curso.idcurso
WHERE disciplina_curso.iddisciplina= '$disciplina' AND disciplina_curso.idcurso= '$curso'");
    }


    public function contas_estudantes($disp,$curso , $ctr, $tipo){
        $query ="";
        if ($ctr == 1){
            $query.="SELECT COUNT(DISTINCT aluno.idaluno) as qtd   FROM aluno
INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
INNER JOIN inscricao ON inscricao.idutilizador = utilizador.id
INNER JOIN turma ON turma.idturma = inscricao.idturma
WHERE turma.idcurso = '$curso' AND inscricao.iddisciplina= '$disp'";
        }

        if ($ctr == 2){
            $query.="SELECT COUNT(DISTINCT aluno.idaluno) as qtd FROM aluno
INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
INNER JOIN inscricao ON inscricao.idutilizador = utilizador.id
INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina = '$disp'";
        }

        if (($ctr == 3) && ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT aluno.idaluno) as qtd   FROM aluno
INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
INNER JOIN inscricao ON inscricao.idutilizador = utilizador.id
INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao

WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina = '$disp' AND pautanormal.idTipoAvaliacao= '$tipo'";
        }

        if (($ctr == 4 )&& ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante_nota.idaluno) as qtd FROM estudante_nota
WHERE estudante_nota.idaluno NOT IN(

 SELECT estudante_nota.idaluno FROM estudante_nota
         INNER JOIN pautanormal ON pautanormal.idPautaNormal = estudante_nota.idPautaNormal
          WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina = '$disp' AND pautanormal.idTipoAvaliacao= '$tipo')";
        }


        if (($ctr == 5) && ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante_nota.idaluno) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = '$tipo'
AND estudante_nota.nota >= 10;";
        }

        if (($ctr== 6 )&& ($tipo == 4 || $tipo== 5)){
            $query.="SELECT COUNT(DISTINCT estudante_nota.idaluno) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = '$tipo'
AND estudante_nota.nota = 0;";
        }

        if (($ctr == 7) && ($tipo == 4 || $tipo== 5) ){

            $query.="SELECT COUNT(DISTINCT estudante_nota.idaluno) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina='$disp' AND pautanormal.idTipoAvaliacao = 5
AND estudante_nota.nota < 10;";

        }

        if (($ctr== 8)){

            $query.="SELECT COUNT(DISTINCT estudante_nota.idaluno) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao > 3
AND estudante_nota.nota >= 10;";
        }

        if (($ctr== 9)){

            $query.="SELECT COUNT(DISTINCT estudante_nota.idaluno) as qtd FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao > 3
AND estudante_nota.nota < 10;";
        }

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['qtd']);
        }
    }
    public function contar_media($curso, $disp , $ctr)
    {
        $query ="SELECT  DISTINCT AVG(estudante_nota.nota) as media, estudante_nota.idaluno from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                        INNER JOIN inscricao ON disciplina.idDisciplina = inscricao.iddisciplina
                        INNER JOIN turma ON turma.idturma = inscricao.idturma
                        INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
                        WHERE disciplina.idDisciplina = '$disp'
                        AND pautanormal.estado= 2 AND pautanormal.idcurso= '$curso' AND tipoavaliacao.idTipoAvaliacao < 4
GROUP BY estudante_nota.idEstudante";

        $cota =0;
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        while ($row = mysqli_fetch_assoc($result)){
            if ($row['media'] >=16 && $ctr== 1){$cota++;} // dispensados
            if ($row['media'] < 10 && $ctr== 2){$cota++;} // excluidos
            if ($row['media'] >= 10 && $row['media'] < 16 && $ctr== 3 ){$cota++;} // admitidos do exame normal
        }
        return $cota;
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


    public function returnMediaEstudante($idEst, $disp, $curso)
    {
        $q="SELECT  DISTINCT AVG(estudante_nota.nota) as media, estudante_nota.idaluno from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                        INNER JOIN inscricao ON disciplina.idDisciplina = inscricao.iddisciplina
                        INNER JOIN turma ON turma.idturma = inscricao.idturma
                        INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disp' AND
estudante_nota.idaluno = '$idEst' AND pautanormal.idcurso= '$curso' AND data_avaliacao.id_data < 4
GROUP BY estudante_nota.idaluno";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $q);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['media']);
        }

    }

    public function validar_busca_recorrencia($aluno, $disp, $curso, $tipo)
    {
        $query ="SELECT estudante_nota.nota FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = '$tipo'
AND estudante_nota.nota >= 10 AND estudante_nota.idaluno = '$aluno';";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['nota']);
        }

    }

    public function aprovados_exa_nor($curso, $disp)
    {
        $query = "SELECT estudante_nota.nota, estudante_nota.idaluno as id FROM estudante_nota
          INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
          WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp'
          AND pautanormal.idTipoAvaliacao = 4
          AND estudante_nota.nota >= 10";

        return ($query);

    }

    public function aprovados_exa_rec($curso, $disp)
    {
        $query = "SELECT estudante_nota.nota, estudante_nota.idaluno as id FROM estudante_nota
INNER JOIN pautanormal ON pautanormal.idPautaNormal=estudante_nota.idPautaNormal
WHERE pautanormal.idcurso = '$curso' AND pautanormal.idDisciplina= '$disp' AND pautanormal.idTipoAvaliacao = 5
AND estudante_nota.nota >= 10";

        $estudante = new EstudantesSQL();
        $ex_nor = $estudante->aprovados_exa_nor($curso, $disp);
        $db = new mySQLConnection();
        $conta=0;

        $result = mysqli_query($db->openConection(), $query);
        $res = mysqli_query($db->openConection(), $ex_nor);

        while ($row = mysqli_fetch_assoc($result)){

            while ($vetor = mysqli_fetch_assoc($res)){
                if ($row['nota'] < 10 && $vetor['nota'] >= 10 && $vetor['id'] == $row['id']){
                    $conta++;
                } }
        }return $conta;
    }

    public function list_estudante_disciplina($curso, $nome){
        return "SELECT DISTINCT aluno.idaluno, aluno.nome FROM estudante
                INNER JOIN utilizador ON utilizador.id = aluno.idaluno
                INNER JOIN  inscricao ON inscricao.idutilizador = utilizador.id
                INNER JOIN turma ON turma.idturma = inscricao.idturma
                WHERE turma.idcurso = '$curso' AND utilizador.nomeCompleto LIKE '$nome'";
    }

    public function count_estudante (mySQLConnection $db){

        $sql ="SELECT count(inscricao.idutilizador) as qtd FROM inscricao
                INNER JOIN utilizador ON utilizador.id = inscricao.idutilizador
                INNER JOIN aluno ON utilizador.id = aluno.idutilizador";

        $rs = mysqli_query($db,'select * from curso');
        while ($row = mysqli_fetch_assoc($rs)){
            echo $row['descricao'];
        }

        return 0;
    }



}