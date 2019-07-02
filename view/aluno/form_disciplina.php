	<?php
		if (isset($con))
		{

	?>	
			<!-- Modal -->
            <!-- Modal para controlo de erro  -->

            <div class="modal fade" id="registar_disciplina" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header alert-warning">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">ADICIONAR DISCIPLINA</h4>
                        </div>

                        <form class="form-horizontal" name="registar_encarregado" id="registar_encarregado" method="post">

                            <div class="modal-body">

                                <div style="padding: 10px 30px;" >
                                    <div id="resultados_ajax_encarregado"></div>


                                    <label for="curso">Curso:</label>

                                    <select class="form-control" data-style="btn-primary" onchange="lista_turmas(this.value)"
                                            data-width="auto" id="curso" name="curso" required="">
                                        <option value="0">--Seleccionar Curso--</option>
                                        <?php
                                        $resut = mysqli_query($con,"select * from curso");

                                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                                            <option value="<?php echo $row['idcurso'] ?>">
                                                <?php echo utf8_encode($row['descricao']) ?></option>
                                        <?php }  ?>

                                    </select>

                                    <div class="list_turma"> </div>

                                    <label for="turno">Turno:</label>
                                    <select class="form-control"  data-style="btn-primary"
                                            data-width="auto" id="turno" name="turno" required="">
                                        <?php
                                        $resut = mysqli_query($con,'SELECT * FROM turno');
                                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                                            <option value="<?php echo $row['idturno'] ?>">
                                                <?php echo utf8_encode($row['descricao']) ?></option>
                                        <?php }  ?>
                                    </select>

                                    <label for="regime">Regime:</label>
                                    <select class="form-control"  data-style="btn-primary"
                                            data-width="auto" id="regime" name="regime" required="">
                                        <?php
                                        $resut = mysqli_query($con,'SELECT * FROM regime');
                                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                                            <option value="<?php echo $row['idregime'] ?>">
                                                <?php echo utf8_encode($row['descricao']) ?></option>
                                        <?php }  ?>
                                    </select>


                                    </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info" id="btn_inscricao"> Guardar Dados</button>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
	<?php
		}
	?>