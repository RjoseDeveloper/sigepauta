<?php
session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.php";
    </script>


<?php }
require_once('../QuerySql/PublicacaoPautaSQL.php');
require_once('../QuerySql/PublicacaoPautaSQL.php');
require_once('../functions/Conexao.php');
require_once('../controller/EstudanteNotaCtr.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../QuerySql/AllQuerySQL.php');
require_once('../controller/EstudanteCtr.php');
require_once('../QuerySql/EstudantesSQL.php');
require_once('../controller/PautaNormalCtr.php');
require_once('../QuerySql/PublicacaoPautaSQL.php');


$query = new QuerySql();
$ctr_est = new EstudantesSQL();
$idDoc = $query->getDoc_id($_SESSION['username']);
$pautaControlle = new PublicarPauta();
$idCurso = $pautaControlle->getIdCoordenador($idDoc);
$myvar = 0;
?>


<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">

    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">
    <title>Coordenador_curso</title>

    <link href="../libs/jquery-mobile/jquery.mobile-1.0.min.css" rel="stylesheet" type="text/css"/>
    <script src="../libs/jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="../libs/jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
    <script src="../libs/jcanvas.min.js"></script>
    <script src="../_assets/js/jquery-1.7.1.min.js"></script>
    <script src="../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../_assets/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="../_assets/js/jquery-1.11.2.min.js"></script>

    <script type="text/javascript" src="../js/js_function.js"></script>
    <link rel="stylesheet" href="../css/cabecalho.css" type="text/css">
    <link rel="stylesheet" href="../css/estudante_style.css" type="text/css">
    <!----------------------------------------------------------My libs --------------------------->

    <link rel="stylesheet" href="../css/button_style.css" type="text/css">
    <script type="text/javascript" src="../js/js_coordenador_curso.js"></script>

    <!-------------------------------------------- fim -------------------------------------------->

    <style>
        body {
            font-family: serif;
            font-size: 13px;
        }

        .movie-list thead th,
        .movie-list tbody tr:last-child {
                border-bottom: 1px solid #d6d6d6; /* non-RGBA fallback */
                border-bottom: 1px solid rgba(0,0,0,.1);
        }
        .movie-list tbody th,
        .movie-list tbody td {
                border-bottom: 1px solid #e6e6e6; /* non-RGBA fallback  */
                border-bottom: 1px solid rgba(0,0,0,.05);
        }
        .movie-list tbody tr:last-child th,
        .movie-list tbody tr:last-child td {
                border-bottom: 0;
        }
        .movie-list tbody tr:nth-child(odd) td,
        .movie-list tbody tr:nth-child(odd) th {
                background-color: #eeeeee; /* non-RGBA fallback  */
                background-color: rgba(0,0,0,.04);
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

        #inputs:input{
            padding:0 30px;
            font-size: 10px;
        }
        #resultados li a{text-decoration: none;}

        .sl{

            padding: 5px 15px;
            background:#193742;
            border: none;
            border-radius:2px;
            color:white;

        }

        .texta{
            width: 70%;
            padding:25px;
            border-radius: 5px;
            font: serif;
            font-size:13px;
            border: 1.5px solid black;
        }
        .inpute{
            width: 70%;
            border-radius: 5px;
            padding: 5px;
            border: 1.5px solid black;
        };

        .marge{
            font-weight: normal; font-family: serif; font-size: 13px;
            width: 320px;
        }

    </style>
</head>
<body style="background:#ffffff">


<div data-role="page" id="pagina" style="background: #fff">

    <div data-role="content" style="margin-top: 1em; background: #fff" align="center">

        <div class="ui-corner-all custom-corners" style="width: 85%;background:none" >

            <div class="ui-bar ui-bar-a" style="border:none; border-bottom: 4px solid #ff9933; background: #ccc;" align="right">
                <!--button id="reg_pauta" data-mini="true" data-inline="true" style="float: right" data-theme="c" class="" data-icon="plus">Nova Pauta</button-->

                <h3 style="float:left; font-family:serif"><br>

                    <a  href="" data-inline="true" data-mini="true"  class="sv" id="publicar" style="font-family: serif; color:white;">Publicações</a>
                    <a  href="" data-inline="true" data-mini="true" class="sv" id="notif_inc" style="font-family: serif; color:white;">Notificações</a>
