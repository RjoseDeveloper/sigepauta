<?php
class QuerySql{

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

    public function get_all_pauta($id, $status){
        return "SELECT pautanormal.idPautaNormal as pauta, data_avaliacao.descricaoteste as descricao, curso.descricao as curso,
  pautanormal.dataReg, pautanormal.dataPub, disciplina.descricao as disp, pautanormal.estado
FROM pautanormal
  INNER JOIN curso ON curso.idcurso = pautanormal.idcurso
  INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
  INNER JOIN data_avaliacao ON data_avaliacao.id_data = pautanormal.idTipoAvaliacao
WHERE  data_avaliacao.status='$status' AND pautanormal.idusers ='$id'";
    }


    public function listaDisciplina($docente, $ctr){
        $this->db = new mySQLConnection();
        $query = "SELECT DISTINCT curso.idcurso,curso.descricao as curso, disciplina.idDisciplina, disciplina.descricao
FROM disciplina INNER JOIN disciplina_curso ON disciplina.idDisciplina = disciplina_curso.iddisciplina
 INNER JOIN curso ON curso.idcurso = disciplina_curso.idcurso
 INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
 INNER JOIN professor ON professor.idutilizador = utilizador.id
WHERE professor.idprofessor = '$docente'";

        if ($ctr == 0 ){
            return ($query);
        }else{
            $result = mysqli_query($this->db->openConection(),$query);
            while($row = mysqli_fetch_assoc($result)){
                $array[] = array('disciplina'=> $row['idDisciplina'],
                    'descricao'=> $row['descricao']);
            }
            return (($array));
        }
    }

    /*Lista todos os cursos que um dado docente lecciona*/

    public function discplinasCurso($idcurso)
    {
        return ("SELECT DISTINCT disciplina.idDisciplina as disp, disciplina.descricao FROM disciplina
                 INNER JOIN disciplina_curso ON disciplina.idDisciplina = disciplina_curso.iddisciplina
                 WHERE disciplina_curso.idcurso= '$idcurso'");
    }

    public function get_Cursos()
    {
        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),"SELECT idCurso, descricao from curso");

