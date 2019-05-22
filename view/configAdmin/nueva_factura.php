<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	$title="Sistema | Gestao Escolar";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-plus'></i> Sessão Novo Pagamento</h4>
		</div>
		<div class="panel-body">

		<?php
			include("modal/form_curso.php");

		?>
			<form class="form-horizontal" role="form" id="form_payments" name="form_payments" method="post">
				<div class="form-group row">
				  <label for="id_aluno" class="col-md-1 control-label">Aluno:</label>

				  <div class="col-md-3">
					  <input type="search" onkeyup="_autocomplete(this.value)" autocomplete="off"
                             class="form-control input-sm" id="nombre_cliente"
                             placeholder="buscar un aluno" required="Digitar um texto ...">
					  <input id="id_aluno" type='hidden' name="id_aluno">
                      <div id="dados_auto"></div>

				  </div>

				  <label for="tel1" class="col-md-1 control-label">Telefone:</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Telefone" readonly>
							</div>

					<label for="mail" class="col-md-1 control-label">Email:</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly>
							</div>
				 </div>

                <div class="form-group row">

							<label for="finality" class="col-md-1 control-label">Finalidade:</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="finality" name="finality">
									<?php
										$sql_vendedor=mysqli_query($con,"select * from pay_finality");
										while ($rw=mysqli_fetch_array($sql_vendedor)){?>
											<option value="<?php echo $rw['idfinalidade'] ?>"><?php echo $rw["finalidade"]?></option>
											<?php }?>
								</select>
							</div>

							<label for="status" class="col-md-1 control-label">Status Pagamento:</label>
							<div class="col-md-3">

                                    <select class="form-control input-sm" id="status" name="status">
                                        <?php
                                        $sql_juro=mysqli_query($con,"select * from status_payments");
                                        while ($rw=mysqli_fetch_array($sql_juro)){?>
                                            <option value="<?php echo $rw['idstatus']?>"><?php echo $rw["descricao"]?></option>
                                        <?php }?>
                                    </select>
                                </div>


							<label for="modo_pay" class="col-md-1 control-label">Forma de Pagamento:</label>
							<div class="col-md-3">
								<select class='form-control input-sm' id="modo_pay" name="modo_pay">
									<option value="Cash">Cash</option>
									<option value="Cheque">Cheque</option>
									<option value="Conta Movel">Conta Movel</option>
									<option value="Outra Via">Outra Via</option>
								</select>
							</div>
						</div>

                <div class="form-group row">

                    <label for="juro" class="col-md-1 control-label">Multa (%):</label>
                    <div class="col-md-3">
                        <select class="form-control input-sm" id="juro" name="juro">
                            <?php
                            $sql_juro=mysqli_query($con,"select * from juro");
                            while ($rw=mysqli_fetch_array($sql_juro)){?>
                                <option value="<?php echo $rw['idjuro']?>"><?php echo $rw["juro"]?></option>
                            <?php }?>
                        </select>
                    </div>

                    <label for="valor" class="col-md-1 control-label">Valor:</label>
                    <div class="col-md-3">
                        <input type="number" value="" name="valor" id="valor" class="form-control input-sm"/>
                    </div>

                    <label for="curso" class="col-md-1 control-label">Curso:</label>
                    <div class="col-md-3">
                        <select class="form-control input-sm" id="curso" name="curso" required="Select Curso">
                            <option>&nbsp;</option>
                            <?php
                            $sql_juro=mysqli_query($con,"select * from curso");
                            while ($rw=mysqli_fetch_array($sql_juro)){?>
                                <option value="<?php echo $rw['idcurso']?>"><?php echo $rw["descricao"]?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-3">&nbsp;</div>

                <div class="col-md-3 pull-right">
                    <button type="button" id="btn_save_payments" class="btn btn-info" title="Salvar">
                        <span class="glyphicon glyphicon-save"></span>
                    </button>
                    <button type="button" class="btn btn-success">
                        <span class="glyphicon glyphicon-print" title="Imprimir"></span>
                    </button>
                </div>
                    </div>

			</form>


            <div id="resultados_x"></div>
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div>

		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">

			</div>	
		 </div>
	</div>
	<hr>

	<?php
	include("footer.php");
	?>


	<script type="text/javascript">

        /***
         *  form that send data to data inscricao
         */

        $("#btn_save_payments").click(function(){
            var parametros = "";


            var id_cliente = $("#id_aluno").val();
            var fnl = $("#finality").val();
            var c= $("#curso").val();
            var jr = $("#juro").val();
            var vl = $("#valor").val();
            var mdp = $("#modo_pay").val();
            var sts = $('#status').val();
             if (id_cliente < 0 || c < 0 || valor < 0){
                 $("#resultados_x").html('<h3 style="color:red">CAMPO ALUNO OU CURSO NAO DEVE ESTAR VAZIO</h3>')
             }else {

                 $.ajax({
                     type: "POST",
                     url: "./register/factura.php",
                     data: {
                         id_aluno: id_cliente, finality: fnl,
                         modo_pay: mdp, juro: jr, valor: vl, curso: c, status: sts
                     },
                     beforeSend: function (objeto) {
                         $("#resultados_x").html("Mensagem: Carregando...");
                     },
                     success: function (datos) {
                         $("#resultados_x").html(datos);
                         load(id_cliente);
                         //VentanaCentrada('./pdf/documentos/factura_pdf.php?id_aluno=' + id_cliente + 'Factura', '', '1024', '768', 'true');

                     }
                 });
             }

            });



        function _autocomplete(val){
            var html ="";
            if (val.length >2) {

                $('#dados_auto').show();

                $.ajax({
                    url: "./ajax/autocomplete/alunos.php",
                    data: {term: val},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.id_aluno);

                        html += '<ul class="list-group">';
                        html += '<li class="list-group-item" onclick="hiden(this.value)" value="'+data.id_aluno+'"><a>' + data.nomeCompleto + '</a>' +
                        ' <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';

                        $('#id_aluno').val(data.id_aluno);
                        $('#nombre_cliente').val(data.nomeCompleto);
                        $('#tel1').val(data.celular);
                        $('#mail').val(data.email);
                        html += '</ul>';
                        $('#dados_auto').html(html);
                    }
                })
            }
        }
        function hiden(item){
            $('#dados_auto').hide();
            $('#id_aluno').val(item);

            $.ajax({
                type: "POST",
                url: "./ajax/agregar_facturacion.php",
                data: "idaluno=" + item,
                beforeSend: function (objeto) {
                    $("#resultados").html("Mensagem: Carregando...");
                },
                success: function (datos) {
                    $("#resultados").html(datos);
                    //VentanaCentrada('./pdf/documentos/factura_pdf.php?id_cliente=' + id_cliente + '&id_vendedor=' + id_vendedor + '&condiciones=' + condiciones, 'Factura', '', '1024', '768', 'true');
                }
            });
        }


        function load(page){

            var q= $("#q").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'./ajax/agregar_facturacion.php?idaluno='+page,
                beforeSend: function(objeto){
                    $('#loader').html('<img src="./img/ajax-loader.gif"> Carregando...');
                },
                success:function(data){
                    $("#resultados").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })
        }

	</script>

  </body>
</html>

