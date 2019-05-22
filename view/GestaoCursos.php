<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 1/14/2018
 * Time: 11:57 PM
 */

require '../QuerySql/Classes.php';
$db =  new mySQLConnection();
$clases = new Classes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pautas Academicas</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="shortcut icon" href="PUT YOUR FAVICON HERE">-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="../libs/bootstrap/css/bootstrap.css" rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../view/header/js/colorbox/colorbox.css"  rel='stylesheet' type='text/css'>
    <link href="../view/header/css/templatemo_style.css"  rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap-select.css">
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap-select.min.css">
    <link href="../view/header/css/css_mystyle.css"  rel='stylesheet' type='text/css'>

    <script src="../js/js_script.js"></script>
    <script src="../libs/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <script src="../libs/bootstrap/js/bootstrap.min.js"  type="text/javascript"></script>

</head>

<body>
<div class="container table-responsive">

    <h4 style="color:#00516e" class="info_cadastro">
        <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
           data-target="#myModal" data-backdrop="static"><span class="glyphicon glyphicon-plus">

            </span>&nbsp; Adicionar</a>
    </h4>

    <table class="table tbl_cursos">
        <thead>
        <tr>
            <th>Curso</th>
            <th>Taxa</th>
            <th>Periodo(s)</th>
            <th>Formador(es)</th>
            <th>Operações</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $q = mysqli_query($db->openConection(),'SELECT * FROM curso LIMIT 5 ' );
            while ($linhas = mysqli_fetch_assoc($q)){
        ?>
        <tr>
            <td><?php echo $linhas['descricao']?></td>
            <td><?php echo '0,00'?></td>
            <td><?php echo $clases->find_periodos($linhas['idcurso'])?></td>
            <td><?php echo utf8_encode($linhas['idresponsavel'])?></td>
            <td>
                <button class="btn btn-warning btn-sm" value="<?php echo $linhas['idcurso'] ?>">
                    <span class="glyphicon glyphicon-edit"></span></button>
                <button class="btn btn-danger btn-sm" value="<?php echo $linhas['idcurso'] ?>">
                    <span class="glyphicon glyphicon-remove"></span></button>

            </td>
        </tr>
        <?php }?>

        </tbody>
    </table>

</div>

<!-- Novo curso-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog" data-dismissible="true">
        <div class="modal-dialog modal-sm" data-dismissible="false">

            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span> eCursos - Cadastrar Curso</h4>
                </div>

                <div class="modal-body">

                    <div style="padding: 20px 30px">

                        <div class="alert alert-success msg_curso"></div>

                        <label for="nomecurso">Nome do Curso</label>
                        <input type="text" name="nomecurso" id="nomecurso"  class="form-control"/>

                        <label for="taxacurso">Taxa do Curso:</label>
                        <input type="text" name="taxacurso" id="taxacurso" class="form-control"  />

                        <label for="formadorcurso">Nome do Formador:</label>
                        <input type="text" name="nomeformador" id="nomeformador" class="form-control" />

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="salvar_curso();" id="btn_save_curso" class="btn btn-success pull-right" >Guardar</button>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

