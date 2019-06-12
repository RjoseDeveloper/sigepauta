<?php

   require_once '../dbconf/getConection.php';
   global $mydb;

   class PautaExameRecorrenciaController{


       public function read($id){
		   $mydb = new mySQLConnection();
		   if ($mydb){

			   $query= "SELECT * FROM examerecorrencia` WHERE idpautaNormal ={$id}";
			   $result_set = mysqli_query($mydb->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);
		   return($found);

		   }else{
			   return(false);
			   }

		$mydb->closeDatabase();
       }

       public function insert($idpauta,$estado,$notaRec, $notafinal, $estudante){

		   $mydb = new mySQLConnection();
		   $query = "INSERT INTO `examerecorrencia`(`notaFinal`, `notaRec`, `estado`, `idPautaNormal`, `idEstudante`)
		   		      VALUES (?,?,?,?, ?)";

		   $stmt = mysqli_prepare($mydb->openConection(),$query);
		   mysqli_stmt_bind_param($stmt,'ddiii',$notafinal, $notaRec,$estado,$idpauta, $estudante);

    	   if (mysqli_stmt_execute($stmt)){
		   		echo('Nota inserida com sucesso<br>');
		   }else{
			   echo('insucesso na insercao de nota<br>');
			 }

	   }


       public function update($idpauta,$estado,$notaRec,$idRec, $notafinal, $estudante){

		   $mydb = new mySQLConnection();
		   $query = "UPDATE `examerecorrencia` SET `notaRec`= ?,
												   `notaFinal`= ?,`estado`= ?,
												   `idPautaNormal`= ?,
												   `idEstudante`= ? WHERE `idExameRec`= ?";

		   $stmt = mysqli_prepare($mydb->openConection(),$query);
            mysqli_stmt_bind_param($stmt,'ddiiii',$notaRec,$notafinal, $estado, $idpauta, $estudante, $idRec);

           if (mysqli_stmt_execute($stmt)){

                echo('Nota actualizada com sucesso<br>');
           }else{
               echo('insucesso na actualizacao da nota<br>');
             }
		    $mydb->closeDatabase();


       }

       public function delete($id){

		   	 $mydb = new mySQLConnection();

		     $query = "DELETE FROM 'examerecorrencia` WHERE `idPautaNormal`= ?";
		     if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
			   $result = mysqli_stmt_bind_param($stmt,'i',$id);
			   if(mysqli_stmt_execute($stmt)){
					echo('removido com sucesso!');
		  	   }else{
			   		echo('problemas na remocao!');
			   }
		    $mydb->closeDatabase();
           }
       }

       public function selectAll(){

		   $mydb = new mySQLConnection();
		   $query= "SELECT * FROM 'examerecorrencia`";
		   $result_set = mysqli_query($mydb->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){

				echo $row['classificacao'];
			}

       }

	   public function getMaxRowValue(){
		   $mydb = new mySQLConnection();
		   $query = "SELECT MAX('examerecorrencia`.idRec) as contador FROM 'examerecorrencia`;";

		   $result_set = mysqli_query($mydb->openConection(),$query);
		   if ($row = mysqli_fetch_assoc($result_set)){

				return  $row['contador'];
			}else{
				return 0;
			}
		$mydb->closeDatabase();
	}

       public function insertRec($idnota,$notaf,$estado)
    {

        $mydb = new mySQLConnection();

        $query ="INSERT INTO `examerecorrencia`(`idExameRec`, `notafinal`, `estado`) VALUES (?,?,?)";

        $stmt = mysqli_prepare($mydb->openConection(),$query);
        mysqli_stmt_bind_param($stmt,'idi',$idnota,$notaf,$estado);
        mysqli_stmt_execute($stmt);

    }

   }

?>

<?php

	$var = new PautaExameRecorrenciaController();
	//$var->insert(98,1,132,130);

?>
