<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.php");?>

<!--    <script src="js/jquery.js" type="text/javascript"></script>-->
<!--    <script src="js/jquery.tablesorter.js" type="text/javascript"></script>-->
<!--    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.min.js"></script>-->
<!--    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.js"></script>-->
<!--    <script src="../_assets/js/jquery-1.8.3.min.js"></script>-->
<!--    <script src="../libs/bootstrap/js/bootstrap.min.js"></script>-->
<!--    <script src="../_assets/js/jquery.mobile-1.4.3.min.js"></script>-->
<!---->
<!--    <link href="../libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
<!--    <link href="../_assets/css/jquery.mobile-1.4.3.min.css" rel="stylesheet" type="text/css"/>-->


</head>
<body>


<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><span class="glyphicon glyphicon-bookmark"></span>Integracao com eSira</h4>
        </div>


        <form class="form-horizontal" role="form" id="datos_cotizacion">

            <div>
              <p>
                <label for="q" class="col-md-2 control-label">Estudantes</label>
                  <button type="button" class="btn btn-default" onclick='loadAlunos(1)'>
                          <span class="glyphicon glyphicon-link" > Buscar Estudantes no eSira
                  </button>
                  <span id="loadere"></span>
              </p>
            </div>

            <div>
                <p> <label for="q" class="col-md-2 control-label">Disciplinas</label>
                    <button type="button" class="btn btn-default" onclick='loadDisciplinas(1)'>
                        <span class="glyphicon glyphicon-link" > Buscar Disciplinas no eSira
                    </button>
                    <span id="loaderd"></span>
                </p>
            </div>

            <div>
                <p>  <label for="q" class="col-md-2 control-label">Cursos</label>
                    <button type="button" class="btn btn-default" onclick='loadCursos(1)'>
                        <span class="glyphicon glyphicon-link" > Buscar Cursos no eSira
                    </button>
                    <span id="loaderc"></span>
                </p>
            </div>

            <div>
                <label for="q" class="col-md-2 control-label">Inscricao</label>
                <button type="button" class="btn btn-default" onclick='loadInscricoes(1);'>
                    <span class="glyphicon glyphicon-link" > Buscar Inscricao no eSira
                </button>
                <span id="loaderi"></span>
            </div>
        </form>
    </div>
</div>

        <div id="resultados"></div>     <!--Carga los datos ajax -->
       <div class='outer_div'></div>    <!-- Carga los datos ajax -->

    <?php
        include("../layouts/footer.php");
    ?>

    <script type="text/javascript" src="../fragments/js/integracao.js"></script>

</body>
</html>