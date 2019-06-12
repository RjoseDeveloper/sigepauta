<?php
	include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nome_instituicao'])) {
           $errors[] = "Nome da Empresa esta Vazio";
        }else if (empty($_POST['contacto'])) {
           $errors[] = "Contacto esta vazio";
        } else if (empty($_POST['email'])) {
           $errors[] = "E-mail esta vazio";
        } else if (empty($_POST['nuit'])) {
           $errors[] = "NUIT esta vazio";
        }  else if (empty($_POST['endereco'])) {
           $errors[] = "Endereço esta vazío";
        } else if (empty($_POST['cidade'])) {
           $errors[] = "Cidade esta vazio";
        }   else if (
			!empty($_POST['nome_instituicao']) &&
			!empty($_POST['contacto']) &&
			!empty($_POST['email']) &&
			!empty($_POST['nuit']) &&
			!empty($_POST['endereco']) &&
			!empty($_POST['cidade'])
		){
		/* Connect To Database*/
		require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre_empresa=mysqli_real_escape_string($con,(strip_tags($_POST["nome_instituicao"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["contacto"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
		$impuesto=mysqli_real_escape_string($con,(strip_tags($_POST["nuit"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["endereco"],ENT_QUOTES)));
		$ciudad=mysqli_real_escape_string($con,(strip_tags($_POST["cidade"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["provincia"],ENT_QUOTES)));
		$codigo_postal=mysqli_real_escape_string($con,(strip_tags($_POST["codigopostal"],ENT_QUOTES)));
		$nome2inst= $_POST['subtitle'];
        $diretor= $_POST['director'];
        $pedagogico= $_POST['pedagogico'];

		$sql="UPDATE perfil_instituicao SET nome_instituicao='".$nombre_empresa."', contacto='".$telefono."', 
		email='".$email."', nuit='".$impuesto."', idendereco ='".$direccion."',cidade='".$ciudad."', 
		provincia='".$estado."', dirpedagogico='".$pedagogico."',idutilizador_resp='".$diretor."',
		codigopostal='".$codigo_postal."', nome2instituicao = '".$nome2inst."' WHERE idperfil='1'";


		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Dados actualizados com sucesso.";
			} else{
				$errors []= "Sentimos que algo não conforme tente novamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconhecido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Operação Efectuada</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>