<?php
session_start();

require_once '../../Query/EstudantesSQL.php';
require_once '../../dbconf/getConection.php';

$estudante_sql = new EstudantesSQL();
$db = new mySQLConnection();
$semestre = date('m') < 7 ? '1º':' 2º';
$ano = date('Y');

$semis = date('m') < 7 ? '1':' 2';

if (!isset($_SESSION['username'])){?>

    <script xmlns="http://www.w3.org/1999/html">
        window.location="../index.php";
    </script>

<?php }?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pautas Online</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <!--
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--    <link href="../../bibliotecas/bootstrap/css/bootstrap.css" rel='stylesheet' type='text/css'>-->
<!--    <link href="../../bibliotecas/bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css'>-->
<!--    <link href="../../bibliotecas/navbar/css/templatemo_style.css"  rel='stylesheet' type='text/css'>-->
<!--    <script src="../../bibliotecas/jQuery/js/jquery-1.9.1.min.js" type="text/javascript"></script>-->
<!--    <script type="text/javascript" src="../../bibliotecas/bootstrap/js/bootstrap.min.js"></script>-->

    <?php include '../layouts/head.php' ?>

    <link href="../fragments/css/css_mystyle.css"  rel='stylesheet' type='text/css'>
    <script src="../fragments/js/js_estudante.js" type="text/javascript"></script>
    <script src="../fragments/js/js_plano_avaliacao.js" type="text/javascript"></script>

    <![endif]-->

    <style>

        ul li{cursor: pointer;color:white}
        ul li:hover{ background:#FBF2EF; color:white}
    </style>

</head>
<body>

<div class="container">

                        <div class="modal-body" style="padding:20px 30px;">

    <h3> Disciplinas - <?php echo utf8_encode($_SESSION['nomeC']) ?> </h3>
                               <hr>
    <ul class="list-group ul_li_item" id="rs_docente_disciplinas">

        <?php
        $idAluno= $estudante_sql->getIdEstudante($_SESSION['username'], 1);
        //echo $idAluno;
        $vetor =  $estudante_sql->estudanteDisciplina($idAluno, "", 0,$semestre,$ano);
        foreach($vetor as $row){
            if ($row!=null){?>

                <li style="color: #0000CC" class="list-group-item" value="<?php echo $row['idDisciplina']?>"
                    onclick="show_plano_estudante(this.value,<?php echo $semis?>,<?php echo $ano?>,0)">
                    <?php echo $row['descricao']?>  <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>
            <?php } }?>
    </ul>

<div class="visualizar_pl ">
    <label>Detalhes do Plano</label>
    <table  id="table-custom-2" data-mode="color"
            class="table table-responsive tbl_cursos" style="width: 100%">
         
        <thead>
              <tr">
            <th>ID</th> 
            <th >Disciplina</th>
                    <th >Tipo de Avaliação</th>
                    <th >Peso</th>
            <th>Operações</th>
                  </tr>
        </thead>
            <tbody id="tbl_dados"> </tbody>
          </table>

</div> <!---- Table show plano-->

<div class="visualizar_pl">

    <label>Datas de Avaliação</label>
    <table  id="table-custom-2" data-mode="color"
            class="table table-responsive tbl_cursos">
         
        <thead>
              <tr class="ui-bar-b"  id="div-bar"
                  style="background: #FAFAFA;border: none; color: #151515; font-size: 12px">
            <th>ID</th>
            <th>Tipo de Avaliação</th>
            <th>Data de Realização</th>
             <th>Status</th>
            <th>Operações</th>
                  </tr>
        </thead>
            <tbody id="table_pl" style="font-size: 11px;"> </tbody>
          </table>

</div> <!---- Table show plano-->

</div>

</div>
</body>
</html>

<script type="text/javascript">

    $('#rs_docente_disciplinas li').click(function(){
        $('li.current ').removeClass('current').css({'background':'white', 'color':'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li ').css({'background':'#E6E8FA', 'color':'blue'});
    });

</script>