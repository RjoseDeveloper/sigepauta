<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 20-Sep-15
 * Time: 6:08 AM
 */

    session_start();

if (!isset($_SESSION['username'])){?>

    <script>
        window.location="index.php";
    </script>

<?php }else{
    require_once('../../dbconf/getConection.php');
    require_once '../../Query/AllQuerySQL.php';
    $db = new mySQLConnection();
    $query = new QuerySql();

    $idDoc = $query->getDoc_id($_SESSION['username']);
    $myvar = 0;
?>
<!doctype html>
<html >
<head>

    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">
    <meta charset=utf-8 />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Plano de Avaliacao</title>

    <?php include '../layouts/head.php' ?>

    <link rel='stylesheet' href="../fragments/css/plano_avaliacao_style.css" type='text/css'>
    <link rel="stylesheet" href="../fragments/css/table_style.css" type="text/css">
    <script src="../fragments/js/js_function.js" type="text/javascript"></script>
    <script src="../fragments/js/js_plano_avaliacao.js" type="text/javascript"></script>
     <link href="../fragments/css/css_mystyle.css"  rel='stylesheet' type='text/css'>

</head>

<body>

    <div class="container">
        <div class="jumbotron" style="background: #e4e4e4">
            <div class="container">
            <div class="col-md-7">

                <label>Seleccionar Disciplina:</label>
                <ul class="list-group docente_disp">

                    <div class="list-group-item active">Lista de Disciplinas - <?php echo utf8_encode($_SESSION['nomeC']) ?></div>
                    <?php
                    $result = mysqli_query($db->openConection(),$query->listaDisciplina($idDoc, 0));?>
                    <?php
                    while ($row= mysqli_fetch_assoc($result)){?>
                        <li class="list-group-item"  value="<?php echo $row['idDisciplina']?>"  onclick="buscar_disp(this.value)">
                            <?php echo $row['descricao']?><span class="glyphicon glyphicon-chevron-right pull-right"></span> </li>
                    <?php }
                    $_SESSION['acao'] = 2; // Accao com privilegio coordenador
                    ?>
                </ul>
                <input name="disciplinapl" id="disciplinapl" value="" type="hidden"/>

                <div class="row">

                    <div class="col-md-6">

                <select name="ano_academico" id="ano_academico" class="form-control">

                    <option selected="selected">Seleccionar Ano</option>
                    <?php
                    for($i = date('Y'); $i >= 2010; $i--){ ?>
                        <option value="<?php echo $i ?>"> <?php echo $i ?> </option>
                    <?php } ?>
                </select>

                        </div>

                    <div class="col-md-6">

                    <button style="width:52%" class="btn btn-default btn_show_plano" id="btn_show_plano" >
                        &nbsp;Mostrar </button>

                    <button style="width:46%" class="btn btn-default" data-toggle="modal" data-target="#plano_aula" data-backdrop="false">
                        Adicionar &nbsp;</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    <div class="docente_plano">
        <h5 style="color:#f95e0f">DETALHES DO PLANO DE AVALIAÇÃO</h5>

        <div name="fmr_plano_avaliacao" id="fmr_plano_avaliacao" >
            <div class="col-md-12 pull-left">
                <table class="table table-responsive tbl_cursos ui-shadow table-stripe ui-responsive">
                    <title>Detalhes do Plano</title>
                      
                    <thead>
                          <tr>
                             <th>ID</th>  
                        <th>DISCIPLINA</th>
                        <th>TIPO DE AVALIAÇÃO</th>
                        <th>PESO</th>
                        <th>Operações</th>

                           </tr>
                    </thead>
                    <tbody id="tbl_dados" style="font-size: 11px;"> </tbody>
                      </table>

                <br>
                <div class="rs_editar_avaliacao"></div>
            </div> <!---- Table show plano-->
        </div>

            <div class="visualizar_pl_x tbl_cursos">
            <div class="col-md-12 pull-left">

                <table class="table table-responsive ui-shadow table-stripe ui-responsive" style="width: 100%">
                    <title>Lista de Datas</title>
                    <thead>
                          <tr>
                             <th>ID</th>  
                        <th>ORDEM DE AVALIAÇÃO</th>
                        <th>PREVISÃO DE DATAS</th>
                        <th>STATUS</th>
                        <th>ACÇÕES</th>

                           </tr>
                    </thead>
                    <tbody id="table_pl" style="font-size: 11px;"> </tbody>
                      </table>

                <br>
                <div class="rs_editar_avaliacao"></div>
            </div> <!---- Table show plano-->
            </div>
        </div>

        <h3 style="margin-top:2em;">&nbsp;</h3>
        <div class="disp_doc_pesq"> </div>




    </div> <!-- fim menu mostrar disciplina -->

    <hr>
    <!-- Modal para controlo de erro  -->
    <div class="modal fade" id="plano_aula" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title ctr_sms" style="color: blue;">Registar Plano</h4>
                </div>
                <hr>
                <div class="modal-body">

                    <div class="alert alert-warning lb_avaliacao">Caso não deseja atribuir peso as avaliações considere peso 100%</div>
                        <!--div class="">Novo Plano de Avaliação: </div-->

                    <div class="row">

                        <div class="col-md-6">

                            <label for="tipo_av">Selecionar tipo de avaliação:</label>
                            <select class="form-control" data-style="btn-primary" data-width="auto" id="tipo_av" name="tipo_av">

                                <option value="">--Selecionar Plano--</option>

                                <?php
                                $result = mysqli_query($db->openConection(),'select * from tipoavaliacao WHERE estado=2');
                                while ($row= mysqli_fetch_assoc($result)){ ?>

                                    <option value="<?php echo $row['idTipoAvaliacao']?>"><?php echo $row['descricao'] ?></option>
                                <?php }?>

                            </select>

                        </div>

                        <div class="col-md-6">


                            <label for="chk_peso">Indicar o curso: </label>

                            <select name="a_curso" id="a_curso"  class="form-control">
                                <option selected="selected">Seleccionar Curso</option>

                                <?php
                                $res = mysqli_query($db->openConection(), 'SELECT * FROM curso');
                                while ($row = mysqli_fetch_assoc($res)){?>
                                    <option value="<?php echo $row['idcurso']?>"> <?php echo $row['descricao']?></option>
                                <?php }?>

                                <option value=""> ... </option>
                            </select>


                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <label for="chk_peso">Indicar o Peso: </label>
                            <input style="color: red" pattern="^\d{2}$" type="number" value="100" name="peso_avaliacao" id="peso_avaliacao" class="peso_avaliacao form-control"/>


                        </div>

                        <div class="col-md-6">

                            <label for="chk_qtd">Quantidade de Avaliações:</label>
                            <input type="text" name="qtd_avaliacao" id="qtd_avaliacao" class="qtd_avaliacao form-control"/>

                            <div class="pull-right a_modal"> <p style="cursor: pointer; color:blue" class="btn_criar_cdatas">ADICIONAR DATA</p></div><br>

                        </div>

                        </div>

                        <!-- Mostra mensagem de sucesso no modal plano de avaliacao -->
                        <div class="sms_sucesso" style="color:#398439; font-weight: bold" align="left"></div>
                        <div align="left"><h3 class="sucess"></h3></div>
                        <p class="data_dinamics"></p>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button value="" class="btn btn-primary sv_plano" onclick="registar_plano()" id="sv_plano">Guardar Plano</button>
                </div>
            </div>
        </div>
    </div>


    <!----------------------------    Modal Classes    ----------------------------->

</body>
</html>

<?php }?>
