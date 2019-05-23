<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 30-Sep-15
 * Time: 6:26 PM
 */

session_start();
if (!isset($_SESSION['username'])){?>

    <script xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        window.location="../index.php";
    </script>


<?php }else{

    require_once("../functions/Conexao.php");
    require_once('../controller/PautaNormalCtr.php');
    require_once('../QuerySql/PublicacaoPautaSQL.php');
    require_once('../QuerySql/AllQuerySQL.php');
    require_once('../QuerySql/EstudantesSQL.php');
    require_once('../controller/EstudanteNotaCtr.php');
    require_once('../controller/PautaNormalCtr.php');
    require_once('../controller/EstudanteCtr.php');

    $estudante_sql = new EstudantesSQL();
    $db = new mySQLConnection();
    $query = new QuerySql();

    $idAluno= $estudante_sql->getIdEstudante($_SESSION['username'],1);
    $idcurso = $estudante_sql->obterIdCursoEstudante($idAluno);
    $semestre = date('m') < 7 ? '1º':' 2º';
    $ano = date('Y');

    $pautaControlle = new PublicarPauta();
    $curso = '';

} ?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">

    <title>Estudante Pautas</title>

    <style>

        body {
            font-family: serif;
            font-size: 13px;
            li{list-style: none;}
        }
        .controllero_s{
            background: #108040;  border-top-left-radius: 4px; border-top-right-radius: 4px; border: #ccc;
        }

        .ui-li-static.ui-collapsible > .ui-collapsible-heading {
            margin: 0;
        }
        .ui-li-static.ui-collapsible {
            padding: 0;
        }
        .ui-li-static.ui-collapsible > .ui-collapsible-heading > .ui-btn {
            border-top-width: 0;
        }
        .ui-li-static.ui-collapsible > .ui-collapsible-heading.ui-collapsible-heading-collapsed > .ui-btn,
        .ui-li-static.ui-collapsible > .ui-collapsible-content {
            border-bottom-width: 0;
        }

        #res_tipo_av li a{text-decoration: none;}
        #res_tipo_av li{padding: 6px;}
        #save_pauta_normal{margin-top: -1.5em;}

        .table_exame_freq th, .tbl_freq td{
            text-align: center;
            font-family: "Courier New", Courier, monospace;
            border-color: white;
        }

        .table_frequencia{
            font-size: 13px;
        border: none; color:white;
            text-align: center;

            background: -moz-linear-gradient(#24246A, white);
            background:-webkit-linear-gradient(#24246A, white);
            background:-ms-linear-gradient(#24246A, white);
            background:-o-linear-gradient(#24246A, white);
        }

    </style>

    <link href="header/css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link href="header/css/css_mystyle.css"  rel='stylesheet' type='text/css'>

    <link href="../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>
    <script src="../_assets/js/jquery-1.8.3.min.js"></script>
    <script src="../_assets/js/jquery.mobile-1.4.3.min.js"></script>
    <script type="text/javascript" src="../js/js_function.js"></script>
    <script src="../js/js_data_base.js" type="text/javascript" charset="utf-8"> </script>

    <script type="text/javascript" src="../js/js_estudante.js"></script>
    <script src="../libs/bootstrap/js/bootstrap.min.js"></script>
    <link href="../libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    </head>



<body>

<div data-role="page" class="ui-container" style="background: #fff">

    <div data-role="content" class="container">
            <div style="float: left"
                <h3 class="active_ano" style="color:green;font-family: Consolas">
                    <span style="color:red"><?php echo 'Ano activo_'. date('Y').' Semestre I'?></span>
                </h3>
            <input type="hidden" id="txt_ano_activo" value="<?php echo date('Y');?>"/>
            </div>

        <div style=" float: right;">

            <fieldset data-role="controlgroup" data-type="horizontal">

            <select name="select-ano" id="select-ano" data-theme="a"
                    data-overlay-theme="c" data-native-menu="false" data-mini="true" >
                <option selected="selected">Seleccionar o ano</option>
                <?php
                for($i = $estudante_sql->obter_ano_ingresso($_SESSION['username']); $i< date('Y'); $i++){ ?>
                        <option value=""> <?php echo $i ?> </option>
                    <?php } ?>
                <option value="">...</option>

            </select>

            <select name="a_semestre" id="a_semestre" data-theme="a"
                    data-overlay-theme="c" data-native-menu="false" data-mini="true" >

                <option selected="selected">Seleccionar Semestre</option>
                    <?php
                    $res = mysqli_query($db->openConection(), 'SELECT * FROM periodos_anuais');
                    while ($row = mysqli_fetch_assoc($res)){?>
                        <option value="<?php echo $row['idperiodo']?>"> <?php echo $row['descricao']?></option>
                    <?php }?>

                    <option value=""> ... </option>
            </select>

            </fieldset>
        </div> <br> <br>


        <div data-role="collapsibleset" data-iconpos="left" data-content-theme="a" data-mini="true"
                 style=" margin-top: 2em; border: none;" class="main_div getPtn2">

                <input type="hidden" id="save_nome_disp"/>
                <input type="hidden" id="save_nome_av"/>

                <?php
                $vetor =  $estudante_sql->estudanteDisciplina($idAluno, "", 0, $semestre, $ano);

                foreach($vetor as $row){
                    if ($row!=null){

                        $disp = $row['idDisciplina'];
                        $curso=$row['curso'];

                        if ($estudante_sql->obterQtdAvaliacaoPub($disp,2,$row['idcurso'], 0) >= 0){ ?>
                            <div  data-role="collapsible" data-theme="c" style=" color:#008000" id="ctr_pauta">
                                <h3 > <li value="<?php echo $row['idDisciplina']?>"
                                          class="getDisp" onclick="get_item_disp(this.value)" style="list-style: none">

                                        <a href="#two"><?php echo $row['descricao']?></a></li></h3>

                                <!-- Mostrar tabelas de Notas-->

                                <div class="myresult">
                                    <div class="<?php echo 'pp'. $disp ?>" ><h4 align="left" style="color: blue;">Pautas Parciais</h4>
                                    <h3 class="titulo2" style="color:green" align="justify"></h3>

                                    <table data-role="table" id="table-custom-2"
                                           class="ui-body-d ui-shadow table-stripe ui-responsive"
                                           style="margin-top: 1em; margin-bottom: 3em">
                                        <thead>

                                        <tr class="ui-bar-b" style="background: #4682B4; font-size: 13px;
										border: none; color:white" align="center">

                                            <th >Tipo de Avaliação </th>
                                            <th style="text-align: center">Classificação</th>
                                            <th style="text-align: center">Data de Publicação</th>

                                        </tr>
                                        </thead>
                                        <tbody class="mycontente" style="font-size: 12px"></tbody>
                                    </table>
                                    </div>

                                    <div class="<?php echo $row['idDisciplina']?>"></div>

                                    <div class="tipo_avaliacao" style="margin-top: .5em;" align="right">
                                        <fieldset data-role="controlgroup" data-type="horizontal">

                                            <button class="btn_freq" onclick="buscar_avaliacao_freq(this.value)" type="submit" value="<?php echo $row['idDisciplina']?>" data-inline="true" data-mini="true">Mapa de Frequencia</button>
                                            <button class="btn_exame" onclick="buscar_avaliacao_exame(this.value)" type="submit" value="<?php echo $row['idDisciplina']?>" data-inline="true" data-mini="true">Pautas de Exame</button>

                                        </fieldset>
                                    </div>
                                </div> <!-- end my result-->
                            </div>

                        <?php }else{?>

                            <div  data-role="collapsible" data-theme="c" style=" color:#008000">
                                <h3 class="ui-bar-a" value="<?php echo $row['idDisciplina']?>" style="color:blue" class="getDisp">
                                    <?php echo $row['descricao'] .'   [ Nenhuma Avaliação Publicada ] '?> </h3></div>
                        <?php }} } ?>

                <!--fim colapsible 1--->
            </div>  <!--fim colapsibleset--->

            <!----------------------------------Avaliacoes de Frequencia de disciplina ------------------------------>

            </div> <!-- container Geral -->
        </div>  <!--fim CONTENT--->


</body>

<script src="header/js/js_script.js"  type="text/javascript"></script>
<script src="header/js/jquery.min.js" type="text/javascript"></script>
<script src="header/js/colorbox/jquery.colorbox-min.js"  type="text/javascript"></script>
<script src="header/js/templatemo_script.js"  type="text/javascript"></script>

</html>



