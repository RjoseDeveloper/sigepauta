<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['detalhe'])) {
           $errors[] = "Nome do detalhe Vazio";
        } else if (empty($_POST['valor'])){
			$errors[] = "Valor esta vazio";
		} else if ($_POST['orcamento']==""){
			$errors[] = "Orcamento esta vazio";
		}

		/* Connect To Database*/
		require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos

		$detailss=mysqli_real_escape_string($con,(strip_tags($_POST["detalhe"],ENT_QUOTES)));

		$iduser= $_SESSION['id'];
        $orcamento = $_POST['orcamento'];
		$date_added=date("Y-m-d");
        $valors=intval($_POST['valor']);

        if ($_POST['valor'] == "orc"){

            $sql="INSERT INTO orcamento(valor,data_lacamento,idutilizador,details)
                      VALUES('".$orcamento."','".$date_added."','" . $iduser. "','" .$detailss. "')";
            $query_new_insert = mysqli_query($con,$sql);

        }else{


            $sql="INSERT INTO despesa(details, data_reg, valor, idorcamento, idutilizador)
                      VALUES('".$detailss."','".$date_added."','" . $valors. "','" .$orcamento. "','" .$iduser. "')";
            $query_new_insert = mysqli_query($con,$sql);
        }

        if ($query_new_insert) {
            $messages[] = "Dados Adiconados com successo.";
            $last_row = $con->insert_id;
        } else{
            $errors []= "Problemas no Cadastro tente novamente.".mysqli_error($con);
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