        while ($row[] = mysqli_fetch_assoc($result)){;}
        return ($row);
    }

    function getCursoProfessor($idDoc){
        return 'SELECT curso.idcurso, descricao from curso
                  INNER JOIN disciplina_curso ON curso.idcurso = disciplina_curso.idcurso
                  INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
                  INNER JOIN professor ON utilizador.id = professor.idutilizador
                  WHERE professor.idprofessor = '.$idDoc;

    }

    public function listaCursoDocente($docente){

        $db = new mySQLConnection();

        $query= "SELECT DISTINCT curso.idcurso as idC, curso.descricao as nomeC from curso
  INNER JOIN disciplina_curso ON curso.idcurso = disciplina_curso.idcurso
  INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
  INNER JOIN professor ON utilizador.id = professor.idutilizador
WHERE professor.idprofessor='$docente'";

        $result = mysqli_query($db->openConection(),$query);

        while($array[] = mysqli_fetch_assoc($result)){
            ;
        }

        return ($array);
        $db->closeDatabase();
    }

    public function analisarDisciplina($doc,$cr,$disp)
    {
        $query ="SELECT COUNT(*) as valor FROM docentedisciplina
   WHERE docentedisciplina.idDocente= '$doc' and docentedisciplina.idDisciplina = '$disp'
 AND docentedisciplina.idCurso = '$cr'";
        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(),$query);

        if($array = mysqli_fetch_assoc($result)){
            return ($array['valor']);
        }
        $db->closeDatabase();
    }

    /*Lista todas disciplinas por cursos nas quais o docente encontra se associado*/
    public function listaDispCursoDocente($curso, $docente){

        $db = new mySQLConnection();

        $query = "SELECT DISTINCT disciplina.idDisciplina as disp,
		disciplina.descricao as nomeD from disciplina
INNER JOIN disciplina_curso ON disciplina.idDisciplina = disciplina_curso.iddisciplina
INNER JOIN curso ON curso.idcurso = disciplina_curso.idcurso
INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
INNER JOIN professor ON utilizador.id = professor.idutilizador

      WHERE disciplina_curso.idcurso = '$curso' and professor.idprofessor ='$docente'";
        $result = mysqli_query($db->openConection(),$query);

        while($array[] = mysqli_fetch_assoc($result)){
        }
        return ($array);

        $db->closeDatabase();
    }

    public function getDocenteIdCurso($disciplina, $idDocente)
    {
        $db = new mySQLConnection();

        $query = "SELECT DISTINCT curso.idcurso as idc FROM disciplina_curso
                  INNER JOIN  utilizador ON utilizador.id = disciplina_curso.idutilizador
                  INNER JOIN professor ON utilizador.id = professor.idutilizador


                 WHERE disciplina_curso.iddisciplina= '$disciplina'
                    AND professor.idprofessor = '$idDocente';";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idc'];
        }
        $db->closeDatabase();
    }

    // devolve o total de disciplna leccionado por um docente
    public function getCountDisp($curso, $docente){

        $this->db = new mySQLConnection();
        $this->query = "SELECT DISTINCT COUNT(*) as total from disciplina

                INNER JOIN docentedisciplina on docentedisciplina.idDisciplina = disciplina.idDisciplina
                INNER JOIN docente on docente.idDocente= docentedisciplina.idDocente
                INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso
                          WHERE curso.idCurso = '$curso' and docente.idDocente = '$docente'";

        $this->result = mysqli_query($this->db->openConection(),$this->query);
        if ($this->row = mysqli_fetch_assoc($this->result)){
            return ($this->row['total']);
        }else{
            return 0;
        }

        $this->db->closeDatabase();

    }

    /*This fuction return the especial the ID ofPautaNormal by passing tHE ID of nota table*/

    public function getIdPautaNormal($idNota){
        $db = new mySQLConnection();
        $query = "SELECT pautanormal.idPautaNormal FROM pautanormal INNER JOIN estudante_nota
					on pautanormal.idPautaNormal= estudante_nota.idPautaNormal
				  WHERE estudante_nota.idNota = '$idNota'";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idPautaNormal'];
        }else{
            return 0;
        }
    }


    public function getDoc_id($user){

        $db = new mySQLConnection();
        $query = "SELECT professor.idprofessor as id FROM professor INNER JOIN utilizador
ON utilizador.id= professor.idutilizador
                           WHERE utilizador.username LIKE '$user'";

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['id']);
        }else{
            return 0;
        }
    }

    public function getDoc_id_user($user){

        $db = new mySQLConnection();
        $query = "SELECT utilizador.id FROM utilizador  WHERE utilizador.username = '$user'";

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['id']);
        }else{
            return 0;
        }
    }

    public function queryAutoComplete($keyword, $curso, $disp){

        return ("SELECT DISTINCT aluno.nr_mec as numero, utilizador.nomeCompleto  FROM aluno
         INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
         INNER JOIN inscricao ON utilizador.id = inscricao.idutilizador
  WHERE inscricao.iddisciplina = '$disp' AND inscricao.idturno = '$curso'
AND utilizador.nomeCompleto LIKE '$keyword'");

    }

    public function getDisciplinaDocenteIdCurso($disp, $idDosc){
        $db = new mySQLConnection();
        $sql = "SELECT DISTINCT disciplina_curso.idcurso FROM disciplina_curso
                INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
                INNER JOIN professor ON utilizador.id = professor.idutilizador
WHERE disciplina_curso.iddisciplina = '$disp' AND professor.idprofessor= '$idDosc'";

        $result = mysqli_query($db->openConection(),$sql);
        if ($row = mysqli_fetch_assoc($result))
            return ($row['idcurso']);
    }

    public function testeAutocomplete($nrmec, $curso){


        return ("SELECT DISTINCT estudante.nrEstudante, estudante.nomeCompleto, estudante.idEstudante  FROM estudante
                     INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante
        WHERE estudante_disciplina.idcurso = '$curso' AND estudante.nrEstudante = '$nrmec';");

    }

    public function getCountEstd($disciplina){

        $this->db = new mySQLConnection();
        $this->query= "SELECT COUNT(DISTINCT estudante.nrEstudante) as conta FROM estudante
                                        INNER JOIN estudante_disciplina ON estudante.idEstudante = estudante_disciplina.idestudante
                              WHERE estudante_disciplina.iddisciplina = '$disciplina'";

        $this->result = mysqli_query($this->db->openConection(),$this->query);
        if ($this->row = mysqli_fetch_assoc($this->result)){
            echo $this->row['conta'];
        }
        $this->db->closeDatabase();
    }

    //Permite oque se obtenh o identificador da pauta normal e sera usado para insercao de pauta de recorrencia;
    public function obterIdPautaNormal($idestudante, $disciplina){

        $db = new mySQLConnection();

        $query = "SELECT DISTINCT pautanormal.idPautaNormal as idp FROM pautanormal INNER JOIN disciplina
							ON disciplina.idDisciplina = pautanormal.idDisciplina INNER JOIN estudante_nota
							ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN estudante
							ON estudante.idEstudante = estudante_nota.idEstudante

							WHERE estudante.idEstudante= '$idestudante' AND
								  disciplina.idDisciplina = '$disciplina';";
        $result = mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){
            return $row['idp'];
        }else{
            return 0;
        }

    }

    public function seletMaxIndex()
    {
        $db = new mySQLConnection();

        $query = "SELECT MAX(planoavaliacao.idPlanoAvalicacao) as max FROM planoavaliacao;";
        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return ($row['max']);
        }
    }

    public function listarPlanoActual($max)
    {

        return ("SELECT  planoavaliacao.idplano, disciplina.idDisciplina, disciplina.descricao,tipoavaliacao.descricao as tipo,tipoavaliacao.idTipoAvaliacao as av,
	        planoavaliacao.peso, planoavaliacao.qtdMaxAvaliacao as qtd
	      FROM planoavaliacao INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = planoavaliacao.idTipoAvaliacao
                INNER JOIN disciplina ON disciplina.idDisciplina = planoavaliacao.idDisciplina
                    WHERE planoavaliacao.idplano > '$max'");
    }


    public function idDocenteNome($nome)
    {

        $db = new mySQLConnection();

        $query = "SELECT docente.idDocente FROM docente WHERE nomeCompleto = '$nome'";
        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['idDocente'];
        }
        $db->closeDatabase();
    }

    public function getNome_from_ra($texto)
    {
        $query ="SELECT username FROM utilizador WHERE username LIKE '$texto'";
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['username'];
        }
        $db->closeDatabase();

    }

    public function disp_docente_json($linha){

        return ("SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao
                                from disciplina INNER JOIN docentedisciplina
                                ON docentedisciplina.idDisciplina = disciplina.idDisciplina INNER JOIN
                                docente ON docente.idDocente = docentedisciplina.idDocente WHERE
                                docente.idDocente = '$linha'");
    }

    public function listaDocentesDisciplina($idDisp)
    {
        return ("SELECT DISTINCT docente.idDocente, utilizador.nomeCompleto FROM docente INNER JOIN docentedisciplina
    ON docente.idDocente = docentedisciplina.idDocente INNER JOIN disciplina
    ON disciplina.idDisciplina = docentedisciplina.idDisciplina INNER JOIN utilizador
    ON utilizador.id = docente.idUtilizador

    WHERE disciplina.idDisciplina='$idDisp' ");

    }

    public function listDisciplinasDoente($idDoc)
    {


        return ("SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao from disciplina INNER JOIN docentedisciplina
            ON docentedisciplina.idDisciplina = disciplina.idDisciplina INNER JOIN
            docente ON docente.idDocente = docentedisciplina.idDocente WHERE
            docente.idDocente ='$idDoc'");


    }

    public function recuperar_senha($email,$fullname, $ctr)
    {

        if ($ctr == 1){

            $query ="SELECT utilizador.password FROM utilizador INNER JOIN docente
ON docente.idUtilizador = utilizador.id
                  WHERE utilizador.username ='$email'
                  AND docente.nomeCompleto ='$fullname'"; // acesso a dados docente

        }


        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){

            return ('Senha: '.$row['password']);
        }else{
            return -1;
        }

        $db->closeDatabase();
    }

    public function queryMaster($idcurso)
    {
        $db = new mySQLConnection();

        $query = "SELECT descricao from curso where idCurso= '$idcurso'";

        $result = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){
            return $row['descricao'];
        }
        $db->closeDatabase();
    }

    public function contarAvaliacoesRealizadas($avaliacao, $disciplina,$curso, $docente){

        $query = "
            SELECT COUNT(DISTINCT estudante_nota.idPautaNormal) as conta, pautanormal.idDisciplina
                  FROM pautanormal INNER JOIN estudante_nota
                    ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina INNER JOIN docentedisciplina
                    ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                    WHERE docentedisciplina.idDocente = '$docente' AND disciplina.idDisciplina = '$disciplina'
                     and pautanormal.idTipoAvaliacao = '$avaliacao' AND docentedisciplina.idCurso = '$curso'";

        $consulta = "SELECT  DISTINCT qtdMaxAvaliacao as maximo from planoavaliacao INNER JOIN disciplina
                        ON planoavaliacao.idDisciplina = disciplina.idDisciplina INNER JOIN docentedisciplina
                        ON docentedisciplina.idDisciplina = disciplina.idDisciplina

                        WHERE docentedisciplina.idDocente = '$docente' AND docentedisciplina.idCurso = '$curso'
                        and planoavaliacao.idTipoAvaliacao = '$avaliacao' and planoavaliacao.idDisciplina = '$disciplina'";

        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),$query);
        $row = mysqli_fetch_assoc($result);
        $valores = mysqli_query($db->openConection(),$consulta);
        $qtd = mysqli_fetch_assoc($valores);

        if($qtd['maximo'] ==0 && $row['conta'] ==0){
            echo "Carro docente registar plano de avaliacao primeiro";
        }else{

            return ($qtd['maximo'] - $row['conta']);
        }

        $db->closeDatabase();

    }

    public function checkExameNormalRec($tipo, $disp, $ctr){

        if ($ctr == 0 ){
            $query = "SELECT COUNT(pautanormal.idTipoAvaliacao) as tipo FROM pautanormal
				 WHERE pautanormal.idTipoAvaliacao = '$tipo' AND pautanormal.idDisciplina = '$disp'";
        }else{

            $query = "SELECT COUNT(pautanormal.idTipoAvaliacao) as tipo FROM pautanormal
				 WHERE pautanormal.idTipoAvaliacao = '$tipo'  AND pautanormal.idDisciplina = '$disp'";
        }

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row= mysqli_fetch_assoc($result)){
            return ($row['tipo']);
        }
    }
    public function allAvaliacaoDocenteDisp($docente, $disciplina)
    {
        $query ="SELECT  COUNT(DISTINCT estudante_nota.idPautaNormal) as conta, pautanormal.idDisciplina
                    FROM pautanormal INNER JOIN estudante_nota
                    ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal INNER JOIN disciplina
                    ON disciplina.idDisciplina = pautanormal.idDisciplina INNER JOIN docentedisciplina
                    ON docentedisciplina.idDisciplina = disciplina.idDisciplina
                    WHERE docentedisciplina.idDocente = '$docente' AND disciplina.idDisciplina = '$disciplina'";
        $db = new mySQLConnection();

        $result = mysqli_query($db->openConection(),$query);
        if ($row = mysqli_fetch_assoc($result)){
            return ($row['conta']);
        }
        $db->closeDatabase();
    }

    public function find_estudante_docente($username, $ctr){
        if ($ctr == 0){

            $query = "SELECT nomeCompleto, nrEstudante as numero, idEstudante FROM estudante
                    WHERE  username='$username' AND nrEstudante = 'password'";
        }else{
            $query = "SELECT username, password, idDocente, email,nomeCompleto  FROM docente
                      WHERE email = '$username'";
        }
        return ($query);
    }

    public function docenteCursoDisciplina($id)
    {
        return ("SELECT DISTINCT curso.idcurso, curso.descricao FROM curso
          INNER JOIN disciplina_curso ON curso.idcurso = disciplina_curso.idcurso
          INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
          INNER JOIN professor ON utilizador.id = professor.idutilizador
          WHERE professor.idprofessor = '$id'");

    }

    public function contaDisciplina($idDisp, $doc)
    {
        $query="  SELECT COUNT(disciplina_curso.iddisciplina) as conta, disciplina_curso.iddisciplina  FROM disciplina_curso
          WHERE iddisciplina = '$idDisp' AND disciplina_curso.idutilizador = '$doc'";

        $db = new mySQLConnection();
        $result = mysqli_query($db->openConection(), $query);
        if ($row= mysqli_fetch_assoc($result)){
            return ($row['conta']);
        }
    }

    public function get_creditos_ano($disp, $ctr) {

        if($ctr == 0){

            $query = "SELECT YEAR(disciplina.data_registo) as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
        }else{
            $query ="SELECT creditos as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
        }
        $db = new mySQLConnection();

        $result= mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){

            return ($row['valor']);
        }
    }

    public function check_publicacao ($idpauta){

        $query = "SELECT pautanormal.estado FROM pautanormal
				  WHERE pautanormal.idPautaNormal = '$idpauta'";

        $db = new mySQLConnection();

        $result= mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){

            return ($row['estado']);
        }

    }

    public function email_docente ($fullname){

        $query = "SELECT utilizador.username as email from docente INNER JOIN utilizador
		        ON docente.idUtilizador = utilizador.id
				WHERE docente.nomeCompleto = '$fullname'";

        $db = new mySQLConnection();

        $result= mysqli_query($db->openConection(), $query);

        if ($row = mysqli_fetch_assoc($result)){

            return ($row['email']);
        }

    }


    public function return_dif_data($pauta,$ctr)
    {
        if ($ctr == 0 ){
            $query ="SELECT DATEDIFF(NOW(), pautanormal.dataReg) as dif FROM pautanormal
WHERE pautanormal.idPautaNormal = '$pauta'";
        }else{
            $query ="SELECT pautanormal.idDisciplina as dif FROM pautanormal
WHERE pautanormal.idPautaNormal = '$pauta'";
        }

        $db = new mySQLConnection();
        $rs = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($rs)) {
            return ($row['dif']);
        }
    }

    public function obterPautaNormal($idnota)
    {
        $query ="SELECT pautanormal.idPautaNormal as ptn FROM pautanormal INNER JOIN estudante_nota
ON estudante_nota.idPautaNormal = pautanormal.idPautaNormal
WHERE estudante_nota.idNota = '$idnota'";
        $db = new mySQLConnection();

        $rs = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($rs)) {
            return ($row['ptn']);
        }
    }

    public function mostrar_nome_estudante($idnota)
    {
        $query ='SELECT nomeCompleto as fullname
			FROM estudante INNER JOIN estudante_nota
				ON estudante.idEstudante = estudante_nota.idEstudante
					WHERE estudante_nota.idNota = '.$idnota;

        $db = new mySQLConnection();

        $rs = mysqli_query($db->openConection(), $query);
        if ($row = mysqli_fetch_assoc($rs)) {
            return ($row['fullname']);
        }
    }

    public function disciplinas_plano($docente)
    {
        return "SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao FROM disciplina INNER JOIN
	docentedisciplina ON docentedisciplina.idDisciplina= disciplina.idDisciplina
	INNER JOIN planoavaliacao ON planoavaliacao.idDisciplina = disciplina.idDisciplina
	WHERE docentedisciplina.idDocente = '$docente'";

    }

    public function datalhes_disciplina($disp, $doc, mySQLConnection $db)
    {
        $query ="SELECT curso.descricao, disciplina.descricao as disp,
		disciplina.creditos,anolectivo.nivel, disciplina.creditos FROM disciplina
		INNER JOIN disciplina_curso ON disciplina.idDisciplina = disciplina_curso.iddisciplina
		INNER JOIN curso ON curso.idcurso = disciplina_curso.idcurso
        INNER JOIN anolectivo ON disciplina.anolectivo = anolectivo.idano
		INNER JOIN utilizador ON utilizador.id = disciplina_curso.idutilizador
		INNER JOIN professor ON utilizador.id = professor.idutilizador
		INNER JOIN turma ON curso.idcurso = turma.idcurso

		WHERE disciplina_curso.iddisciplina = '$disp'
		AND professor.idprofessor  = '$doc' GROUP BY curso.descricao";

        $t=0; $temp="";  $curso ="";  $init ="Ministrado (a) /";

        $result = mysqli_query($db->openConection(), $query);

        while ($row = mysqli_fetch_assoc($result)){
            $curso.= utf8_encode($row['nivel']) .' /'.$row['creditos'].' Creditos Academicos.';
        }
        return $init.''.$temp.' '.$curso;
    }

    /**
     * funcao retorna o nome do director adjunto pedagogico
     */

    public  function get_resp_adj_f($idf){

        $db = new mySQLConnection();
        $q = "SELECT faculdade.idDiretorAdjunto, docente.nomeCompleto FROM  faculdade
                            INNER JOIN utilizador ON utilizador.id = faculdade.idDiretorAdjunto
                            INNER JOIN docente on utilizador.id = docente.idUtilizador
                            WHERE faculdade.idFaculdade=".$idf;

        $rs = mysqli_query($db->openConection(), $q);
        while ($r=mysqli_fetch_assoc($rs)){
            return $r['nomeCompleto'];
        }
        $db->closeDatabase();
    }


}

?>
