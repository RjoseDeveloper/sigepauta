﻿<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.php";
    </script>

<?php }else{

    require_once('../functions/Conexao.php');
    require_once('../controller/SexoCtr.php');
    require_once('../QuerySql/AllQuerySQL.php');
    require_once('../QuerySql/EstudantesSQL.php');
    require_once('../QuerySql/PublicacaoPautaSQL.php');
    require_once '../QuerySql/RegistoAcademicoSQL.php';
    require_once('../QuerySql/EstudantesSQL.php');
    require_once('../controller/EstudanteNotaCtr.php');
    require_once('../controller/PautaNormalCtr.php');
    require_once('../controller/EstudanteCtr.php');
    require '../requestCtr/Processa_gestao_academica.php';
    require '../functions/getRowId.php';

    $estudante_sql =  new EstudantesSQL();
    $gestao_academica = new Processa_gestao_academica();
    $ra_sql = new RegistoAcademicoSQL();
    $db = new mySQLConnection();

} ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">
    <title>Registo Academico</title>
    <style>

        ul li {cursor: pointer}
        h5{background: none; }

        .table_s{

            background:-webkit-linear-gradient(white , #ccc ,white);
            background:-ms-linear-gradient(white , #ccc ,white);
            background:-o-linear-gradient(white , #ccc ,white);
            background: -moz-linear-gradient(white , #ccc ,white);
            color:#00516e;
        }

        ul .lista_disciplinas{
            border-top: 1px solid #c6c6c6;
            padding: 8px;
        }

    </style>

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

    <script type="text/javascript" src="../js/js_estudante.js"></script>
    <script type="text/javascript" src="../js/js_function.js"></script>
    <script type="text/javascript" src="../js/js_registo_academico.js"></script>

</head>
<body>

<div data-role="page" class="" style="background: #fff">
<!--  content of menu -->
    <div data-role="content" style="padding:5px 10px">
        <div class="col-md-3">
            <ul class="list-group">

                <h4 class="list-group-item alert alert-success" style="background: #cce5ff">Estatisticas Gerais</h4>

                <li class="list-group-item" value="">
                    <a href="configAdmin/clientes.php" target="frm_content" style=""> <?php echo 'Total Estudantes';?>
                        <span class="pull-right badge"> <?php echo getCountRow('aluno','idaluno', $db) ; ?></span>
                    </a></li>

                <li class="list-group-item" value="">
                    <a href="configAdmin/professor.php" target="frm_content" style=""> <?php echo 'Total Professor';?>
                        <span class="pull-right badge"> <?php echo getCountRow('professor','idprofessor', $db) ?></span>
                    </a></li>

                <li class="list-group-item" value="">
                    <a href="configAdmin/cursos.php" target="frm_content" style=""> <?php echo 'Total Cursos';?>
                        <span class="pull-right badge"> <?php echo getCountRow('curso','idcurso', $db) ?></span>
                    </a></li>

                <li class="list-group-item" value="">
                    <a href="marksheet?opt=mngms" style=""> <?php echo 'Total Pautas';?>
                        <span class="pull-right badge"> <?php echo getCountRow('pautanormal','idPautaNormal', $db) ?></span>
                    </a></li>
            </ul>

            <div class="panel panel-warning">

                <div class="panel-heading"><?php echo 'Total de Despesas -'. date("Y");?></div>
                <div class="panel-body"><h3 class="pull-right"><?php echo getSumRow('despesa','valor', $db).',00'; ?></h3></div>
                <div class="panel-footer">Ver mais ...</div>

            </div>

            <div class="panel panel-info">

                <div class="panel-heading"><?php echo 'Total de Orçamento -'. date("Y");?></div>
                <div class="panel-body"><h3 class="pull-right"><?php echo getSumRow('orcamento','valor', $db).',00'; ?></h3></div>
                <div class="panel-footer">Ver mais ...</div>

            </div>

<!--            <div class="panel panel-default">-->
<!---->
<!--                <div class="panel-heading">--><?php //echo 'Pagamentos de Outrso Tipos de Avaliações';?><!--</div>-->
<!--                <div class="panel-body" ><h3 class="pull-right">--><?php //echo '100,00 MZN'; ?><!--</h3></div>-->
<!--                <div class="panel-footer panel-danger">Ver mais ...</div>-->
<!--            </div>-->
        </div>

        <div class="pull-right col-md-9">
            <br>

<!--            <div class="table-responsive col-md-5">-->
<!--                <div class="panel panel-success">-->
<!--                    <div class="panel-heading">Relacao Grafica de Estudantes e Professores</div>-->
<!--                    <div class="panel-body" style="height: 350px"><h3>--><?php //echo "23" ?>
<!---->
<!--                            --><?php //getCountRow('curso','idcurso', $db)?>
<!---->
<!--                        </h3>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->

            <div class="table-responsive col-md-12">

                <div class="panel panel-primary">

                    <div class="panel-heading">PEDIDOS SUBMETIDOS</div>
                    <div class="panel-body" style="height: 350px"><h3><?php echo '9000,00 MZN'; ?>

                        </h3>
                        <?php echo getCountRow('aluno','idaluno', $db)?>
                    </div>

                </div>
            </div>

            <br><br>

            <div class="table-responsive col-md-12">
                <div class=" alert alert-warning">TOTAL DE ALUNOS POR CURSO</div>
                <table class="table" style="">
                    <thead>

                        <?php
                        $lista = $gestao_academica->listarCurso($db,$ra_sql->select_curso());
                       $i=0;
                        echo '<tr>';
                        if($lista!=null){
                        foreach ($lista as $ls){ if ($ls !=null){?>
                                 <?php if ($i==0){echo '<tr>';$i++;} ?>

                                 <th style="font-size: 10px ;font: "Courier New", Courier, monospace"><?php echo $ls['descricao']  ?></th>
                                 <td><h4><span class="pull-right badge"> <?php echo get_row($ls['idcurso'], $db); ?></h4></td></td>

                            <?php }
                        }}
                        echo '</tr></tr>';
                        ?>
                    </thead>
                    </tbody>
                </table>
            </div>
            <br>
        </div> <!-- fim tabelas -- >
    </div> <!-- fim grid-->


</div>

    <script type="text/javascript">
        $(document).ready(function(){


        });
    </script>

</body>
</html>
