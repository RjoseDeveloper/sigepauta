<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.php";
    </script>

<?php }

require_once('../Query/PublicacaoPautaSQL.php');
require_once('../dbconf/getConection.php');
require_once('../controller/EstudanteNotaCtr.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../Query/PautaFrequenciaSQL.php');
require_once('../controller/EstudanteCtr.php');
require_once("../Query/AllQuerySQL.php");

$publicacao_Controller = new PublicarPauta();;
$pautaFreq = new PautaFrequencia();
$query = new QuerySql();

$idptn= $_REQUEST['disp'];
$acao = $_REQUEST['acao'];

// alterado o parametro passado no get pauta normal nao disciplina
$db = new mySQLConnection();
$nome =$publicacao_Controller->pautaNormal($idptn, 0); // retorna o nome da disciplina
$curso = $publicacao_Controller->pautaNormal($idptn, 2); // o identificado do curso
$nome_disp = $pautaFreq->getnomeDisp($_REQUEST['disp']);

?>

<!DOCTYPE html><html>
<head>
    <meta charset="utf-8">
    <title>Publicacao Pauta</title>


    <link href="../view/fragments/css/table_style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../view/fragments/css/edit_pauta_style.css" type="text/css">
    <link rel="stylesheet" href="../view/fragments/css/table_style.css" type="text/css">
    <link rel="stylesheet" href="../view/fragments/css/estudante_style.css" type="text/css">
    <link rel="stylesheet" href="../view/fragments/css/cabecalho.css" type="text/css">

    <link href="../bibliotecas/jQuery/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../bibliotecas/jQuery/css/jquery.mobile.structure-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../bibliotecas/jQuery/css/jquery.mobile.theme-1.4.3.min.css" rel="stylesheet" type="text/css"/>

    <script src="../bibliotecas/jQuery/js/jquery-1.8.3.min.js"></script>
    <script src="../bibliotecas/jQuery/js/jquery.mobile-1.4.3.min.js"></script>
    <script type="text/javascript" src="../view/fragments/js/js_function.js"></script>
    <script type="text/javascript" src="../view/fragments/js/js_publicar_pauta.js"></script>
    <script src="../view/fragments/js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>

    <script src="../bibliotecas/bootstrap/js/bootstrap.min.js"></script>
    <link href="../bibliotecas/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../bibliotecas/bootstrap/css/bootstrap-select.css">
    <script src="../bibliotecas/bootstrap/js/bootstrap-select.js"></script>

    <style type="text/css" media="screen">
        body{
            font-size: 14px;
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
        }

        .botton_style {
            background: #4682B4;border:none; padding: 8px 30px;
        }

        .custom-corners .ui-bar {
            -webkit-border-top-left-radius: inherit;
            border-top-left-radius: inherit;
            -webkit-border-top-right-radius: inherit;
            border-top-right-radius: inherit;
        }
        .custom-corners .ui-body {
            border-top-width: 0;
            -webkit-border-bottom-left-radius: inherit;
            border-bottom-left-radius: inherit;
            -webkit-border-bottom-right-radius: inherit;
            border-bottom-right-radius: inherit;
        }

        .controlgroup-textinput{
                padding-top:.22em;
                padding-bottom:.22em;
        }

        .controllero_s{
            background: #6E6E6E;  border-top-left-radius: 4px; border-top-right-radius: 4px; border: none
        }

    </style>
</head>
<body>


