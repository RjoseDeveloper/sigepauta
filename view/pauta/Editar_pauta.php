<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../../index.php";
    </script>

<?php }

require_once("../../Query/AllQuerySQL.php");
require_once("../../controller/DisciplinaCtr.php");
require_once('../../controller/EstudanteCtr.php');
require_once('../../dbconf/getConection.php');

$query = new QuerySql();
$idDoc = $query->getDoc_id($_SESSION['username']);
$db = new mySQLConnection();

$teste = FALSE;
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Nota</title>



    <?php include '../layouts/head.php' ?>

    <link   rel="stylesheet" href="../../bibliotecas/bootstrap/css/bootstrap-select.css">
    <script src="../../bibliotecas/bootstrap/js/bootstrap-select.js"></script>

    <script  src="../fragments/js/js_function.js" type="text/javascript"></script>
    <script type="text/javascript" src="../fragments/js/js_editar_pauta.js"></script>

    <style>
        .ul_li_item li {
            cursor: pointer;
            font-size: 13px;
        }
        .modal_header{
            background-color: #ccccff; border: none;
            padding-bottom: -1em;
        }

        
    </style>

</head>
<body>

<div class="container" style="margin-top: 2em">

    <h4 class="nome_e alert alert-success">Actualização de Nota ou Relatório <span class="pull-right"> &times</></h4>
    <div class="jumbotron">

        <!--------   Mmostra lista de disciplina de um docente ----------------->
        <div class="container">

            <select id="select_curso"   data-width="auto">
                <option value="" disabled="disabled" >Seleccionar Curso</option>
                <?php

                $consulta= $query->docenteCursoDisciplina($idDoc);
                $result = mysqli_query($db->openConection(), $consulta);
                while ($row = mysqli_fetch_assoc($result)) {?>
                    <option  value="<?php echo $row['idcurso']?>"><?php echo $row['descricao']?></option>
                <?php } ?>
                <option value="">...</option>

            </select>

            <!--- chama a sessao rlatorios caso acao = 10  -->
            <?php


                        if(($_SESSION['tipo'] == "dir_adjunto_pedag" && $_GET['acao'] == 10 )){
                            $teste=TRUE;
                        }else{
                            if ( ($_GET['acao'] == 2 && $_SESSION['tipo'] != "dir_adjunto_pedag") ||
                                ($_GET['acao'] == 2 && $_SESSION['tipo'] == "docente") ){
                                $teste = FALSE;
                            }}
                        ?>

                        <!--  Accao nr 2 eh referente a editar notas -->
<!--                        --><?php //if (($teste === FALSE) && ($_GET['acao'] == 10)){ ?>

                        <ul class="list-group disciplinas_doc ul_li_item">

                            <h3 class="list-group-item active"  align="right" class="nav_action" style="font-size: 13px">
                                Disciplinas Associadas ao Docente <?php echo ' - '. utf8_encode($_SESSION['nomeC'])?></h3>

                            <?php
                            $temp = $query->listaCursoDocente($idDoc);
                            foreach($temp as $next){
                                if ($next['nomeC']!= null){

                                    $disp = $query->listaDispCursoDocente($next['idC'],$idDoc);

                                    foreach($disp as $row){
                                        if ($row['nomeD']!= null){ ?>

                                            <!--Mostra opcao de impressao  relatorio para um docente normal somente disciplinas associadas -->

                                            <?php if ($_GET['acao'] == 10 && $_SESSION['tipo'] != "dir_adjunto_pedag"){?>

                                                <li class="list-group-item" value="<?php echo $row['disp']?>" onclick="mostrar_relatorio(this.value)" id="valor_disp">

                                                    <input type="hidden" name="curso_hide" value="<?php echo $next['idC']?>" id="curso_hide"/>

                                                    <?php if (($query->contaDisciplina($row['disp'], $idDoc)) > 1) {
                                                        echo '<h5 style="color:green">'.$row['nomeD'].' - '. utf8_encode($next['nomeC']).'</h5>';
                                                    }else{
                                                        echo $row['nomeD'];
                                                    }
                                                    ?>
                                                <span class="glyphicon glyphicon-chevron-right pull-right"></span> </li>

                                            <?php }else{?>

                                                <!-- Envio de parametro para acao editar, Nesta lista eh passado o ID da disciplina que sera levado apos o click na linha -->

                                                   <li class="list-group-item" value="<?php echo $row['disp']?>"
                                                       onclick="load_id_docente(this.value)">

                                                    <input type="hidden" name="curso_hide" value="<?php echo $next['idC']?>" id="curso_hide"/>

                                                    <?php if (($query->contaDisciplina($row['disp'], $idDoc)) > 1) {
                                                        echo '<h5 style="color:green">'.$row['nomeD'].' - '.utf8_encode( $next['nomeC']).'</h5>';
                                                    }else{
                                                        echo $row['nomeD'];
                                                    }?>
                                                       <span class="glyphicon glyphicon-chevron-right pull-right"></span>

                                                   </li>

                                            <?php } } } } } ?>
                                    </ul>

                            <!-- fim classe select disp  gestao de relatorios-->

