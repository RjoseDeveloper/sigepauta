﻿<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../../index.php";
    </script>

<?php }else{

    require_once('../../dbconf/getConection.php');
    require_once('../../Query/AllQuerySQL.php');
    require_once('../../Query/EstudantesSQL.php');
    require_once('../../Query/PublicacaoPautaSQL.php');
    require_once '../../Query/RegistoAcademicoSQL.php';
    require_once('../../Query/EstudantesSQL.php');
    require_once('../../controller/EstudanteNotaCtr.php');
    require_once('../../controller/PautaNormalCtr.php');
    require_once('../../controller/EstudanteCtr.php');
    require '../../requestCtr/Processa_gestao_academica.php';
    require '../classes/Functions.php';

    $estudante_sql =  new EstudantesSQL();
    $gestao_academica = new Processa_gestao_academica();
    $ra_sql = new RegistoAcademicoSQL();
    $db = new mySQLConnection();
    $func = new Functions();

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

    <?php  include '../layouts/head.php' ?>

    <script type="text/javascript" src="../fragments/js/js_estudante.js"></script>
    <script type="text/javascript" src="../fragments/js/js_function.js"></script>
    <script type="text/javascript" src="../fragments/js/js_registo_academico.js"></script>

</head>
<body>

<div data-role="page" class="" style="background: #fff">
<!--  content of menu -->
    <div data-role="content" style="padding:5px 10px">
        <div class="col-md-3">
            <ul class="list-group">

                <h4 class="list-group-item alert alert-success" style="background: #cce5ff">Estatisticas Gerais</h4>

                <li class="list-group-item" value="">
                    <a href="../aluno/alunos.php" target="frm_content" style=""> <?php echo 'Total Estudantes';?>
                        <span class="pull-right badge"> <?php echo $func->getCountRow('aluno','idaluno') ; ?></span>
                    </a></li>

                <li class="list-group-item" value="">
                    <a href="../professor/professor.php" target="frm_content" style=""> <?php echo 'Total Professor';?>
                        <span class="pull-right badge"> <?php echo $func->getCountRow('professor','idprofessor') ?></span>
                    </a></li>

                <li class="list-group-item" value="">
                    <a href="../curso/cursos.php" target="frm_content" style=""> <?php echo 'Total Cursos';?>
                        <span class="pull-right badge"> <?php echo $func->getCountRow('curso','idcurso') ?></span>
                    </a></li>

                <li class="list-group-item" value="">
                    <a href="marksheet?opt=mngms" style=""> <?php echo 'Total Pautas';?>
                        <span class="pull-right badge"> <?php echo $func->getCountRow('pautanormal','idPautaNormal') ?></span>
                    </a></li>
            </ul>

            <div class="panel panel-warning">

                <div class="panel-heading"><?php echo 'Total de Despesas -'. date("Y");?></div>
                <div class="panel-body"><h3 class="pull-right"><?php echo $func->getSumRow('despesa','valor').',00'; ?></h3></div>
                <div class="panel-footer">Ver mais ...</div>

            </div>

            <div class="panel panel-info">

                <div class="panel-heading"><?php echo 'Total de Orçamento -'. date("Y");?></div>
                <div class="panel-body"><h3 class="pull-right"><?php echo $func->getSumRow('orcamento','valor').',00'; ?></h3></div>
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
                    <div class="panel-body" style="height: 350px"><h3><?php echo 'RELACAO GRAFICA'; ?>
                        </h3>

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
                                 <td><h4><span class="pull-right badge"> <?php echo $func->get_rows($ls['idcurso']); ?></h4></td></td>

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
        $(document).ready(function(){ });
    </script>

</body>
</html>
