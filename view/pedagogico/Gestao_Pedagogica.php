<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 2/19/2018
 * Time: 12:20 PM
 */

session_start();

require_once('../../dbconf/getConection.php');
require_once('../../Query/AllQuerySQL.php');
require_once '../../Query/GestaoPautasSQL.php';

$db = new mySQLConnection();
$query = new QuerySql();
$gestao_pautas = new GestaoPautasSQL();
$idDoc = $query->getDoc_id($_SESSION['username']);

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Registar Nota</title>

    <link rel="stylesheet" href="../../bibliotecas/bootstrap/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="../../bibliotecas/bootstrap/css/bootstrap.min.css" type="text/css"/>
    <link rel='stylesheet' href="../fragments/css/plano_avaliacao_style.css" type='text/css'>

    <script type="text/javascript" src="../../bibliotecas/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../bibliotecas/jQuery/js/jquery-1.11.3.js"></script>
    <script src="../../bibliotecas/jQuery/js/jquery-1.8.3.min.js"></script>
    <script src="../fragments/js/js_plano_gestao.js" type="text/javascript"></script>
    <script src="../fragments/js/js_function.js" type="text/javascript"></script>

    <link href="../../bibliotecas/navbar/css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link href="../../view/fragments/css/css_mystyle.css"  rel='stylesheet' type='text/css'>
    <link href="../fragments/css/table_style.css"  rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="../../bibliotecas/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../bibliotecas/navbar/js/templatemo_script.js"  type="text/javascript"></script>


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

<div class="container">
    <div class="jumbotronn">

        <!--------   Mmostra lista de disciplina de um docente ----------------->

        <div class="container">

            <div class="col-lg-12"><br>
                <div class="alert alert-success">Gestao de Actividades em Curso <span class="pull-right">&times</span</h4></div>
            <table class="table table-responsive" style="margin-top: .5em">
                <thead>
                <th>Data de Inicio</th>
                <th>Data de Fim</th>
                <th>Dias Restantes</th>
                <th>Actividade</th>
                <th>Operacoes</th>
                </thead>
                <tbody >
                <?php

                $resut = mysqli_query($db->openConection(),$gestao_pautas->listAll());
                while ($row = mysqli_fetch_assoc($resut)){ ?>

                <tr >
                    <td style="text-align: center"><?php echo $row['data_inicio'] ?></td>
                    <td style="text-align: center"><?php echo $row['data_fim'] ?></td>
                    <td style="text-align: center"><?php echo $row['restante'] ?></td>
                    <td style="text-align: center"><?php echo $row['descricao'] ?></td>

                    <td style="text-align: center">
                        <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button>
                        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                    </td>

                </tr>
                <?php }?>

                </tbody>
            </table>

            </div>

            <div class="col-xs-7">

                    <form action="../../requestCtr/Processa_gestao_pautas.php" method="post">

                <div class="alert alert-success sms_report" style="color:blue"><h5>Criar actividade ou tipo de avaliação</h5></div>

                <label for="datainicio">Data de Inicio:</label>
                <input type="date" name="datainicio" id="datainicio" class="form-control"/>

                <label for="datafim">Data de Final: </label>
                <input type="date" name="datafim" id="datafim" class="form-control"/>
                <label for="actividade">Indicar actividade: </label>
                <input type="text" name="actividade" id="actividade" value="" class="form-control">

                <p class="data_dinamics"></p>
                <button value="actividade" class="opt_nova_av btn btn-default pull-right"> Nova Avaliação</button>
                        <a href="#" style="margin-right: 1em" type="submit" target="content"  class="btn btn-primary pull-right">Calenderizar</a>
                </div>
                </form>

             </div>

        </div>

<!-- Modal para controlo de erro  -->

<script src="../fragments/js/js_script.js"  type="text/javascript"></script>
<script src="../../bibliotecas/jQuery/js/jquery.min.js" type="text/javascript"></script>
<script src="../../bibliotecas/bootstrap/js/bootstrap-select.min.js"  type="text/javascript"></script>
<!---------------------------- FIM POPUPS  E COMEC SESSAO DE PANEL------------------------------->
</body>
</html>

