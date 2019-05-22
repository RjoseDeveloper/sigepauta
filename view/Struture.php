<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 2/19/2018
 * Time: 12:20 PM
 */

session_start();

require_once('../functions/Conexao.php');
require_once('../QuerySql/AllQuerySQL.php');
$db = new mySQLConnection();
$query = new QuerySql();
$idDoc = $query->getDoc_id($_SESSION['username']);
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Registar Nota</title>

    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap-theme.min.css" type="text/css"/>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap-theme.css" type="text/css"/>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css" type="text/css"/>

    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.js"></script>
    <script src="../_assets/js/jquery-1.8.3.min.js"></script>

    <script type="text/javascript" src="../libs/bootstrap/js/bootstrap.min.js"></script>
    <link href="header/css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap-select.css">
    <script src="../libs/bootstrap/js/bootstrap-select.js"></script>

    <script  src="../js/js_function.js" type="text/javascript"></script>
    <script src="../js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>
    <script src="../js/js_docente.js" type="text/javascript"></script>

    <style type="text/css">
        .modal_header{
            background-color: #007CCC; border: none;
             padding-bottom: -1em;
        }
        .modal_header h4{font-size: 12px; color: white; font-weight: bold}
        li{list-style: none;  padding: -2em;}
        .doc_ul_a{ cursor: pointer;}

    </style>

</head>
<body>

<div class="container" style="margin-top: 1em">
    <div class="jumbotron">
        <!--------   Mmostra lista de disciplina de um docente ----------------->
        <div class="container">
       </div>
    </div>

    <ul class="pager">
        <li class="previous"><a href="#">Anterior</a></li>
        <li class="next"><a href="#">Proximo</a></li>
    </ul>
</div>

<!-- Modal para controlo de erro  -->
<div class="modal fade" id="error_model" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ctr_sms" style="color: blue;">Mensagem do Sistema</h4>
            </div>
            <div class="modal-body">
                <div class="ctr_error" style="color:red; text-align: center">Caro houve problemas na insercao de </div>
            </div>
        </div>
    </div>
</div>

<script src="header/js/js_script.js"  type="text/javascript"></script>
<script src="header/js/jquery.min.js" type="text/javascript"></script>
<script src="header/js/bootstrap-select.min.js"  type="text/javascript"></script>
<script src="header/js/stickUp.min.js"  type="text/javascript"></script>
<script src="header/js/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>

<!---------------------------- FIM POPUPS  E COMEC SESSAO DE PANEL------------------------------->

</body>
</html>