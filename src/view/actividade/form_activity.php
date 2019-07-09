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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>CONTROLO DE ACTIVIDADES</h4>
		  </div>

                <form class="form-horizontal" method="post" id="guardar_actividade" name="guardar_actividade">

                    <div class="modal-body">

                    <div id="resultados_ajax2"></div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="actividade">Detalhes: </label>
                        <div class="col-sm-8">


                            <select class="form-control input-sm" id="actividade" name="actividade">
                                <?php
                                $sql_vendedor=mysqli_query($con,"select * from pay_finality");
                                while ($rw=mysqli_fetch_array($sql_vendedor)){?>
                                    <option value="<?php echo $rw['finalidade'] ?>"><?php echo $rw["finalidade"]?></option>
                                <?php }?>
                            </select>

<!--                    <input type="text" name="actividade" id="actividade" value="" class="form-control">-->


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="curso">Curso: </label>
                        <div class="col-sm-8">

                    <select name="curso" id="curso" name="curso" class="form-control" required="">

                        <?php

                        $rs = mysqli_query($con, 'SELECT * FROM curso');

                        while ($row = mysqli_fetch_assoc($rs)){ ?>
                            <option value="<?php echo $row['idcurso']?>"><?php echo $row['descricao'] ?></option>
                        <?php } ?>

                        <option value="">...</option>

                    </select> </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="datainicio">Data de Inicio:</label>
                        <div class="col-sm-8">
                  <input type="date" name="datainicio" id="datainicio" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="datafim">Data de Final: </label>
                        <div class="col-sm-8">

                  <input type="date" name="datafim" id="datafim" class="form-control"/>
                        </div>

                    </div>
                  </div>

            <div class="modal-footer">

                <button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary pull-right" id="guardar_dados">Guardar Dados</button>

            </div>

            </form>

		</div>
	  </div>
	</div>
	<?php
		}
	?>