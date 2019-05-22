	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">


		  <div class="modal-header alert-info">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> NOVO ESTUDANTE</h4>
		  </div>

            <!--form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente"-->

            <div class="modal-body">

              <div id="resultados_ajax"></div>

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">IDENTIFICAÇÃO</a></li>
                    <li><a data-toggle="tab" href="#menu1">ENCARREGADO DE EDUCAÇÃO</a></li>
                    <li><a data-toggle="tab" href="#menu2">INSCRIÇÕES</a></li>
                </ul>

                <div class="tab-content container">

                    <div id="home" class="tab-pane fade in active">

                        <div class="col-sm-6">

                            <h4 style="color:green" class="alert alert-success">Identificação</h4>

                            <label for="apelido">Apelido:</label><input type="text" id="apelido" name="apelido" value="" class="form-control"/>
                            <label for="name">Nome:</label><input type="text" id="nome" name="nome" value="" class="form-control"/>

                            <label for="bi_recibo">BI/Recibo/Cedula Pessoal:</label><input type="text" id="birecido" name="birecibo" value="" class="form-control"/>

                            <label for="idade">Idade:</label><input type="number" id="idade" name="idade" value="" class="form-control"/>
                            <label for="sexo">Sexo:</label>

                            <select class="form-control" data-style="btn-primary" data-width="auto" id="sexo" name="sexo">
                                <option value="0" desabled="desabled">Selecionar o sexo</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM sexo');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idsexo'] ?>">
                                        <?php echo $row['descricao']?></option>

                                <?php }  ?>
                            </select>

                            <label for="celular">Celular:</label><input type="tel" id="celular" name="celular" value="" class="form-control"/>
                            <label for="email">Data de Nacimento:</label><input type="date" id="email" name="email" value="" class="form-control"/>

                            <label for="estado">Nivel Escolar:</label>
                            <select class="form-control" data-style="btn-primary" data-width="auto" id="nivelescolar" name="nivelescolar">
                                <option value="0" desabled="desabled">Selecionar nivel escolar</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM nivelescolar');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idnivel'] ?>"><?php echo utf8_encode($row['descricao']) ?></option>
                                <?php }  ?>
                            </select>

                        </div> <!-- fim primeiro bloco---->

                    </div> <!-- fim menu home -->



                    <div id="menu1" class="tab-pane fade">

                        <div class="col-md-6">

                            <h4 style="color:green" class="alert alert-success">Endereço e Informações Medicas</h4>
                            <!------ Novo Estudante --------->

                            <label for="endereco">Endereço Domicilio:</label>
                            <select class="form-control" data-style="btn-primary" data-width="auto" id="endereco" name="endereco">

                                <option value="0" desabled="desabled">Selecionar o bairro</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM endereco');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idendereco'] ?>"><?php echo $row['bairro']?></option>
                                <?php }  ?>
                            </select>

                            <label for="provincia">Provincia de Nascimento:</label>
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

                            <input type="text" class="form-control"  name="txtdoenca" value="" id="txtdoenca" placeholder="Indique o Nome da Doença"/>
                            <label for="notas">Orientações Medicas *:</label>
                            <textarea class="form-control" id="doenca" name="doenca"></textarea>

                            <label for="notas">Poassui Alergia a Alimentos *:</label>
                            <input type="text" class="form-control"  name="txtalergia" value="" id="txtalergia" placeholder="Registar o tipo de alergia a Alimentos"/>

                            <label for="notas">Outras Informações Relevantes *:</label>
                            <textarea type="text" class="form-control" id="notas_i" name="notas_i"></textarea>


                        </div> <!--- fim segundo bloco-->

                    </div>

                    <div id="menu2" class="tab-pane fade">

                        <div class="col-xs-6">
                            <br><br>

                            <p class="msg_sucesso alert alert-success" style="color: #0000CC; font-size: 16px">Inscrições, Pagamentos e Fichas ...</p>

                            <select class="form-control" onchange="buscar_periodos(this.value,0);" data-style="btn-primary"
                                    data-width="auto" id="curso_ins" name="curso_ins">
                                <option value="0">Selecionar um curso</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM curso');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idcurso'] ?>">
                                        <?php echo utf8_encode($row['descricao']) ?></option>
                                <?php }  ?>
                            </select>
                            <br>

                            <select class="form-control" onchange="buscar_periodos(this.value,0);" data-style="btn-primary"
                                    data-width="auto" id="periodo" name="periodo">
                                <option value="0">Selecionar Nivel ou Periodo</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM curso');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idcurso'] ?>">
                                        <?php echo utf8_encode($row['descricao']) ?></option>
                                <?php }  ?>
                            </select>
                            <br>

                            <select class="form-control" onchange="buscar_periodos(this.value,0);" data-style="btn-primary"
                                    data-width="auto" id="disciplina" name="disciplina">
                                <option value="0">Selecionar Nivel ou Periodo</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM disciplina');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idDisciplina'] ?>">
                                        <?php echo utf8_encode($row['descricao']) ?></option>
                                <?php }  ?>
                            </select>

                            <br>

                            <select class="form-control" onchange="buscar_periodos(this.value,0);" data-style="btn-primary"
                                    data-width="auto" id="estudante" name="estudante">
                                <option value="0">Selecionar Estudante</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM estudante');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idestudante'] ?>">
                                        <?php echo utf8_encode($row['nr_mec']) ?></option>
                                <?php }  ?>
                            </select>
                            <br>

                            <label for="taxa_pagar">Taxa do Curso:</label>
                            <input class="form-control" id="taxa_pagar" type="number" placeholder="Digite o valor...">

                            <label for="taxa_pagar">Modo de Pagamento:</label>
                            <input class="form-control" id="taxa_pagar" type="number" placeholder="Digite o valor...">


                            <div class="pull-right"><br>
                                <a href="#" class="btn btn-primary" onclick="btn_inscrever_aluno()" id="btn_inscricao">
                                    <span class="glyphicon glyphicon-plus"></a>
                                <a href="#" class="btn btn-warning" id="btn_upate_pagamento">
                                    <span class="glyphicon glyphicon-edit"></span></a>
                                <a href="#" class="btn btn-success" id="btn_print" onclick="imprimir_ficha()">
                                    <span class="glyphicon glyphicon-print"></span></a>

                                <input type="hidden" id="campo_oculto" name="campo_oculto" value=""/>
                            </div>

                        </div>


                    </div>

                </div>

                <br><br>
              </div> <!-- Modal Body-->

                  <div class="modal-footer">

                      <button class="btn btn-warning" style="" >Cancelar</button>
                      <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar</button>
                  </div>

	  </div>
	</div>
    </div>
	<?php
		}
	?>