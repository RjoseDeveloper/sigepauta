<html>

<head>

    <?php
        include("../layouts/head.php");
        require_once 'FuncoesIntegracao.php';
        require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
        require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
        include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
        require_once("../../Query/DocenteSQL.php");
    ?>

    <title>Recebendo dados do esira</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!--  <link href="css/estilo.css" rel="stylesheet" type="text/css"/> -->
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.tablesorter.js" type="text/javascript"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.js"></script>
    <script src="../_assets/js/jquery-1.8.3.min.js"></script>
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

</head>

<body>


    <?php
    //Inicia a biblioteca cURL do PHP
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_PORT => "8084", //porta do WS
        CURLOPT_URL => "http://localhost:8084/webaplicationesira/webresources/esira/Inscricao", //Caminho do WS que vai receber o GET
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

        include '../ajax/pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 4; //how much records you want to show
        $adjacents = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $numrows = count($data);
        $total_pages = ceil($numrows / $per_page);
        $reload = 'integracao.php';
        //main query to fetch the data

        //loop through fetched data
        if ($numrows > 0) { ?>

            <div class="table-responsive container">
                <table class="table">
                    <center><h2>Lista de Inscricao</h2></center>

                    <DIV>
                        <button data-toggle='tab' title="GUARDAR" class='btn btn-warning btn-sm'
                                onclick="botaoInscricoes(1)" value="">
                            <span class='glyphicon glyphicon-edit'>GUARDAR A LISTA</span>
                        </button>
                    </DIV>
                    <br>
                    <tr>
                        <th>Codigo da Disciplina</th>
                        <th>Nome do Estudante </th>
                        <th>Codigo da Inscricao </th>
                    </tr>

                    <?php foreach ($data as $c) {

                        $id = $c->id_disciplina;
                        $nome = $c->id_estudante;
                        $inscricao = $c->id_inscricao;
                        ?>

                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $inscricao; ?></td>

                        </tr>

                    <?php } ?>


                <tr>
                    <td colspan=8>
                        <span class="pull-right">
					        <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </span>
                    </td>
                </tr>

            </table>
            </div>
        <?php } ?>

    <?php } else {
                $funcoes = new FuncoesIntegracao();
                $funcoes->listaDeInscricoes($data);


    }?>
</body>
</html>