	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="form_aluno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">


		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> NOVO ESTUDANTE</h4>
		  </div>

            <!--form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente"-->

            <div class="modal-body">

              <div id="resultados_ajax"></div>

                <form action="../../controller/FormandoCtr.php?acao=2" method="post">

                        <h4 style="color:green">Identificação</h4>
                    <hr>

                        <?php

                        if($_SESSION['tipo']!='estudante'){ ?>

                            <label for="pesquisar">Buscar Utilizador:  &nbsp;</label>
                            <input type="search" onkeyup="pesquisar(this.value,5)" id="auto_encarregado" class="form-control" autocomplete="off">
                            <ul class="list-group list_view_encarregado"></ul>
                            <input type="hidden" name="campo_utilizador" id="campo_utilizador" value=""/>

                            <input type="hidden" name="campo_utilizador" id="campo_utilizador" value="<?php echo $_REQUEST['acao'];?>"/>

                        <?php }else{ ?>

                            <input type="hidden" name="campo_utilizador" id="campo_utilizador" value="<?php echo $_SESSION['id'];?>"/>

                        <?php }?>

                        <label for="apelido">Apelido:</label><input type="text" id="apelido" required name="apelido" value="" class="form-control"/>
                        <label for="name">Nome:</label><input type="text" id="nome" name="nome" value="" class="form-control" required/>
                        <label for="bi_recibo">BI/Recibo/Passaporte:</label>
                        <input type="text" id="bi_recibo" name="bi_recibo" value="" class="form-control" required/>

                        <label for="estadocivil">Estado Civil:</label>
                        <select class="form-control" data-style="btn-primary" data-width="auto" id="estadocivil" name="estadocivil">
                            <option value="0" desabled="desabled">Selecionar Estado Civil</option>
                            <?php

                            $resut = mysqli_query($con,'SELECT * FROM estado_civil');
                            while ($row = mysqli_fetch_assoc($resut)){ ?>
                                <option value="<?php echo $row['idestadocivil'] ?>"><?php echo $row['descricao']?></option>

                            <?php }  ?>

                        </select>


                        <h4 style="color:green" class="">Endereço e Informações Medicas</h4>
                    <hr>
                        <!------ Novo Estudante --------->


                            <label for="endereco">Morada:</label>

                            <select class="form-control" data-style="btn-primary" data-width="auto" id="endereco" name="endereco" required>

                                <option value="0" desabled="desabled">Selecionar o bairro</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM endereco');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idendereco'] ?>"><?php echo $row['bairro']?></option>
                                <?php }  ?>
                            </select>

                            <label for="provincia">Provincia de Nascimento: </label>

                            <select class="form-control" onchange="buscar_distrito(this.value)" data-style="btn-primary"
                                    data-width="auto" id="provincia" name="provincia">
                                <option value="0" desabled="desabled">Selecionar a Provincia</option>

                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM provincia ORDER BY descricao ASC ');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idprovincia'] ?>"><?php echo $row['descricao']?></option>
                                <?php } ?>

                            </select>

                            <label for="distrito">Distrito:</label>
                            <select class="form-control first_select" data-style="btn-primary" data-width="auto" id="distrito" name="distrito">
                            </select>
                            <div class="lista_distritos"></div>

                            <h3 class="sucesso_reg_est" style="color:blue" align="right"></h3>
                            <label for="provincia">Sofre Alguma Doença?:</label>

                            <input type="text" class="form-control"  name="doenca" value="" id="doenca" placeholder="Indique o Nome da Doença"/>



                </form>


              </div> <!-- Modal Body-->

                  <div class="modal-footer">

                      <button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-primary" id="salvar_est">Guardar</button>
                  </div>

	  </div>
	</div>
    </div>

	<?php
		}
	?>