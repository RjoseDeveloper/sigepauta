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

require_once'C:\xampp\htdocs\sigepauta\dbconf\getConection.php';

class FuncoesIntegracao {
    /**
     * constructor da classe
     */
    
    private $BASE_WS ="http://localhost:8084/webaplicationesira/webresources/esira/";
    private $PORT_WS ="8084";

    function _construct() {

    }

    function buscarDadosNoEsiraEstudante(){
        //Inicia a biblioteca cURL do PHP
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $this->PORT_WS, //porta do WS
            CURLOPT_URL => $this->BASE_WS."Estudante/listaArray", //Caminho do WS que vai receber o GET
            CURLOPT_RETURNTRANSFER => true, //Recebe resposta
            CURLOPT_ENCODING => "JSON", //Decodificação
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET", //metodo do servidor
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        )); //recebe retorno
        $data1 = curl_exec($curl); //Recebe a lista no formato jSon do WS
        curl_close($curl); //Encerra a biblioteca
        $data = json_decode($data1); //Decodifica o retorno gerado no modelo jSon

        return $data;
    }

    function buscarDadosNoEsiraDisciplina(){
        //Inicia a biblioteca cURL do PHP
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $this->PORT_WS, //porta do WS
            CURLOPT_URL => $this->BASE_WS."Disciplinas", //Caminho do WS que vai receber o GET
            CURLOPT_RETURNTRANSFER => true, //Recebe resposta
            CURLOPT_ENCODING => "JSON", //Decodificação
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET", //metodo do servidor
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        )); //recebe retorno
        $data1 = curl_exec($curl); //Recebe a lista no formato jSon do WS
        curl_close($curl); //Encerra a biblioteca
        $data = json_decode($data1); //Decodifica o retorno gerado no modelo jSon

        return $data;
    }

    function buscarDadosNoEsiraCurso(){
        //Inicia a biblioteca cURL do PHP
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $this->PORT_WS, //porta do WS
            CURLOPT_URL => $this->BASE_WS."Cursos", //Caminho do WS que vai receber o GET
            CURLOPT_RETURNTRANSFER => true, //Recebe resposta
            CURLOPT_ENCODING => "JSON", //Decodificação
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET", //metodo do servidor
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        )); //recebe retorno

        $data1 = curl_exec($curl); //Recebe a lista no formato jSon do WS
        curl_close($curl); //Encerra a biblioteca
        $data2 = json_decode($data1); //Decodifica o retorno gerado no modelo jSon

        return $data2;
    }

    function buscarDadosNoEsiraInscricao(){
        //Inicia a biblioteca cURL do PHP
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => $this->PORT_WS, //porta do WS
            CURLOPT_URL => $this->BASE_WS."Inscricao", //Caminho do WS que vai receber o GET
            CURLOPT_RETURNTRANSFER => true, //Recebe resposta
            CURLOPT_ENCODING => "JSON", //Decodificação
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET", //metodo do servidor
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        )); //recebe retorno
        $data1 = curl_exec($curl); //Recebe a lista no formato jSon do WS
        curl_close($curl); //Encerra a biblioteca
        $data = json_decode($data1); //Decodifica o retorno gerado no modelo jSon

        return $data;
    }

    /**
     * Funcao que actualiza ou insere registos de alunos na tabela aluno da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param mixed
     * @return integer
     */
    function listaDeAlunos($listaEsira) {

        $con = new mySQLConnection();
        $alunos = mysqli_query($con->openConection(), "select nr_mec from aluno");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from aluno");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];
        $cont_up=0;
        $cont_ins=0;

        while ($row = mysqli_fetch_array($alunos)) {
            $nr_mec = $row['nr_mec'];
            $dados[]=$nr_mec;
        }

        $cont=0;

        foreach ($listaEsira as $c) {//cria a classe de tratamento

            $id = $c->nr_estudante;
            $nome = $c->nome_completo;
            $vlr = $c->nivel_frequencia;

            //echo "<br>".$id."<br>";

            foreach($dados as $nr_mec) {

                //echo $nr_mec." ";

                if ($nr_mec === $id) {

                    $update = "update aluno set nome = '$nome' where '".$nr_mec."' = '".$id."'";
                    mysqli_query($con->openConection(), $update);

                    $cont++;
                    $cont_up++;
                    break;
                }
            }

            if($cont == 0 ){
                $sql="INSERT INTO aluno(nome,nr_mec) VALUES('".$nome."','".$id."')";
                mysqli_query($con->openConection(),$sql);
                $cont_ins++;
            }
            $cont=0;
        }

        $con->closeDatabase();
        //$this->message($cont_up,$cont_ins);
        return $contador;
    }

    /**
     * Funcao que actualiza ou insere registos na tabela disciplina da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param mixed
     * @return integer
     */
    function listaDeDisciplinas($listaEsira) {

        $con = new mySQLConnection();
        $disciplina = mysqli_query($con->openConection(), "select codigo from disciplina");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from disciplina");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];
        $cont_up=0;
        $cont_ins=0;

        while ($row = mysqli_fetch_array($disciplina)) {
            $cod = $row['codigo'];
            $dados[] = $cod;
        }
        $cont=0;

        foreach ($listaEsira as $c) {

            $id = $c->codigo;
            $nome = $c->nome;
            $nivel = $c->nivel;
            $credt = $c->credito;
            $idcurso = $c->curso;

            //echo "<br>".$id."<br>";

            foreach ($dados as $codigo) {

                $cod=0;
                $cod = $cod.$codigo;

                //echo $cod." ";

                if ($codigo == $id) {

                    $update1 = "update disciplina set creditos='$credt' where '".$cod."' = '".$id."'";
                    $update2 = "update disciplina set descricao='$nome' where '".$cod."' = '".$id."'";
                    $update3 = "update disciplina set anolectivo='$nivel' where '".$cod."' = '".$id."'";

                    mysqli_query($con->openConection(), $update1);
                    mysqli_query($con->openConection(), $update2);
                    mysqli_query($con->openConection(), $update3);

                    $cont++;
                    $cont_up++;
                    break;
                }
            }

            if($cont==0){
                $sql="INSERT INTO disciplina(creditos,descricao,codigo,anolectivo,idcurso) 
                  VALUES('".$credt."','".$nome."','".$id."','".$nivel."','".$idcurso."')";
                mysqli_query($con->openConection(),$sql);
                $cont_ins++;
            }
            $cont=0;
        }

        $con->closeDatabase();
        //$this->message($cont_up,$cont_ins);
        return $contador;
    }

    /**
     * Funcao que actualiza ou insere registos na tabela curso da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param mixed
     * @return integer
     */
    function listaDeCursos() {

        $listaEsira= $this->buscarDadosNoEsiraCurso();

        $con = new mySQLConnection();
        $curso= mysqli_query($con->openConection(), "select codigo from curso");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from curso");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];
        $cont_ins=0;
        $cont_up=0;
        $cont=0;

        while ($row = mysqli_fetch_array($curso)) {
            $cod = $row['codigo'];
            $dados[] = $cod;
        }

        foreach ($listaEsira as $c) {
            $vlr = $c->codigo_curso;
            $nome = $c->descricao;

            //echo "<br>".$vlr."<br>";

            foreach ($dados as $codigo2){

                //echo $codigo2." ";

                if ( $vlr===$codigo2 ) { //verifcando se sao do mesmo tipo e tem mesmo valor

                    $update = "update curso set descricao='$nome' where '".$vlr."' = '".$codigo2."'";
                    mysqli_query($con->openConection(), $update);
                    $cont_up++;
                    $cont++;
                    break;
                }
            }

            if( $cont==0 ){
                $sql="INSERT INTO curso(descricao,codigo) 
                    VALUES('".$nome."','".$vlr."')";
                mysqli_query($con->openConection(),$sql);
                $cont_ins++;
            }

            $cont=0;
        }

        $con->closeDatabase();
        //$this->message($cont_up,$cont_ins);
        return $contador;
    }

    /**
     * Funcao que actualiza ou insere registos na tabela inscricao da base de dados do sigepauta e
     * retorna a quantidade de registos antes de sofrer modificacao
     * @param mixed
     * @return integer
     */
    function listaDeInscricoes($listaEsira) {

        $con = new mySQLConnection();
        $inscricao = mysqli_query($con->openConection(), "select idinscricao from inscricao");

        $consulta= mysqli_query($con->openConection(),"select count(*) as nrDeRegistos from inscricao");
        $linhas = mysqli_fetch_array($consulta);
        $contador = $linhas['nrDeRegistos'];


        while ($row = mysqli_fetch_array($inscricao)) {
            $inscricao2 = $row['idinscricao'];
            $dados[] = $inscricao2;
        }

        $cont_up=0;
        $cont_ins=0;
        $cont=0;

        foreach ($listaEsira as $c) {//cria a classe de tratamento

            $id = $c->id_disciplina;
            $nome = $c->id_estudante;
            $inscricao1 = $c->id_inscricao;

            foreach ($dados as $inscricao2){

                if ($inscricao1 == $inscricao2) {

                    $update1 = "update inscricao set iddisciplina='$id' where '".$inscricao1."' = '".$inscricao2."'";
                    $update2 = "update inscricao set idutilizador='$nome' where '".$inscricao1."' = '".$inscricao2."'";

                    mysqli_query($con->openConection(), $update1);
                    mysqli_query($con->openConection(), $update2);

                    $cont++;
                    $cont_up++;
                    break;
                }
            }

            if( $cont == 0 ){
                $sql="INSERT INTO inscricao(iddisciplina,idinscricao,idutilizador) VALUES('".$id."','".$inscricao1."','".$nome."')";
                mysqli_query($con->openConection(),$sql);
                $cont_ins++;
            }
            $cont=0;
        }

        $con->closeDatabase();
        //$this->message($cont_up,$cont_ins);
        return $contador;
    }

    function message($update, $insert){

        $messages2[] = "$insert REGISTO(S) FOI(RAM) INSERIDO(S) COM SUCESSO!!!.<br>.<br>";
        $messages1[] = "$update REGISTO(S) FOI(RAM) ACTUALIZADO(S) COM SUCESSO!!!.<br>.<br>";
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Operação Efectuada: </strong><br><br>

            <?php
            if($update != 0) {
                foreach ($messages1 as $message) {
                    echo $message;
                }
            }else{

                echo"NENHUMA ACTUALIZACAO FOI FEITA!!!.<br>.<br>";
            }
            if($insert != 0){
                foreach ($messages2 as $message) {
                    echo $message;
                }
            }else{
                echo"NENHUMA INSERCAO FOI FEITA!!!.<br>.<br>";
            }
            ?>
        </div>

        <?php
    }
}