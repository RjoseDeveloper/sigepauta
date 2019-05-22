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
        window.location="../index.php";
    </script>

<?php }
    require_once('../functions/Conexao.php');
    require_once '../QuerySql/AllQuerySQL.php';
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

    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="../_assets/js/jquery-1.8.3.min.js"></script>

    <link rel='stylesheet' href="../css/plano_avaliacao_style.css" type='text/css'>
    <link rel="stylesheet" href="../css/table_style.css" type="text/css">
    <link href="header/css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link href="header/css/css_mystyle.css"  rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css" type="text/css"/>
    <script src="../libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="../js/js_function.js" type="text/javascript"></script>
    <script src="../js/js_plano_avaliacao.js" type="text/javascript"></script>

</head>

<body>

    <div class="container">
        <div class="jumbotronx" style="background: #e4e4e4">

        <div class="form-group row" style="padding: 30px 50px">

            <div class="col-md-6">
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

                <div class="pull-left">

                <select name="ano_academico" id="ano_academico" class="form-control">

                    <option selected="selected">Seleccionar Ano</option>
                    <?php
                    for($i = date('Y'); $i >= 2010; $i--){ ?>
                        <option value="<?php echo $i ?>"> <?php echo $i ?> </option>
                    <?php } ?>
                </select>
                </div>

                <div class="pull-right">
                    <a class="btn btn-default btn_show_plano" id="btn_show_plano" value="Mostrar Plano">
                        <span class="glyphicon glyphicon-eye-open"></span></a>


                    <button class="btn btn-default" data-toggle="modal" data-target="#plano_aula" data-backdrop="false">
                        <span class="glyphicon glyphicon-plus"></span></button>


                </div>
                </div>

            </div>

        </div>


    <div class="docente_disp">
        <h4 style="color:#002752">DETALHES DO PLANO DE AVALIAÇÃO</h4>

        <div name="fmr_plano_avaliacaox" id="fmr_plano_avaliacao">
            <br>
            <!---  Saessao mostra plano de avliacao -->
            <div class=" col-md-6 pull-left">

                <table class="table table-responsive ui-shadow table-stripe ui-responsive">
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

            <div class="visualizar_pl_x col-md-6 pull-right">

                <table class="table table-responsive ui-shadow table-stripe ui-responsive">
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

        <h3 style="margin-top:2em;">&nbsp;</h3>
        <div class="disp_doc_pesq"> </div>




    </div> <!-- fim menu mostrar disciplina -->

    <hr>
    <!-- Modal para controlo de erro  -->
    <div class="modal fade" id="plano_aula" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header alert alert-warning">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title ctr_sms" style="color: blue;">Registar Plano</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-success lb_avaliacao">Caso não deseja atribuir peso as avaliações considere peso 100%</div>
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
                    <button value="" class="btn btn-primary sv_plano" onclick="registar_plano()" id="sv_plano">Guardar Plano</button>
                </div>
            </div>
        </div>
    </div>

    <script src="header/js/jquery.min.js" type="text/javascript"></script>
    <script src="header/js/bootstrap.min.js"  type="text/javascript"></script>
    <!----------------------------    Modal Classes    ----------------------------->

</body>
</html>
