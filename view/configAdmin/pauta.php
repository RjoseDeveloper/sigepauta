<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
require_once ("../../QuerySql/DocenteSQL.php");
require_once('../../functions/Conexao.php');
require_once '../../QuerySql/GestaoPautasSQL.php';
require_once '../../QuerySql/AllQuerySQL.php';

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
	<?php include("head.php");?>
  </head>
  <body>

    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
			<h4><span class="glyphicon glyphicon-bookmark"></span>  CADASTRO DE PAUTAS</h4>
		</div>			
			<div class="panel-body">
                <div class="container" style="margin-top: 1em">
                    <div class="jumbotronx" >
                        <!--------   Mmostra lista de disciplina de um docente ----------------->
                        <div class="container">
<!--                            <div style="color:blue">SELECCIONAR DISCIPLINA</div><br>-->
                            <input type="hidden" id="txt_av" value=""/>
                                    <div class="list-group docente_disp ul_li_item" id="disciplinas_docente">
                                <?php
                                $arrayCurso = $query->listaCursoDocente($idDoc);
                                $result = mysqli_query($db->openConection(),$query->listaDisciplina($idDoc, 0));
                                while ($row= mysqli_fetch_assoc($result)){?>

                        <li class="list-group-item doc_ul_a"  value="<?php echo $row['idDisciplina']?>"">
                        <input type="hidden" value="<?php echo $row['descricao']?>" id="descricao_curs"/>
                        <input type="hidden" value="<?php echo $row['idDisciplina']?>" id="id_curs"/>
                        <input type="hidden" value="<?php echo $row['idCurso']?>" id="id_curso"/>

                        <h6 >


                            <div style="color:#996633"><span style=" color:blue;"> <?php echo $row['descricao'] ?></span>
                                <?php echo  $query->datalhes_disciplina($row['idDisciplina'], $idDoc,$db)?>
                            <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                                </div>

                        </h6>
                        </li> <?php }?>
                                <!--select id="select-curso" class="selectpicker" data-style="btn-primary" data-width="auto">
                    <option value="" disabled="disabled" >Seleccionar Curso</option>
                    <?php

                                $consulta= $query->docenteCursoDisciplina($idDoc);
                                $result = mysqli_query($db->openConection(), $consulta);
                                while ($row = mysqli_fetch_assoc($result)) {?>
                        <option  value="<?php echo $row['idCurso']?>"><?php echo $row['descricao']?></option>

                    <?php } ?>
                </select-->
                            </div>

                            <div class="col-xs-5" style="margin-left: -.8em">
                                <label for="">Selecionar Tipo de Avaliação:</label>
                                <select class="form-control" data-style="btn-primary" data-width="auto" id="txt_avaliacao">
                                    <option value="">.....</option>
                                </select>

                                <input name="text_avaliacao" id="text_avaliacao" value="" type="hidden"/>
                            </div>


                            <!----------- Mostra um select box de tipos de avaliacoes ----------->
                            <input type="hidden" id="txt_av" value=""/>
                            <div style="float: right">
                                <a class="btn btn-success" href="../Form_reports.php?acao=10" id="editp" target="frm_content">Relatorios
                                    <span class="glyphicon glyphicon-print"></span></a>
                            </div>
                        </div>
                    </div>
                </div>

<!--                <div style="color:blue">LISTA DE PAUTAS</div>-->

                <hr style="border: #014d68">
			<form class="form-horizontal " role="form" id="datos_cotizacion">
                	<div class="form-group row pull-right">
							<label for="q" class="col-md-5 control-label">Procurar por Ano:</label>

                        <div class="col-md-7">
<!--                                <select name="q" id="q" onchange="onkeyup=load(1);" class="form-control">-->
<!--                                    <option value="2019">2019</option>-->
<!--                                </select>-->
								<input type="text" class="form-control" id="q" placeholder="Nome" onkeyup='load(1);'>
                                <span id="loader"></span>
							</div>
						</div>
			</form>

				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
						
			</div>
		</div>
	</div>
	<hr>
<!--	<script type="text/javascript" src="js/pautas.js"></script>-->

    <script  src="../../js/js_function.js" type="text/javascript"></script>
    <script src="js/js_docente.js" type="text/javascript"></script>
    <script src="../../js/js_editar_pauta.js" type="text/javascript"></script>

  </body>
</html>

