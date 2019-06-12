	<?php
    //session_start();
		if (isset($con) || !isset($_SESSION['username']))
		{
	?>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="static"
                 aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> CONTAS DE ACESSO</h4>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="pull-right">&times;</span></button>
		  </div>

			<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
                <div class="modal-body">

            <div style="padding: 20px 50px">
                <div id="resultados_ajax"></div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="firstname" class="control-label">Nome Completo</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nome" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_name" class="control-label">Username</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nome de Acesso" autocomplete="off"
                                   pattern="[a-zA-Z0-9]{2,64}" title="Nome do utilizador ( somente letras e números, 2-64 caracteres)"required>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">

                        <div class="form-group">
                            <label for="user_password_new" class="control-label">Palavra Passe</label>
                            <input type="password" class="form-control" id="user_password_new" name="user_password_new"
                                   placeholder="Senha" pattern=".{6,}" title="Senha ( min . 6 caracteres)" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">

                            <label for="user_password_repeat" class="control-label">Repetir a Senha</label>
                            <input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat"
                                   placeholder="Repetir a Senha" pattern=".{6,}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="celular" class="control-label">Celular</label>
                            <input type="number" class="form-control" id="celular" name="celular"
                                   placeholder="Contacto de Telefone" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">

                            <label for="sexo" class="control-label">Sexo</label>
                            <select class="form-control first_select" data-style="btn-primary"
                                    data-width="auto" id="sexo" name="sexo">
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="form-group">
                        <label for="user_email" class="control-label">Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo electrónico" required>
                    </div>
                        </div>
                    </div>

                <div class="row">
                <div class="form-group">

                    <?php
                    if (isset($_SESSION['tipo'])){
                        ?>

                        <label for="sexo" class="control-label">Previlegio</label>
                        <select name="previlegio" id="previlegio" class="form-control">
                            <?php
                            $rs = mysqli_query($con, 'SELECT * FROM previlegio');
                            while ($row = mysqli_fetch_assoc($rs)){ ?>
                                <option value="<?php echo $row['idprevilegio']?>"><?php echo $row['descricao'] ?></option>
                            <?php } ?>
                        </select>


                        <label for="estado" class="control-label">Estado</label>

                        <select class="form-control first_select" data-style="btn-primary"
                                data-width="auto" id="estado" name="estado">

                            <option value="1">Activo</option>
                            <option value="2">Desativo</option>

                        </select>

                    <?php }else{ ?>

                    <div class="form-group">
                        <input type="hidden" value="1" class="form-control" name="previlegio" id="previlegio" readonly/>
                        </div>

                    <div class="form-group">
                        <input name="estado" id="estado" value="1" type="hidden" readonly/>
                        </div>

                    <?php }?>

                </div>
		        </div>

                <div class="link_login"></div>

                </div>

        </div>

		  <div class="modal-footer">
			<button type="reset" class="btn btn-warning" data-dismiss="modal">Fechar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar Dados</button>
		  </div>
		  </form>

	  </div>
	</div>
            </div>
	<?php
		}
	?>