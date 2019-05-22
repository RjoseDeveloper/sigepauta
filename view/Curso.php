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
    <script src="../js/js_data_base.js" type="text/javascript"> </script>
    <script type="text/javascript" src="../js/js_registo_academico.js"></script>

    <style type="text/css">
        .modal_header{
            background-color: #007CCC; border: none;
             padding-bottom: -1em;
        }
        .modal_header h4{font-size: 12px; color: white; font-weight: bold}
        li{list-style: none;  padding: -2em;}
        .doc_ul_a{ cursor: pointer;}
        .form-control{  margin-top: 5px;  }

    </style>

</head>
<body>

<div class="container">
    <div class="jumbotron">
        <!--------   Mmostra lista de disciplina de um docente ----------------->
            <div id="g_cursos"  >

                <div class="new_curso">

                    <div class="col-sm-12" style="">
                        <div style="border: none" class="mensagem_d alert-success">Criar novo curso</div>
                        <input type="text" name="" class="form-control" id="txt_desc" placeholder="Descrição do Curso"/>
                        <input type="text" name="" class="form-control" value="" id="txt_cod" placeholder="Codigo do Curso"/>
                        <input type="search" name="" class="form-control" value="" id="txt_dir" placeholder="Director do Curso"/>

                        <div style="text-align: right" align="right">
                            <select name="select_facul"  id="select_facul" class="form-control">
                                <?php

                                $result = mysqli_query($db->openConection(), "select * from faculdade");
                                while ($row= mysqli_fetch_assoc($result)){ if ($row['idFaculdade']!= null){?>
                                    <option value="<?php echo $row['idFaculdade']?>"><?php echo $row['descricao']?></option>
                                <?php }}?>
                                        
                            </select>

                            <button data-theme="b" class="btn btn-primary"  data-mini="true" data-inline="true"
                                    style="background:#4682B4;margin-top: .5em;
  border:none; padding: 10px 50px;" value="1" class="btn  sv_curso">Registar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
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