<div class="modal fade" id="md_edit_pauta" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-warning" style="padding:25px 40px;border:none">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>&nbsp;<span class="glyphicon glyphicon-info-sign resumo">&nbsp;&nbsp;</span> &nbsp;&nbsp; </h4>

            </div>
            <div class="modal-body" style="padding:20px 30px;">

                <div class="ctr_edit2 pull-right">

                    <div class="ul_li_items" id="resultados"></div>
                    <p></p>
                </div>

                <table role="table"  id="table-custom-2" class="table ui-body-d ui-shadow table-stripe ui-responsive">
                    <thead>
                    <tr class="ui-bar-b" style="border-top: 2px solid #ccccff; border-bottom: 2px solid #ccccff; color:green;font-size: 13px">
                        <th>&nbsp;</th>
                        <th align="center">Numero</th>
                        <th>&nbsp;</th>
                        <th align="center">Nome Completo</th>
                        <th style="text-align: center">Classificação</th>
                        <th>&nbsp;</th>
                        <th>Acção</th>

                    </tr>
                    </thead>
                    <tbody class="table_visualizar_edit" style="font-size: 13px">
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <div class="ctr_disp"></div>
                <button type="button" class="btn btn-info editar_pauta" id="editar_pauta"
                        style=" border: none" data-mini="true" data-inline="true" data-theme="b"> Enviar Pauta</button>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="md_relatorios" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-warning" style="padding:25px 40px;border:none">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>&nbsp;<span class="glyphicon glyphicon-info-sign resumo">&nbsp;&nbsp;</span> &nbsp;&nbsp; </h4>

            </div>
            <div class="modal-body" style="padding:20px 30px;">
                <div class="valida_nota" style="font-weight: bold"></div>
                <table role="table"  id="table-custom-2" class="table ui-body-d ui-shadow table-stripe ui-responsive">
                    <thead>
                    <tr class="ui-bar-b" style="border-top: 2px solid #ccccff; border-bottom: 2px solid #ccccff; color:green;font-size: 13px">
                        <th>&nbsp;</th>
                        <th align="center">Numero</th>
                        <th>&nbsp;</th>
                        <th align="center">Nome Completo</th>
                        <th style="text-align: center">Classificação</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="table_visualizar" style="font-size: 13px">
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <div class="ctr_disp"></div>
                <a href="#" class="btn btn-info enviar_pauta" id="enviar_pauta"
                        style=" border: none" data-mini="true" data-inline="true" data-theme="b"> Enviar Pauta</a>
            </div>
        </div>

    </div>
</div>

<!-- Modal para controlo de erro  -->
<div class="modal fade" id="error_model" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ctr_sms" style="color: blue;">Mensagem do Sistema</h4>
            </div>
            <div class="modal-body">
                <div class="ctr_error" style="color:red; text-align: center">Caro houve problemas na insercao de </div>
            </div>
        </div>
    </div>
</div>


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


<script>

    $(document).ready(function(){load(1);});

    //Evento aplicado no botao editar nota do estudante
    function editar_nota(item) {
        //$('.sucesso').show();

        var id_nota = $(this).val();
        //var nota = parseFloat($('.nota').val());
        alert(nota);

        $.ajax({
            url: "../requestCtr/Processa_edit_avaliacao.php",
            type: "POST",
            data: {nota: nota, acao: 4, idnota: id_nota},
            success: function (result) {
                $('.nome_e').html(result)
                    .css({'color': 'blue', 'font-size': '17px'});
            }
        });  //fim ajax1.
    }

    function editar_pauta(item){
        sessionStorage.setItem('idpauta',item);
        $('.ul_li_items').html("");
        $('#md_edit_pauta').on('shown.bs.modal', function () {
            $('.table_visualizar_edit').html("");
            $.ajax({
                url:'../../requestCtr/Processa_lista_estudante.php',
                data:{acao:6, idpauta:item},
                success:function(data){
                    $('.ul_li_items').html(data);
                }
            })
        })
           }

    function load(page){

        var q= $("#q").val();
        $("#loader").fadeIn('slow');
        $.ajax({
            url:'./ajax/buscar_pauta.php?action=ajax&page='+page+'&q='+q,
            beforeSend: function(objeto){
                $('#loader').html('<img src="./img/ajax-loader.gif"> Carregando...');
            },
            success:function(data){
                $(".outer_div").html(data).fadeIn('slow');
                $('#loader').html('');
            }
        })
    }

    function buscar_notas(item){

        $('.table_visualizar_edit').html("");
        if (item > 0) {

            $.ajax({
                url: "../../requestCtr/Processa_lista_estudante.php",
                type: "POST",
                data: {idpauta: sessionStorage.getItem('idpauta'), idaluno: item, acao: 7, ctr: 1},
                success: function (results) {
                    $('.table_visualizar_edit').html(results);
                    $('#md_edit_pauta').modal({backdrop: false}); // abrira um popup model
                                 }
            });
        }
    }

    function list_pauta(item){


        $('.table_visualizar_edit').html("");

        $.ajax({
            url: "../../requestCtr/Processa_lista_estudante.php",
            type: "POST",
            data: {idpauta:item, acao:7, ctr:0},
            success: function (results) {
                $('.table_visualizar_edit').html(results);
                $('#md_edit_pauta').modal({backdrop: false}); // abrira um popup model

            }
        });
    }

$( "#guardar_disciplina" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);

 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nova_disciplina.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
});

$( "#editar_usuario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_professor.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

    function obtener_datos(id){
			var nombres = $("#nombres"+id).val();
			var apellidos = $("#apellidos"+id).val();
			var usuario = $("#usuario"+id).val();
			var email = $("#email"+id).val();
			
			$("#mod_id").val(id);
			$("#firstname2").val(nombres);
			$("#lastname2").val(apellidos);
			$("#user_name2").val(usuario);
			$("#user_email2").val(email);
			
		}
</script>