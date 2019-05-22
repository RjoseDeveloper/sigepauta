<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['fullname'])) {
           $errors[] = "Nome Completo vazio";
        }else{

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

        $fullname =$_REQUEST['fullname'];
        $aluno=$_REQUEST['idaluno'];
        $birecibo= $_POST['doc'];
        $idade =$_REQUEST['idade'];
        $celular =$_REQUEST['celular'];
        $nivel =$_REQUEST['nivel'];
        $grau =$_REQUEST['parentesco'];
        $local =$_REQUEST['work'];

        $sql = "INSERT INTO encarregado_educacao(idlocaltrabalho, idpessoa, nrdocumento, nivel_escolar,
                                                  contacto, idade, parentesco,nomeCompleto) VALUES
                                                  ('" .$local. "','" .$aluno. "','" .$birecibo. "'
                                                  ,'".$nivel. "','" .$celular. "','" .$idade. "','" .$grau. "','" .$fullname. "')";

		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Encarregado adicionado com sucesso.";
			} else{
				$errors []= "Erro ocorreu ao tentar registar os dados.".mysqli_error($con);
			}
		}
		
		if (isset($errors)){?>
            
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
			if (isset($messages)){?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Operação Efectuada</strong>
						<?php
							foreach ($messages as $message) {echo $message;}?>
				</div>
				<?php
			}

?>