<div data-role="page" style="background: #fff">
 <! --- fim heeader --------------->

    <div data-role="content" align="center">
        <?php if ($acao == 1){?>

                <div class="container">

                    <h4 style="color: #ff7600" > <?php echo strtoupper("PublicaÇÕes Pendentes - Disciplina de ".$nome)?> </h3>
                    <input type="hidden" value="<?php echo strtoupper($nome)?>" id="nome_dp"/>
<!--                    <div style="margin-right: -1em;"><img style="float: right;" src="../img/logo_unilurio.jpg" width="85" height="60"></div>-->
                    </h4>
                </div>

            <hr>

            <div data-role="collapsibleset" data-iconpos="left" data-theme="c"
                 data-content-theme="b" data-mini="true" style="width: 75%;">
            <?php

            $nota = '';

            $iddisp = $publicacao_Controller->pautaNormal($idptn, 1); // retorna o id da disciplina
            $listaAvliacao = $publicacao_Controller->listaAvaliacaoDisciplina(1,$iddisp, $curso,$idptn);

            //echo $listaAvliacao;

            $result = mysqli_query($db->openConection(),$listaAvliacao);

            if (mysqli_num_rows($result) <= 0){
                echo 'Nenhuma Avaliação Submetida ';
                echo '<a style="color:white" href="../view/pedagogico/Direcao.php" target="frm_content" class="ui-body-b btn btn-success">Voltar </a>';
            }else{

                while ($mylista = mysqli_fetch_assoc($result)){
                    $tipo = $mylista['avaliacao'];

                    ?>
                    <div  data-role="collapsibleset" data-theme="b">
                        <ul data-role="listview"  data-inset="false" class="lista_view">
                            <li  style="background: #848484; border: none">
                                    <span class="pull-left"><?php echo  $mylista['avaliacao']?>
                                    </span>/&nbsp;&nbsp;<span style="text-align: center">CLASSIICAÇÃO OBTIDA POR ESTUDANTE</span> <span class="pull-right">
                            <?php echo ' Data de Registo:  '. $mylista['dataReg'] ?></span>
                                </li>

                            <div class="" class="table">
                            <table id="tblData" class="table" style="">

                                <tbody>

                            <?php
                                $listaNota = $publicacao_Controller->listaNotaEstudante($iddisp,$mylista['ptn'],$mylista['idcurso'],1);
                                $t=0;
                                foreach($listaNota as $myNota){

                                if ($myNota!= null){?>

                                <tr>
                                    <td align="center"><?php echo $myNota['nrEstudante'] ?></td>
                                <td><?php echo  $myNota['nomeCompleto']?></td>
                                    <td><?php echo  $myNota['nota'] ?></td>

                                    </tr>

                                <?php }   } ?>

                                </tbody>
                            </table>
                           </div>

                        </ul>
                        <div style="float: right">

                        <button data-theme="a" data-inline="true" data-mini="true"
                                onclick="publicar(<?php echo $mylista['ptn']?>)"> Publicar Pauta</button>
                        </div>

                    </div>
                <?php  }?>
                </div> <!--- end of collabset--->


                <!-----------------------------Funcao controlar iclusao estudante----------------------------->


            <?php } }else{?>

            <div style="width: 80%">

                <div class="ui-bar ui-bar-a headers" style=" background: none; width: 85%;
                border:none;border-bottom:4px solid #ff9933 ">


                        <h3 style="float: left; margin-left: -.8em; color:green; font-size: 16px;">
                            Notificaçoões Pendentes - Inclusão de Estudante(es) da Disciplina de <?php echo strtoupper($nome_disp)?></h3>
                        <input type="hidden" value="<?php echo strtoupper($nome_disp)?>" id="nome_dp"/>

<!--                        <div style="margin-right: -1em;"><img style="float: right;" src="../img/logo_unilurio.jpg" width="90" height="60"></div>-->
                        </h3>
                </div>

                <h3 class="sucesso_include" style="color:blue" align="center"></h3>

                <table data-role="table" id="table-custom-2"
                       class="ui-body-d ui-shadow table-stripe ui-responsive">
                    <thead>

                    <tr class="ui-bar-b" style="background: #4682B4; font-size: 14px; border: none;
                    color:white" align="center">

                        <th align="center" >Codigo Aluno</th>
                        <th >Nome Completo</th>
                        <th >Tipo de Avaliação</th>
                        <th ><div align="center">Classificação Atribuida</div></th>
                        <th style="text-align: center" >Data de Registo</th>
                        <th style="text-align: center" >Comentario</th>
                        <th style="text-align: center" >Operações</th>

                    </tr>
                    </thead>
                    <tbody style="font-size: 13px" align="center" id="remove_tr">

                    <?php

                    $lista_inclusao = $publicacao_Controller->listarInclusao($idptn);
                    foreach($lista_inclusao as $row){ if ($row != null){

                        ?>
                        <tr class="operacao_include">

                            <td ><?php echo $row['nr_estudante']?>
                                <input id="campo_nrmec" type="hidden" value="<?php echo $row['nr_estudante']?>"/></td>
                            <td id="campo_fullname"><?php echo $row['nomeCompleto']?></td>

                            <td><?php echo $row['avaliacao']?></td>

                            <td style="text-align: center" id="campo_nota"><?php echo $row['nota']?>
                                <input id="campo_pauta_id" type="hidden" value="<?php echo $row['idpauta']?>"/></td>

                            <td style="text-align: center"><?php echo $row['data_reg']?></td>

                            <td align="justify" style="color: green; font-weight: bold; text-align: right"><?php echo $row['comentario']?></td>

                            <td style="text-align: right">
                                <button data-theme="b" data-inline="true" data-mini="true"
                                        style="background: #007CCC; border: none; padding: 6px 20px;"
                                        id="btn_include" value="<?php echo $row['id']?>"
                                        onclick="aceitar_inclusao(this.value)" >Aceitar</button>
                                <input id="campo_id" type="hidden" value="<?php echo $row['id']?>"/>

                                <button data-theme="b" data-inline="true" data-mini="true"
                                        style="background: #00516e;border: none; padding: 6px 20px;"
                                        id="btn_reject" value="<?php echo $row['id'] ?>"
                                        onclick="rejeitar_inclusao(this.value)" >Notificar</button></td>

                        </tr>

                    <?php } }?>

                    </tbody>

                </table>

            </div>

        <?php } ?>
        <!-----------------------------Fim controlar iclusao estudante----------------------------->
    </div> <!--- end of content--->

    <!--div data-role="footer" data-position="fixed"  align="center">

       <h3>esimop.unilurio.ac.mz</h3>

    </div-->
    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">

            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-header controllero_s ui-body-b">

                        <button type="button"  style=" border: none" data-mini="true" data-inline="true"
                                class="close" data-dismiss="modal">&times;</button>

                        <h5 class="notificar" style="color:white; text-align: left">Emitir Notificação - <?php echo $publicacao_Controller->getNomeDsciplina($idptn)?> </h5>
                    </div>

                    <div class="ui-contain" style="padding: 10px 25px" align="right">

                        <?php
                        $t=0;
                        $sql = $query->listaDocentesDisciplina($idptn);
                        $result = mysqli_query($db->openConection(), $sql);

                        $var = "Docente/s da Disciplina";
                        $texto ="";

                        while ($row = mysqli_fetch_assoc($result)){ if ($t > 1){echo " , ";} $t++?>

                            <?php $texto.=$row['nomeCompleto'].',  ' ?>

                        <?php }?><br>

                        <h5 style="color:#008000"><?php echo $var.': '.$texto; ?></h5>

                        <input type="email" data-theme="a" class="inpute ui-bar-b" name="txtemail1"
                               placeholder="Endereco electronico ..." value="" id="txtemail1"/>

                        <input type="password" data-theme="a" class="inpute ui-bar-b" name="txtsenha1"
                               placeholder="Palavra passe ..." value="" id="txtsenha1"/>

            <textarea data-mini="true" style="height:100px" data-theme="a" class="texta"
                      placeholder="Escreva a Mensagem..." name="txtarea" id="txtarea"></textarea><br>

                        <div id="resultados"></div>

                    </div>

                    <!-- Mostra o resultado da tabela no controllero -->

                    <div class="modal-footer ">

                        <a class="btn btn-danger sm ui-body-b" data-mini="true"
                           onclick="send_email(<?php echo $_GET['disciplina']?>)"style="color:white">Enviar</a>

                    </div> <!-- fim Modal footer  -->

                </div> <!-- fim Modal content-->
            </div> <!-- fim Modal dialog -->
        </div> <!-- fim Modal fade-->
    </div> <!-- fim Modal container-->



    <!---------------------------------Pagina de Notificacao  ?disp=<?php echo $idptn ?>------------------------------->
    <div data-role="popup" id="pageM" style="width: 500px" data-dismissible="false">

        <div  style="margin-left: 1em; margin-right: 1em"  align="left">
            <h5 class="notificar" style="color:blue;">Emitir Notificação - <?php echo $publicacao_Controller->getNomeDsciplina($idptn)?> </h5>
            <hr style="border:1px solid red;">
        </div>

        <div data-role="content" align="center">


            <?php
            $t=0;

            $proc = $query->listaDocentesDisciplina($idptn);
            $result = mysqli_query($db->openConection(), $proc);

            $var = "Docente/s da Disciplina";
            $texto ="";

            while ($row = mysqli_fetch_assoc($result)){ if ($t > 1){echo " , ";} $t++?>

                <?php $texto.=$row['nomeCompleto'].',  ' ?>

            <?php }?><br>

            <h5 style="color:#008000"><?php echo $var.': '.$texto; ?></h5>

            <input type="email" data-theme="a" class="inpute ui-bar-b" name="e-mail"
                   placeholder="Endereco electronico ..." value="" id="e-email"/>

            <input type="password" data-theme="a" class="inpute ui-bar-b" name="txtsenha"
                   placeholder="Palavra passe ..." value="" id="txtsenha"/>

            <textarea data-mini="true" style="height:100px" data-theme="a" class="texta"
                      placeholder="Escreva a Mensagem..." name="txtarea" id="txtarea"></textarea><br>

            <div id="resultados"></div>

        </div>

        <div data-role="footer" align="right">

            <button data-mini="true" onclick="send_email(<?php echo $_GET['disciplina']?>)"
                    data-theme="b" data-inline="true" style="padding: 8px">Enviar a Mensagem</button>

        </div>

        <a href="#" id="close_g1" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-b
          ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>

    </div>


</div>


</body>
</html>

<script type="text/javascript">

</script>