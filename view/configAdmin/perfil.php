<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: index.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    require_once '../../QuerySql/GestaoPautasSQL.php';
require_once '../../functions/Conexao.php';

	$title="Configuração | Pautas";
    $main_query = new GestaoPautasSQL();
$db = new mySQLConnection();
	
	$query_empresa=mysqli_query($con,"select * from perfil_instituicao where idperfil=1");
	$row=mysqli_fetch_array($query_empresa)


?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("head.php");?>
  </head>
  <body>
 	<?php
	include("navbar.php");
	?> 
	<div class="container">
      <div class="row">
      <form method="post" id="perfil">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><i class='glyphicon glyphicon-cog'></i> Configuração</h3>
            </div>
            <div class="panel-body">
              <div class="row">
			  
                <div class="col-md-3 col-lg-3 " align="center"> 
				<div id="load_img">
					<img class="img-responsive" src="<?php echo $row['logo_url'];?>" alt="Logo">
					
				</div>
				<br>				
					<div class="row">
  						<div class="col-md-12">
							<div class="form-group">
								<input class='filestyle' data-buttonText="Logo" type="file"
                                       name="imagefile" id="imagefile" onchange="upload_image();">
							</div>
						</div>
						
					</div>
				</div>

                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-condensed">
                    <tbody>
                      <tr>
                        <td class='col-md-3'>Titulo da Instituição:</td>
                        <td><input type="text" class="form-control input-sm" name="nome_instituicao"
                                   value="<?php echo $row['nome_instituicao']?>" required></td>
                      </tr>

                      <tr>
                          <td>Subtitulo da Instituição:</td>
                          <td><input type="text" class="form-control input-sm" name="subtitle"
                                     value="<?php echo $row['nome2instituicao']?>" required></td>
                      </tr>

                      <tr>
                          <td>Director Geral:</td>
                          <td>



                              <select class="form-control input-sm" id="director" name="director">
                                  <?php
                                  $sql_vendedor=mysqli_query($con,$main_query->get_director_inst());
                                  while ($rw=mysqli_fetch_array($sql_vendedor)){
                                      $nombre_vendedor=$rw["nomeCompleto"];
                                      if ($rw["id"]==$row['idutilizador_resp']){
                                          $selected="selected";
                                      } else {
                                          $selected="";
                                      }
                                      ?>
                                      <option value="<?php echo $row['idutilizador_resp'] ?>" <?php echo $selected;?>><?php echo $nombre_vendedor?></option>

                                  <?php
                                  }
                                  ?>
                              </select>
                          </td>
                      </tr>



                      <tr>
                          <td>Director Adj. Pedagogico:</td>
                          <td>

                              <input type="text" class="form-control input-sm" name="pedagogico"
                                     value="<?php echo $row['dirpedagogico']?>" required></td>

                      </tr>

                      <tr>
                        <td>Telefone:</td>
                        <td><input type="number" class="form-control input-sm"
                                   name="contacto" value="<?php echo $row['contacto'];?>" required></td>
                      </tr>



                      <tr>
                        <td>Correio Electronico: </td>
                        <td><input type="email" class="form-control input-sm" name="email" value="<?php echo $row['email']?>" ></td>
                      </tr>

					  <tr>
                        <td>NUIT:</td>
                        <td><input type="text" class="form-control input-sm" required name="nuit" value="<?php echo $row['nuit']?>"></td>

					  <tr>
                        <td>Cidade:</td>
                        <td><input type="text" class="form-control input-sm" name="cidade" value="<?php echo $row["cidade"];?>" required></td>
                      </tr>

					  <tr>
                        <td>Região/Provincia:</td>
                        <td><input type="text" class="form-control input-sm" name="provincia" value="<?php echo $row["provincia"];?>"></td>
                      </tr>

					  <tr>
                        <td>Código Postal:</td>
                        <td><input type="text" class="form-control input-sm" name="codigopostal" value="<?php echo $row["codigopostal"];?>"></td>
                      </tr>

                      </tr>

                      <td>Endereço:</td>
                      <td>

                          <select name="endereco" id="endereco" class="form-control input-sm">

                              <?php
                              $rs = mysqli_query($db->openConection(), 'SELECT * FROM endereco');
                              while ($ro = mysqli_fetch_assoc($rs)){ ?>
                                  <option value="<?php echo $ro['idendereco']?>"><?php echo $ro['bairro'] ?></option>
                              <?php } ?>
                              <option value="">...</option>
                          </select>
                      </td>
                      </tr>


                     
                    </tbody>
                  </table>
                  
                </div>
              </div>
                <div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->
            </div>
                 <div class="panel-footer text-center">

                            <button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-refresh"></i>
                                Actualizar dados</button>

                    </div>
          </div>
        </div>
		</form>
      </div>
	<?php
	include("footer.php");
	?>
  </body>
</html>
<script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
<script>
$( "#perfil" ).submit(function( event ) {
  $('.guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_perfil.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensagem: Carregando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('.guardar_datos').attr("disabled", false);

		  }
	});
  event.preventDefault();
})





		
</script>

<script>
		function upload_image(){
				
				var inputFileImage = document.getElementById("imagefile");
				var file = inputFileImage.files[0];
				if( (typeof file === "object") && (file !== null) )
				{
					$("#load_img").text('Carregando...');
					var data = new FormData();
					data.append('imagefile',file);
					
					
					$.ajax({
						url: "ajax/imagen_ajax.php",        // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success: function(data)   // A function to be called if request succeeds
						{
							$("#load_img").html(data);
							
						}
					});	
				}
				
				
			}
    </script>

