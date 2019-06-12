	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade modal-lg" id="list_encarregado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">

		  <div class="modal-header alert-info">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Encarregado de Educação</h4>
		  </div>

		  <div class="modal-body">

              <div class="container" style="padding: 10px 30px">
              <div class="table-responsive col-md-6">
                      <div class="list_encarregado"></div>
                  </div>
              </div>

          </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
		  </div>

		</div>
	  </div>
	</div>
	<?php
		}
	?>