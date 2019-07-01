<?php
if (isset($con))
{
    ?>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Criar Avaliacao</h4>
                </div>
                <hr>
                <div class="modal-body container">
                    <form class="form-horizontal" method="post" id="guardar_avaliacao" name="guardar_avaliacao">
                        <div id="resultados_ajax"></div>

                        <div class="col-md-6">

                        <label for="grau">NOME DE AVALIACAO: </label>
                        <input type="text" id="descricao" name="descricao" class="form-control" />
                        </div>

                </div>


                <div class="modal-footer">

                        <button type="submit" class="btn btn-primary pull-right" id="guardar_datos">Guardar</button>

                </div>



                    </form>



            </div>
        </div>
    </div>
    <?php
}
?>