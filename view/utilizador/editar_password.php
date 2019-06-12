<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing phpUnitTest to older versions of PHP)
    require_once("../../phpUnitTest/password_compatibility_library.php");
}		
		if (empty($_POST['user_id_mod'])){
			$errors[] = "ID vazio";
		}  elseif (empty($_POST['user_password_new3']) || empty($_POST['user_password_repeat3'])) {
            $errors[] = "Password Vazia";
        } elseif ($_POST['user_password_new3'] !== $_POST['user_password_repeat3']) {
            $errors[] = "A senha e a sua repeticao devem ser as mesmas";
        }  elseif (
			 !empty($_POST['user_id_mod'])
			&& !empty($_POST['user_password_new3'])
            && !empty($_POST['user_password_repeat3'])
            && ($_POST['user_password_new3'] === $_POST['user_password_repeat3'])
        ) {
            require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
			
				$user_id=intval($_POST['user_id_mod']);
				$user_password = $_POST['user_password_new3'];

				$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
					
               
					// write new user's data into database
                    $sql = "UPDATE users SET user_password_hash='".$user_password_hash."' WHERE id='".$user_id."'";
                    $query = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query) {
                        $messages[] = "Senha Modificada com sucesso";
                    } else {
                        $errors[] = "Verificamos um problemas ao tentar registar os dados da password";
                    }
                
            
        } else {
            $errors[] = "Um erro ocorreu ao registar os dados";
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