<!--                            --><?php //} elseif($teste === TRUE && $_GET['acao'] == 10){ ?>
                            <br>

                            <div class="" id="show_report">

                                <?php
                                $sql = "SELECT curso.idcurso, curso.descricao from curso INNER JOIN disciplina_curso
ON curso.idcurso = disciplina_curso.idcurso INNER JOIN utilizador ON disciplina_curso.idutilizador = utilizador.id
INNER JOIN professor ON professor.idutilizador=utilizador.id
WHERE professor.idprofessor = '$idDoc'";

                                $result = mysqli_query($db->openConection(),$sql);
                                $t=0;

                                while ($row = mysqli_fetch_assoc($result)){
                                    $_SESSION['idc']=$row['idcurso'];
                                    ?>
                                    <input type="hidden" name="curso_hide" value="<?php echo $row['idcurso']?>" id="curso_hide"/>

                                    <div <?php if (mysqli_num_rows($result) > 1){?> >

                                        <h3><?php echo $row['descricao']?></h3>
                                        <?php }?>
                                        <ul class="list-group select_disp ul_li_item">

                                            <?php
                                            if (mysqli_num_rows($result) == 1){?>
                                               <li class="list-group-item active" style="text-align: right">
                                                    <?php echo'Disciplinas do Curso de '. $row['descricao']?></li>
                                            <?php }

                                            $rs= mysqli_query($db->openConection(), $query->discplinasCurso($row['idcurso']));

                                            while ($rx = mysqli_fetch_assoc($rs)) {?>

                                                <li class="list-group-item" value="<?php echo $rx['disp']?>" onclick="mostrar_relatorio(this.value)" class="valor_disp">
                                                    <?php  echo $rx['descricao'] ?> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </li>
                                            <?php }?>

                                        </ul> </div>
                                <?php  } ?>

                                <div style="" class="btn-group pull-right">
                                    <button  class="btn btn-primary btn_pauta_final">Pautas de Frequencia </button>
                                    <button  class="btn btn-primary btn_relatorio_semestral"> Relatorio Semestral</button>
                                </div>

                                <br>


                                <div class="list_pautas"></div>

                            </div>
<!--                        --><?php //}?>



                    <div  style="display: inline; float: right; margin-top: 0em;" align="center">
                        <?php if ($_GET['acao'] == 10){?>
                            <a href="#" class="btn btn-info" id="print_report" ><span class="glyphicon glyphicon-print"></span>Imprimir Relatorio</a>
                        <?php } ?>

                    </div><br>

                    <div align="center" class="sucesso"></div>
                    <input type="hidden" value="" id="idpauta"/>
                    <div style=" margin-top: -4em" class="mostrar_avaliacao"></div>
                    <br>
                </div>
        </div> </div><!--fim jumbtron -->


<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="relatorio_f" role="dialog">

        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal_header">
                    <button type="button"  style=" border: none" data-mini="true" data-inline="true"
                            class="close" data-dismiss="modal">&times;</button>

                    <h4 style="color:green" class="resumo"></h4>
                </div>

                <div class="container" ><br>

                    <input class="form-control" type="text" name="txtnomedisp" autofocus="true" value="" id="txtnomedisp" placeholder="Nome detalhado da Disciplina ..."/>
                    <br>
                    <textarea class="form-control" name="txtmetaplano" id="txtmetaplano"  placeholder="Cumprimento do Plano ..." ></textarea>
                    <br>
                    <textarea class="form-control" name="txtdetalhes" id="txtdetalhes"  placeholder="Sobre Avaliações ..." ></textarea>
                    <br>
                    <textarea class="form-control" name="txtconstrg"  id="txtconstrg"  placeholder="Constrangimentos na Disciplina ..." ></textarea>
                    <br>
                    <textarea  class="form-control" name="txtdesafios" id="txtdesafios"  placeholder="Perspectivas ou Desafios ..." ></textarea>

                </div>

                <div class="modal-footer">

                    <a href="#" class="btn btn-success" id="btn_print_rsemestral">Imprimir Relatorio</a>
                </div> <!-- fim Modal footer  -->
            </div> <!-- fim Modal content-->
        </div> <!-- fim Modal dialog -->
    </div> <!-- fim Modal fade-->
</div> <!-- fim Modal container-->

</body>
</html>
