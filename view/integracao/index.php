<html>

<head>

    <title>Recebendo dados do esira</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.tablesorter.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../bibliotecas/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../bibliotecas/jQuery/js/jquery-1.11.3.js"></script>
    <script src="../../bibliotecas/jQuery/js/jquery-1.8.3.min.js"></script>
    <script src="../../bibliotecas/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../bibliotecas/jQuery/js/jquery.mobile-1.4.3.min.js"></script>

    <link href="../../bibliotecas/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../bibliotecas/jQuery/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../fragments/css/estudante_style.css" type="text/css">
    <link href="../../bibliotecas/navbar/css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link href="../../bibliotecas/assets/bootstrap/js/css_mystyle.css"  rel='stylesheet' type='text/css'>
    <script type="text/javascript">

        //Chama a função tablesorter, plugin do jQuery
        $(function() {
            $("#clientes").tablesorter({
                debug: true
            });
        });


    </script>

</head>

<body align="center">

<?php


{
?>


<table id="clientes" align="center">

    <caption><h2>Lista dos estudantes</h2></caption>

    <thead>
    <tr>
        <th>Nr Mecanografico1</th>
        <th>Nome</th>
        <th>Nivel de Frequencia</th>
        <th></th>
    </tr>
    </thead>

    <tbody>

    <?php
    //Inicia a biblioteca cURL do PHP
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_PORT => "5470", //porta do WS
        CURLOPT_URL => "http://localhost:5470/WebServiceEsira/webresources/esira/Estudante/listaArray", //Caminho do WS que vai receber o GET
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
    //$clientes = $data->cliente; função de selecionar o obejto nao suportada pelo POST do WS
    $connect=mysqli_connect("localhost","root","dblinkx","pautas_fe");


    foreach ($data as $c) //cria a classe de tratamento
    {


        //Define as arrays

        $id = $c->nr_estudante;
        $nome = $c->nome_completo;
        $vlr = $c->nivel_frequencia;


       // $sql="INSERT INTO aluno(nome,nr_mec) VALUES('".$nome."','".$id."')";
       // mysqli_query($connect,$sql);
        //Formata a máscara numérica
        $valor = number_format($vlr, 2, ',', '');
        ?>

        <tr id="<?php echo $id; /*pubica as informações na tabela>*/?>">
            <td width="200px"><?php echo $id; ?></td>
            <td width="200px"><?php echo $nome; ?></td>
            <td align="right" width="180px"><?php echo $valor; ?>
        </tr>

        <?php
    }//encerra PHP do tratamento da lista
    ?>

    </tbody>

    <?php
    }//encerra PHP else
    ?>

    <tr  style="background-color: #f1f1f1">
        <td colspan="4" align="center">
            <button type="button" onclick="abrir()" class="botao" style="width: 110px; float: none;" >Cadastrar</button>
        </td>
    </tr>

</table>

</body>

</html>