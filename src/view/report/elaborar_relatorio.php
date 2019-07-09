<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
require_once("../../Query/DocenteSQL.php");
require_once('../../dbconf/getConection.php');
require_once '../../Query/GestaoPautasSQL.php';
require_once '../../Query/AllQuerySQL.php';

$db = new mySQLConnection();
$query = new QuerySql();
$idDoc = $query->getDoc_id($_SESSION['username']);
$gestao_pautas = new GestaoPautasSQL();

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: index.php");
		exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("../layouts/head.php");?>
  </head>
  <body>

    <div class="container">
		<div class="panel panel-infoc">
		<div class="panel-headingc">
			<h4><span class="glyphicon glyphicon-zoom-in"></span>CRIAR RELATORIO SEMESTRAL</h4>
		</div>			
			<div class="panel-bodyc">
                <div class="container" style="margin-top: 1em">
                    <div class="jumbotron">


                        <form class="form-horizontal" name="save_report" id="save_report">

                            <input type="hidden" value="<?php echo $_REQUEST['disp']?>" name="disp" id="disp">
                            <input type="hidden" value="<?php echo $_REQUEST['curso']?>" name="curso" id="disp">


                        <!--------   Mmostra lista de disciplina de um docente ----------------->
                        <div class="container">
                            <div id="resultados_ajax"></div><!-- Carga los datos ajax -->

                            <div class="col-md-6">

                                <label>Descricao da disciplina</label>
                                <input class="form-control" type="text" name="disciplina" autofocus="true" value="" id="txtnomedisp" placeholder="Nome detalhado da Disciplina ..."/>

                            </div>

                            <div class="col-md-6">

                                <label>Cumprimento do Plano</label>

                            <textarea class="form-control" name="c_plano" id="txtmetaplano"  placeholder="Cumprimento do Plano ..." ></textarea>
                            </div>

                            <div class="col-md-6">

                                <label>Cumprimento das Avaliacoes</label>

                            <textarea class="form-control" name="avaliacao" id="txtdetalhes"  placeholder="Sobre Avaliações ..." ></textarea>
                            </div>

                            <div class="col-md-6">

                                <label>Consntrangimentos da disciplina</label>

                            <textarea class="form-control" name="constrangimento"  id="txtconstrg"  placeholder="Constrangimentos na Disciplina ..." ></textarea>
                            </div>

                            <div class="col-md-6">

                                <label>Perpectivas e Desafios</label>

                            <textarea  class="form-control" name="desafio" id="txtdesafios"  placeholder="Perspectivas ou Desafios ..." ></textarea>

                        </div>

                            <div class="col-md-6 pull-right">
                                <label>&nbsp;.</label><br>

                                <button type="submit" class="btn btn-danger" id="save_reports">
                                    <span class="glyphicon glyphicon-save-file"></span> &nbsp; GUARDAR</button>
                                </div>

                    </div>
                            </form>
                </div>

<!--                <div style="color:blue">LISTA DE PAUTAS</div>-->

                <hr style="border: #014d68">
			<form class="form-horizontal " role="form" id="datos_cotizacion">


                <div class="form-group row">

<!--                         <div class="col-md-3">-->
<!--							<label for="q" class="control-label">Procurar por Ano:</label>-->
<!--                        </div>-->

                    <div class="col-md-8">
                        <label>Lista de relatorios docente</label>

                    </div>

                        <div class="col-md-4">
<!--                                <select name="q" id="q" onchange="onkeyup=load(1);" class="form-control">-->
<!--                                    <option value="2019">2019</option>-->
<!--                                </select>-->
								<input type="text" class="form-control" id="q" placeholder="Disciplina ou Data de Registo ..." onkeyup='load(1);'>
                                <span id="loader"></span>
							</div>

                </div>
			</form>


				<div class='outer_div'></div><!-- Carga los datos ajax -->
						
			</div>
		</div>
	</div>

<!--	<script type="text/javascript" src="js/pautas.js"></script>-->

    <script  src="../fragments/js/el_relatorio.js" type="text/javascript"></script>

  </body>
</html>

<script>

    $(document).ready(function(){load(1);});

    function load(page){

        var item= $('#disp').val();
        var c = $('#curso').val();

        var q= $("#q").val();
        $("#loader").fadeIn('slow');
        $.ajax({
            url:'buscar_relatorio.php?action=ajax&page='+page+'&q='+q+'&disp=' + item + '&curso=' + c,
            beforeSend: function(objeto){
                $('#loader').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
            },
            success:function(data){
                $(".outer_div").html(data).fadeIn('slow');
                $('#loader').html('');
            }
        })
    }

    $("#save_report" ).submit(function( event ) {

        $('#save_reports').attr("disabled", true);
        var parametros = $(this).serialize();
        //alert(parametros);

        $.ajax({
            type: "POST",
            url: "novo_relatorio.php",
            data: parametros,
            beforeSend: function(objeto){
                $("#resultados_ajax").html("Mensagem: Carregando...");
            },
            success: function(datos){
                //alert(datos);
                $("#resultados_ajax").html(datos);
                $('#guardar_datos').attr("disabled", false);
                load(1);
            }
        });
        event.preventDefault();
    });

    function print_lista_rsemetre(item,disp){
        window.location='Relatorio_semestral.php?idreport='+item+'&disp='+disp;
    }

</script>