<?php
if (isset($con))
{
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header alert-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Avaliacao</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="editar_avaliacao" name="editar_avaliacao">
                        <div id="resultados_ajax2"></div>
                        <div class="form-group">
                            <label for="firstname2" class="col-sm-3 control-label">Tipo da avaliacao</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="tipoavaliacao" name="tipoavaliacao" placeholder="Nombres" required>
                                <input type="hidden" id="mod_id" name="mod_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_name2" class="col-sm-3 control-label">Descricao</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="user_name2" name="user_name2" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_email2" class="col-sm-3 control-label">Grau Academico</label>
                            <div class="col-sm-8">
                                <select name="user_email2" id="user_email2" class="form-control">
                                    <option value="">Selecionar Grau</option>

                                    <?php
                                    $rs = mysqli_query($con, 'SELECT * FROM grau_academico');
                                    while ($row = mysqli_fetch_assoc($rs)){ ?>

                                        <option value="<?php echo $row['idGrau']?>"><?php echo $row['descricao'] ?></option>

                                    <?php } ?>
                                    <option value="">...</option>

                                </select>


                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar Dados</button>
                </div>

                </form>
            </div>
        </div>
    </div>
    <?php
}
?>