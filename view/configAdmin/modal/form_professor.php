	<?php
		if (isset($con))
		{
	?>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header alert-warning">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Criar Professor</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_professor" name="guardar_professor">
			<div id="resultados_ajax"></div>



                <div class="form-group">
				<label for="auto_encarregado" class="col-sm-3 control-label">Utilizador - Registado *</label>
				<div class="col-sm-8">

                    <input type="search" onkeyup="pesquisar(this.value,0)" id="auto_encarregado" class="form-control" autocomplete="off">
                    <ul class="list-group list_view_encarregado"></ul>
                    <input type="hidden" name="campo_utilizador" id="campo_utilizador" value=""/>

                </div>
			  </div>


                <div class="form-group">
                    <label for="grau" class="col-sm-3 control-label">Grau Academico</label>
                    <div class="col-sm-8">
                        <select name="grau" id="grau" class="form-control">

                            <?php
                            $rs = mysqli_query($con, 'SELECT * FROM grau_academico');
                            while ($row = mysqli_fetch_assoc($rs)){ ?>

                                <option value="<?php echo $row['idGrau']?>"><?php echo $row['descricao'] ?></option>

                            <?php } ?>
                            <option value="">...</option>
                        </select>
                    </div>
                </div>


                              <div class="form-group">
                    <label for="regime" class="col-sm-3 control-label">Regime</label>
                    <div class="col-sm-8">

                        <select class="form-control first_select" data-style="btn-primary"
                                data-width="auto" id="regime" name="regime">

                            <option value="Inteiro">Inteiro</option>
                            <option value="Parcial">Parcial</option>

                        </select>

                    </div>
                </div>


                <div class="form-group">
                    <label for="guardar_datos" class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-8">

                        <button type="submit" class="btn btn-primary pull-right" id="guardar_datos">Guardar</button>

                    </div>
                </div>
            </form>


              <form class="form-horizontal" method="post" name="guardar_professor_disciplinas" id="guardar_professor_disciplinas">

              <h4 style="color:darkred">Associar às disciplinas <span class="success_result" style="color: #0000CC"></span></h4>
              <hr>

              <div class="form-group">
                  <label for="curso" class="col-sm-3 control-label">Curso /Classe</label>
                  <div class="col-sm-8">

                      <input type="hidden" name="user_id" id="user_id" value=""/>

                      <select name="curso" id="curso" class="form-control" onchange="buscar_turma(this.value)">
                          <option value="">Seleccionar o curso</option>

                          <?php
                          $rs = mysqli_query($con, 'SELECT * FROM curso');
                          while ($row = mysqli_fetch_assoc($rs)){ ?>
                              <option value="<?php echo $row['idcurso']?>"><?php echo utf8_encode($row['descricao']) ?></option>
                          <?php } ?>

                          <option value="">...</option>
                      </select>

                  </div>
              </div>

              <div class="form-group">
                      <label for="disciplina_x" class="col-sm-3 control-label">Disciplinas do Curso</label>
                      <div class="col-sm-8">

                          <select name="disciplina_x" id="disciplina_x" class="form-control" onchange="enable()">
                              <?php
                              $rs = mysqli_query($con, 'SELECT * FROM disciplina');
                              while ($row = mysqli_fetch_assoc($rs)){ ?>
                                  <option value="<?php echo $row['idDisciplina']?>">
                                      <?php echo utf8_encode($row['descricao']) ?></option>
                              <?php } ?>

                          </select>
                      </div>

                  </div>

                  <div class="form-group">
                      <label for="posicao" class="col-sm-3 control-label">Posicao na Disciplina</label>
                      <div class="col-sm-8">
                          <select name="posicao" id="posicao" class="form-control">

                              <option value="Regente" class="">Regente</option>
                              <option value="Assistente" class="">Assistente</option>
                              <option value="Convidado" class="">Convidado</option>
                              <option value="Outro" class="">Outro</option>

                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="curso" class="col-sm-3 control-label">Nivel /Turma</label>
                      <div class="col-sm-8">

                          <div class="dinamic_turma"></div>

                          <div class="static_turma">

                          <select name="turma_x" id="turma_x" class="form-control">
                              <option value=""></option>

                              <?php
                              $rs = mysqli_query($con, 'SELECT * FROM turma');
                              while ($row = mysqli_fetch_assoc($rs)){ ?>
                                  <option value="<?php echo $row['idturma']?>"><?php echo utf8_encode($row['descricao']) ?></option>
                              <?php } ?>

                          </select>
                          </div>

                      </div>
                  </div>

              <div class="form-group">
                  <label for="regime" class="col-sm-3 control-label">&nbsp;</label>
                  <div class="col-sm-8">

                      <button type="submit" class="btn btn-primary pull-right" id="associar_disciplinas">Associar</button>

                  </div>
              </div>


              </form>
		  </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

		  </div>

		</div>
	  </div>
	</div>
	<?php
		}
	?>