	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header alert alert-warning">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Registar Novo Curso</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>

			   <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Nome do Curso / Classe:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Curso .." required>
				</div>
			  </div>


                <div class="form-group">
                    <label for="estado" class="col-sm-3 control-label">Nome da Instituição:</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="">-- Selecciona Instituicso --</option>

                            <?php
                            $res = mysqli_query($con, 'SELECT * FROM perfil_instituicao');
                            while ($row = mysqli_fetch_assoc($res)){?>
                                <option value="<?php echo $row['idperfil']?>"> <?php echo $row['nome_instituicao']?></option>
                            <?php }?>

                        </select>
                    </div>
                </div>
			  
			  <div class="form-group">
				<label for="nivel" class="col-sm-3 control-label">Qtd. Turmas / Niveis:</label>
				<div class="col-sm-8">
					<input type="number" class="form-control" id="nivel" name="nivel" required maxlength="255" />
				</div>
			  </div>
			  
			  <div class="form-group">

				<label for="estado" class="col-sm-3 control-label">Regime:</label>
				<div class="col-sm-8">

				 <select class="form-control" id="regime" name="regime" onchange="ctr_time(this.value)" required>

                     <option value="">-- Selecciona Regime --</option>
                     <?php
                     $res = mysqli_query($con, 'SELECT * FROM periodo');
                     while ($row = mysqli_fetch_assoc($res)){?>
                         <option value="<?php echo $row['idperiodo']?>"> <?php echo $row['descricao']?></option>
                     <?php }?>

				  </select>
				</div>
			  </div>

                <div class="form-group">
                    <label for="periodo" class="col-sm-3 control-label" style="color: #ff9933">Indique o Periodo:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="horas"
                               name="horas" placeholder="10h as 13h" title="Inserir o periodo de Aula" maxlength="10">
                    </div>

                    <div class="col-sm-4"><h4 class="periodo_ctr"></h4>
                    </div>
                </div>

			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Taxa de Matricula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="taxa" name="taxa" placeholder="Digite de Inscricao do Curso" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Inserir numeros apenas  0 ó 2 decimais" maxlength="8">

                </div>
			  </div>

                <div class="form-group">
                    <label for="auto_encarregado" class="col-sm-3 control-label">Coordenador do Curso/ Classe *</label>

                    <div class="col-sm-8">

                        <input type="search" onkeyup="pesquisar(this.value,0)" id="auto_encarregado" class="form-control" autocomplete="off">
                        <ul class="list-group list_view_encarregado"></ul>
                        <input type="hidden" name="campo_utilizador" id="campo_utilizador" value=""/>

                    </div>
                </div>

		  </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar Dados</button>
		  </div>

		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>