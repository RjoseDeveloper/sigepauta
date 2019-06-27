<html>

<head>

    <?php
        include("../layouts/head.php");
        require_once 'FuncoesIntegracao.php';
        require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
        require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
    ?>


    <title>Recebendo dados do esira</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="../fragments/css/estilo.css" rel="stylesheet" type="text/css"/>
    <script src="../fragments/js/jquery.js" type="text/javascript"></script>
    <script src="../fragments/js/jquery.tablesorter.js" type="text/javascript"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.js"></script>
    <script src="../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../fragments/js/pace.min.js" type="text/javascript"></script>
    <script src="../libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="../_assets/js/jquery.mobile-1.4.3.min.js"></script>

    <link href="../libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../css/estudante_style.css" type="text/css">
    <link href="header/css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link href="header/css/css_mystyle.css"  rel='stylesheet' type='text/css'>
    <script type="text/javascript">



        //Chama a função tablesorter, plugin do jQuery
        $(function() {
            $("#clientes").tablesorter({
                debug: true
            });
        });


    </script>

    <!--    <script type="text/javascript">
            funtion gravar(){

                $sql="INSERT INTO aluno(nome,nr_mec) VALUES('".$nome."','".$id."')";
                 mysqli_query($connect,$sql);
            }
            </script>
       -->

</head>
<body>

<?php
        //Inicia a biblioteca cURL do PHP
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8084", //porta do WS
            CURLOPT_URL => "http://localhost:8084/webaplicationesira/webresources/esira/Estudante/listaArray", //Caminho do WS que vai receber o GET
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

    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax') {
?>

<div class="table-responsive container">
    <table class="table">

        <center><h2>Lista de Estudantes</h2></center>

        <DIV>
            <button data-toggle='tab' title="GUARDAR LISTA" class='btn btn-warning btn-sm'
                    onclick="botaoAlunos(1)" value="">
                <span class='glyphicon glyphicon-edit'>GUARDAR A LISTA</span>
            </button>
        </DIV>
        <br>

        <tr>
            <th>Nr Mecanografico</th>
            <th>Nome do Estudante</th>
            <th>Nivel de Frequencia</th>
        </tr>

        <?php

        foreach ($data as $c){ //cria a classe de tratamento

                //Define as arrays

                $id = $c->nr_estudante;
                $nome = $c->nome_completo;
                $vlr = $c->nivel_frequencia;

                $valor = number_format($vlr, 2, ',', '');
            ?>

            <tr id="<?php echo $id; /*pubica as informações na tabela>*/?>">
                <td><?php echo $id; ?></td>
                <td><?php echo $nome; ?></td>
                <td><?php echo $valor; ?>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php }else{
        $funcoes = new FuncoesIntegracao();
        $funcoes->listaDeAlunos($data);
     }?>
</body>
</html>