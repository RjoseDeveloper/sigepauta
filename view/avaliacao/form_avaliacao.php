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
                    <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Criar Avaliacao</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardar_avaliacao" name="guardar_avaliacao">
                        <div id="resultados_ajax"></div>


                        <div class="form-group">
                            <label for="grau" class="col-sm-5 control-label">Nome da avaliacao</label>
                                <input type="text" id="descricao" name="descricao" class="col-sm-7" >
                            </div>


                <div class="modal-footer">
                    <div class="col-sm-6">
                        <br>

                        <button type="submit" class="btn btn-primary pull-right" id="guardar_datos">Guardar</button>

                    </div>
                </div>

                </div>

                </form>

            </div>
        </div>
    </div>
    <?php
}
?>