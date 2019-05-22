<?php

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

    $estudante_sql =  new EstudantesSQL();

    $db = new mySQLConnection();
    $query = new QuerySql();
    $registo_academico = new RegistoAcademicoSQL();
    $idDoc = $query->getDoc_id($_SESSION['username']);

    $arrayCurso;
    $arrayDisciplina;
    $currentDisp = "";
    $semestre = date('m') < 7 ? '1º':' 2º';
    $ano = date('Y');
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

<div data-role="page" style="background: #fff">
<!--  content of menu -->
<div data-role="content" style="padding: 10px 80px">

                <div class="col-md-3 pull-left">

                    <ul data-role="listview" class="ul_curso_rec" data-inset="true" data-mini="true" data-inline="true">
                        <li value="0" data-theme="b" ><span class="glyphicon glyphicon-list"></span> Lista de Cursos</li>
                        <?php
                        $result = mysqli_query($db->openConection(), "Select * from curso");

                        while ($row = mysqli_fetch_assoc($result)){?>

                        <li value="<?php echo $row['idcurso']?>" onclick="buscar_disciplina(this.value)" ><?php echo $row['descricao']?>
                            <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>
                            <?php } ?>
                    </ul>

                    <ul data-role="listview" class="ul_disp_curso" data-inset="true" data-mini="true" data-inline="true">
                        <li value="0" data-theme="b" > <span class="glyphicon glyphicon-list"></span> Lista de Disciplinas</li>
                        <div  class="lista_disciplinas">&nbsp;</div>
                    </ul>
                </div>

                    <div  style="" class="main_div getPtn2 col-md-9 pull-right">
                        <div class="pautas_freq"></div>
                        <div class="res_exames_1"></div>
                           </div> <!-- fim div float right --> <!--fim colapsibleset--->


                      </div>
</div> <!-------------- fim page ----------->

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header alert alert-warning">
                    <button type="button"  style=" border: none" data-mini="true" data-inline="true"
                            class="close" data-dismiss="modal">&times;</button>
                    <h3 class=" modal-title" style="">Pautas do Estudante <span class="nome_aluno"></span></h3>
                </div>

                <div class="container">
                    <div class="res_exames_1" style="padding: 10px 5px"></div>
                </div>

                <div class="modal-footer">

                </div>
            </div> <!-- fim Modal content-->
        </div> <!-- fim Modal dialog -->
    </div> <!-- fim Modal fade-->
</div> <!-- fim Modal container-->

</body>
</html>

<script type="text/javascript">

        $('.ul_curso_rec li').click(function () {

                $('.ul_curso_rec li.current').removeClass('current').css({'background':'white', 'color':'black'});
                $(this).closest('li').addClass('current');
                $(this).closest('li ').css({'background':'#E6E8FA', 'color':'blue'});
        });
        $('.lista_estudantes').hide();

</script>