	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nova_sessao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header alert alert-warning">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Criar Sessão de actividades</h4>
		  </div>
		  <div class="modal-body">

              <form action="../requestCtr/Processa_gestao_pautas.php" name="guardar_actividade" id="guardar_actividade" method="post">

                  <div class="alert alert-success sms_report" style="color:blue"><h5>Criar actividade</h5></div>
                  <label for="datainicio">Data de Inicio:</label>
                  <input type="date" name="datainicio" id="datainicio" class="form-control"/>

                  <label for="datafim">Data de Final: </label>
                  <input type="date" name="datafim" id="datafim" class="form-control"/>
                  <label for="actividade">Indicar actividade: </label>
                  <input type="text" name="actividade" id="actividade" value="" class="form-control">

                  <p class="data_dinamics"></p>
                  <button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary pull-right">Guardar Dados</button>
          </div>

            </form>



		</div>
	  </div>
	</div>
	<?php
		}
	?>