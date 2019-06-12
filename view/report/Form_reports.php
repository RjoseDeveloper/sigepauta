<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../../index.php";
    </script>

<?php }

require_once("../../Query/AllQuerySQL.php");
require_once('../../dbconf/getConection.php');

$query = new QuerySql();
$idDoc = $query->getDoc_id($_SESSION['username']);
$db = new mySQLConnection();
$idcurso = 30; // $_SESSION['idcurso'];

$teste = FALSE;
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Nota</title>

    <?php include '../../view/layouts/head.php' ?>

    <script  src="../fragments/js/js_function.js" type="text/javascript"></script>
    <script src="../fragments/js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>
    <script  src="../fragments/js/js_editar_pauta.js" type="text/javascript"></script>

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

<div class="container" style="margin-top: 1em">

<!--    <h4 class="nome_e alert alert-success">Actualização de Dados e Relatorios <span class="pull-right"> &times</></h4>-->
    <div class="jumbotron">
        <!--------   Mmostra lista de disciplina de um docente ----------------->
        <div class="row ">

            <div class="col-md-3">

            <select id="select_curso" class="selectpicker form-control"  data-width="auto">
                <option value="" disabled="disabled" >Seleccionar Curso</option>
                <?php
                $consulta= $query->docenteCursoDisciplina($idDoc);
                $result = mysqli_query($db->openConection(), $consulta);
                while ($row = mysqli_fetch_assoc($result)) {?>
                    <option  value="<?php echo $row['idcurso']?>"><?php echo $row['descricao']?></option>
                <?php } ?>
                <option value="all">Todos os Cursos</option>
            </select>

            </div>

            <div class="col-md-3">

                <select name="ano_academico" id="ano_academico" class="selectpicker form-control col-md-4" data-width="auto">

                    <option selected="selected">Seleccionar Ano</option>
                    <?php
                    for($i = date('Y'); $i >= 2010; $i--){ ?>
                        <option value="<?php echo $i ?>"> <?php echo $i ?> </option>
                    <?php } ?>
                </select>

           </div>

            <div class="col-md-3">

            <select id="select_curso" class="selectpicker form-control"  data-width="auto">
                <option value="" disabled="disabled" >Seleccionar Turma</option>
                <?php

                $result = mysqli_query($db->openConection(), "SELECT * FROM turma WHERE turma.idcurso=".$idcurso); // usar sessio['30']
                while ($row = mysqli_fetch_assoc($result)) {?>
                    <option  value="<?php echo $row['idturma']?>"><?php echo $row['descricao']?></option>
                <?php } ?>

            </select>
                </div>
            </div>

            <!--- chama a sessao rlatorios caso acao = 10  -->
                        <ul class="list-group disciplinas_doc ul_li_item">
                            <label>Seleccionar Disciplina:</label>
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
                                            <?php if ($_SESSION['tipo'] != "coordenador" || $_SESSION['tipo'] != "dir_adjunto_pedag" ){ ?>

                                                <li class="list-group-item" value="<?php echo $row['disp']?>" onclick="mostrar_relatorio(this.value)"
                                                    id="valor_disp">

                                                    <input type="hidden" name="curso_hide" value="<?php echo $next['idC']?>" id="curso_hide"/>

                                                    <?php if (($query->contaDisciplina($row['disp'], $idDoc)) > 1) {
                                                        echo '<h5 style="color:green">'.$row['nomeD'].' - '. utf8_encode($next['nomeC']).'</h5>';
                                                    }else{
                                                        echo '<span style="color:blue">'.$row['nomeD'].'</span>';
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

                <button  class="btn btn-default btn_pauta_final">MAPA DE FREQUENCIA</button>
                <a href="2"  class="btn btn-default"  >RELATORIO DE EXAME</a>
        <a href="#"  class="btn btn-info btn_relatorio_semestral"  >RELATORIO SEMESTRAL</a>

                    </div>
                    <div align="center" class="sucesso"></div>
                    <input type="hidden" value="" id="idpauta"/>
                    <div style=" margin-top: -4em" class="mostrar_avaliacao"></div>
                    <br>
                </div>

<div class="list_pautas container"></div>


</div> <!---  container -->
<!--------Popoup modal-------->

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="popup_editar_nota" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal_header ">
                    <div class="modal-header modal_header">
                        <button type="button" style=" border: none" data-mini="true" data-inline="true"
                                class="close" data-dismiss="modal">&times;</button>
                        <h4 class="resumo" style="text-align: left; margin-top: -.3em">Adicção ou Remoção de Pautas</h4>
                    </div>
                </div>

                <div class="container"><br>

                    <h5 class="" style="text-align: left; color: green" class="text_include"></h5>
                    <div style="color: green" class="included" align="center"></div>

                    <input class="form-control" type="search" name="text_estudante" value="" id="text_estudante"
                           placeholder="Buscar estudante ... none"/><br>
                    <div class="list-group" id="resultados_e"></div>

                    <input class="form-control" type="text" name="text_nota" value="" id="text_nota" placeholder="Atribuir Nota..."/><br>
                    <textarea class="form-control" height="50" name="txtmotivo" id="txtmotivo" rows="10" cols="40"
                              placeholder="Escreva o motivo da inclusão ..." ></textarea>

                </div>

                <div class="modal-footer">

                    <div class="ctr_disp"></div>
                    <button id="btn_salvar" class="btn btn-success">Incluir <span class="glyphicon glyphicon-plus"></span></button>
                    <button id="btn_delete" class="btn btn-warning">Excluir <span class="glyphicon glyphicon-remove"></span></button>

                </div> <!-- fim Modal footer  -->
            </div> <!-- fim Modal content-->
        </div> <!-- fim Modal dialog -->
    </div> <!-- fim Modal fade-->
</div> <!-- fim Modal container-->

<!----------------------------------------------- Modal Relatorio Final -------->

<div class="container">
    <!-- Modal -->
    <div class="modal fade model-lg" id="relatorio_f" role="dialog">

        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal_header">
                    <button type="button"  style=" border: none" data-mini="true" data-inline="true"
                            class="close" data-dismiss="modal">&times;</button>

                    <h4 style="color:green" class="resumo"></h4>
                </div>

                <div class="modal-body" ><br>

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

                    <a href="#" class="btn btn-success" id = "btn_print_rsemestral">Imprimir Relatorio</a>
                </div> <!-- fim Modal footer  -->
            </div> <!-- fim Modal content-->
        </div> <!-- fim Modal dialog -->
    </div> <!-- fim Modal fade-->
</div> <!-- fim Modal container-->

</body>
</html>