<!--                    <a  href="" data-inline="true" data-mini="true"  class="sv" id="config" style="font-family: serif; color:white;">Configurações</a>-->
                    <!--hr style="border: 2px solid #ff9933"--->

                </h3>
            </div>

            <div class="ui-body ui-body-c"> <br><br>

                <div style="width: 95%; margin-top: 1em" class="publicao_pauta">

                    <ul data-role="listview" data-filter="true" data-filter-placeholder="Buscar disciplina... nome"
                        data-inset="true" class="pautas_publicacao">
                        <li data-theme="b"><h3 align="center">Lista de Disciplinas Submetidas</h3></li>

                        <?php
                        $var =0;  $qtd=0;  $t=0;

                        $listaCurso = $pautaControlle->listapautaCurso(1, $idDoc);

                        $anolectivo = date('Y');
                        $s =  date('m') < 6 ? '1º Semestre':' 2º Semstre';
                        $scorrente = $s.' de '. $anolectivo;
                        foreach($listaCurso as $linha) {

                            if($linha != null){

                        /*-------------------------------------------*/
//
//                                ?>

                                <li value="<?php echo $linha['idcurso'] ?>" data-role="list-divider" data-theme="d" class="cursos">
                                    <div style="color:green"><?php echo $linha['curso'] ?></div>
                                    <span class="ui-li-count" data-theme="b"><?php echo $scorrente; ?>
                                </span> </li>

                                <?php $listaDisp = $pautaControlle->listaDisciplinaCurso(1,$idCurso);
                               // echo $idCurso;


                                foreach($listaDisp as $disp){

                                    if ($disp!= null){ ++$t; ?>
                                        <li value="<?php echo  $disp['ptn'] ?>" class="disciplina">
                                            <a href="#"> <img src="../_assets/img/icons-png/eye-black.png" class="ui-li-icon ui-corner-none">
                                                    <div><?php echo  $disp['descricao'] ?><?php echo '  ***  '. $disp['avaliacao'] ?></div>
                                            </a>
                                        </li>

                                    <?php } } } }?>

                        <li data-theme="e"><div align="center">Total de Avaliações  <span style="color:blue"> <?php  echo $t ?></span> </div></li>
                    </ul>

                </div>  <!--- fim controlo de publicacao --->

                <div style="width: 95%; margin-top: 1em; " class="notificacao_pauta">

                    <ul data-role="listview" data-filter="true" data-filter-placeholder="Buscar disciplina... nome"
                        data-inset="true" class="pt_inclusao">
                        <li data-theme="b"><h3 align="center">Notificações Submetidas</h3>
                        </li>

                        <?php

                        $var =0;                        $qtd=0;
                        $listaNotificacao = $pautaControlle->listar_notificacao($idCurso);

                        $anolectivo = date('Y');
                        $s= date('m') < 6 ? '1º Semestre': ' 2º  Semestre';
                        $scorrente = $s.' de '. $anolectivo;

                        /*-------------------------------------------*/
                        foreach($listaNotificacao as $linha) {

                            if ($linha != null ){ if ($var == 0){

                                ?>
                                   
                                <li value="0" data-role="list-divider" data-theme="d" class="cursos"><div style="color:green">
                                        <?php echo $linha['curso'] ?></div> <span class="ui-li-count" data-theme="b"><?php echo $scorrente; ?>
                                </span> </li>

                            <?php }  $var ++ ;  $qtd = $pautaControlle->qtdEstudantesIncluidos($linha['idpauta']);?>
                                <li value="<?php echo  $linha['idpauta'] ?>" class="disciplina">
                                    <a href="#" > <img src="../_assets/img/icons-png/check-black.png"
                                                       class="ui-li-icon ui-corner-none">

                                            <p><h6 style="font-size:12px; margin-left:2em">
                                            <?php echo  $linha['descricao'] ?></h6> <div style="font-size:10px;">
                                            <?php echo '[ '.  $qtd. ']  - ' ?>Estudante/s Incluido/s nas avaliações</div> </p>
                                    </a>
                                </li>

                            <?php }} ?>

                        <li data-theme="e"><div align="center">Total de disciplinas  <span style="color:blue"> <?php  echo $var?></span> </div></li>
                    </ul>

                </div> <!--- fim controlo de notificacao -->

            </div>

        </div>

    </div> <!--------- fim content------->

</div>

</body>
</html>

<script type="text/javascript" charset="utf-8">



</script>
