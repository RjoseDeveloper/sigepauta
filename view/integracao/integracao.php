<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.php");?>

</head>
<body>


<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><span class="glyphicon glyphicon-bookmark"></span> INSEGRACAO DE DADOS / eSIRA </h4>
        </div>


        <form class="form-horizontal" role="form" id="datos_cotizacion">
            <br>

            <div>
              <p>
                <label for="q" class="col-md-4 control-label">LISTA DE ESTUDANTE</label>
                  <button type="button" class="btn btn-default" onclick='loadAlunos(1)'>
                          <span class="glyphicon glyphicon-link" > BUSCAR DADOS
                  </button>
                  <span id="loadere"></span>
              </p>
            </div>

            <div>
                <p> <label for="q" class="col-md-4 control-label">LISTA DE DISCIPLINAS</label>
                    <button type="button" class="btn btn-default" onclick='loadDisciplinas(1)'>
                        <span class="glyphicon glyphicon-link" > BUSCAR DADOS
                    </button>
                    <span id="loaderd"></span>
                </p>
            </div>

            <div>
                <p>  <label for="q" class="col-md-4 control-label">LISTA DE CURSOS</label>
                    <button type="button" class="btn btn-default" onclick='loadCursos(1)'>
                        <span class="glyphicon glyphicon-link" > BUSCAR DADOS
                    </button>
                    <span id="loaderc"></span>
                </p>
            </div>

            <div>
                <label for="q" class="col-md-4 control-label">MATRICULAS E INSCRICOES</label>
                <button type="button" class="btn btn-default" onclick='loadInscricoes(1);'>
                    <span class="glyphicon glyphicon-link" > BUSCAR DADOS
                </button>
                <span id="loaderi"></span>
            </div>
        </form>

        <br>
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