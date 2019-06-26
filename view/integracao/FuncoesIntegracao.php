<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/17/2019
 * Time: 2:37 PM
 */

/**
 * Esta classe trata de funcoes de integracao
 */

require_once("../../dbconf/getConection.php");

class FuncoesIntegracao {
    /**
     * constructor da classe
     */

    function _construct() {

    }

    /**
     * Funcao que actualiza ou insere registos de alunos na tabela aluno da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param list
     * @return integer
     */
    function listaDeAlunos($listaEsira) {
        $con = new mySQLConnection();
        $alunos = mysqli_query($con->openConection(), "select nr_mec from aluno");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from aluno");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];


        foreach ($listaEsira as $c) {//cria a classe de tratamento

            $id = $c->nr_estudante;
            $nome = $c->nome_completo;
            $vlr = $c->nivel_frequencia;

            while ($row = mysqli_fetch_array($alunos)) {

                $nr_mec = $row['nr_mec'];

                if ($nr_mec == $id) {
                    echo "$id <br>";
                } else {
                    //echo"inserir <br>";
                    // $sql="INSERT INTO aluno(nome,nr_mec) VALUES('".$nome."','".$id."')";
                    // mysqli_query($connect,$sql);
                }
            }
        }
        return $contador;
    }

    /**
     * Funcao que actualiza ou insere registos na tabela disciplina da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param list
     * @return integer
     */
    function listaDeDisciplinas($listaEsira) {

        $con = new mySQLConnection();
        $disciplina = mysqli_query($con->openConection(), "select codigo from disciplina");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from disciplina");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];

        foreach ($listaEsira as $c) {

            $id = $c->codigo;
            $nome = $c->nome;
            $nivel = $c->nivel;
            $vlr = $c->credito;
            $idcurso = $c->curso;

            while ($row = mysqli_fetch_array($disciplina)) {
                $codigo = $row['codigo'];

                if ($codigo == $id) {
                    echo "update <br>";
                } else {
                     //echo"inserted <br>";
                    //$sql="INSERT INTO disciplina(creditos,descricao,codigo,anolectivo,idcurso) VALUES('".$vlr."','".$nome."','".$id."','".$nivel."','".$idcurso."')";
                    //mysqli_query($connect,$sql);
                }
            }
        }
        return $contador;
    }

    /**
     * Funcao que actualiza ou insere registos na tabela curso da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param list
     * @return integer
     */
    function listaDeCursos($listaEsira) {
        $con = new mySQLConnection();
        $curso= mysqli_query($con->openConection(), "select codigo from curso");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from curso");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];

        foreach ($listaEsira as $c) {

            $codigo1 = $c->codigo_curso;
            $nome = $c->descricao;

            while ($row = mysqli_fetch_array($curso)) {
                $codigo2 = $row['codigo'];

                if ($codigo1 == $codigo2) {
                    echo "update <br>";
                } else {
                    //echo"inserted <br>";
                    //  $sql="INSERT INTO curso(descricao,codigo) VALUES('".$nome."','".$vlr."')";
                    //mysqli_query($connect,$sql);
                }
            }
        }
        return $contador;
    }

    /**
     * Funcao que actualiza ou insere registos na tabela inscricao da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param list
     * @return integer
     */
    function listaDeInscricoes($listaEsira) {

        $con = new mySQLConnection();
        $inscricao = mysqli_query($con->openConection(), "select idinscricao from inscricao");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from inscricao");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];


        foreach ($listaEsira as $c) {//cria a classe de tratamento

            $id = $c->id_disciplina;
            $nome = $c->id_estudante;
            $inscricao1 = $c->id_inscricao;

            while ($row = mysqli_fetch_array($inscricao)) {

                $inscricao2 = $row['idinscricao'];

                if ($inscricao1 == $inscricao2) {
//                    $updatae=mysqli_query($con->openConection(),"update inscricao
//                        set iddisciplina=$id
//                    where $id = inscricao.idinscricao");

                    echo "update <br>";
                } else {
                    //echo "inserted <br>";

                    //   $sql="INSERT INTO inscricao(iddisciplina,idinscricao,idutilizador) VALUES('".$id."','".$inscricao."',''".$nome."')";
                    // mysqli_query($con->openConection(),$sql);
                }

            }
        }
        return $contador;
    }
}