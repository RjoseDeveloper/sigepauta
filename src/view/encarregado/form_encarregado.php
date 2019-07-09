	<?php
		if (isset($con))
		{

	?>	
			<!-- Modal -->
            <!-- Modal para controlo de erro  -->

            <div class="modal fade" id="registar_encarregado" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header alert-warning">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro do Encarregado de Educação</h4>
                        </div>

                        <form class="form-horizontal" name="registar_encarregado" id="registar_encarregado" method="post">

                            <div class="modal-body">
                                <div style="padding: 10px 30px;" >
                                    <div id="resultados_ajax_encarregado"></div>

                                    <!--h4 class="alert alert-success">Identificação do Encarregado</h4-->

                                    <input type="hidden" value="" id="campo_frm" name="campo_frm"/>

                                    <label for="sexo">Nome Completo:</label>
                                    <input type="text" id="fullname" name="fullname" value=""
                                           class="form-control" required="Nome Completo"/>


                                    <label for="bi_recibo">Nr. do documento:</label>
                                    <input type="text" id="doc" name="doc" value="" class="form-control" required="Numero de B.I"/>

                                    <label for="idade">Idade:</label><input type="number" id="idade" name="idade" value="" class="form-control"/>

                                    <label for="idade">Local de Trabalho:</label>
                                    <select class="form-control" data-style="btn-primary" data-width="auto"
                                            id="local_work" name="local_work">
                                        <option value="0" desabled="desabled">Local de Trabalho</option>
                                        <?php

                                        $resut = mysqli_query($con,'SELECT * FROM localtrabalho');
                                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                                            <option value="<?php echo $row['idlocaltrabalho'] ?>">
                                                <?php echo $row['lcwork']?></option>

                                        <?php }  ?>

                                        <option value="create">Crair ( Novo ) ...</option>
                                    </select>

                                    <label for="celular">Contacto Pessoal:</label>
                                    <input type="tel" id="celular" name="celular" value="" class="form-control" required="Contacto"/>

                                    <label for="email">Grau de Parentesco:</label>
                                    <input type="text" id="parentesco" name="parentesco" value="" class="form-control" required="Parentesco"/>


                                    <label for="nivelescolar">Nivel Escolar:</label>
                                    <select class="form-control" data-style="btn-primary"
                                            data-width="auto" id="nivel_ac" name="nivel_ac">
                                        <option value="0" desabled="desabled">Selecionar nivel escolar</option>
                                        <?php
                                        $resut = mysqli_query($con,'SELECT * FROM nivelescolar');
                                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                                            <option value="<?php echo $row['idnivel'] ?>"><?php echo utf8_encode($row['descricao']) ?></option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="submit" name="btn_save_encarregado" id="btn_save_encarregado" class="btn btn-success">Guardar Dados</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
	<?php
		}
	?>