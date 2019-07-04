<?php
 require_once '../dbconf/getConection.php';

   class EstudanteNotaController{

       public function read($id){
		$db = new mySQLConnection();
		   if ($db){

			   $query= "SELECT * FROM estudante_nota WHERE idPautaNormal={$id}";
			   $result_set = mysqli_query($db->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);

               return(print_r($found));

		   }else{return(false);}
		$db->closeDatabase();
       }

	   //In this Place use this form

	    public function insertF1($idp, $nota, $idest){
			$db = new mySQLConnection();
 		   $query = 'INSERT INTO `estudante_nota`(`idaluno`, `idPautaNormal`, `nota`) VALUES (?,?,?)';

		   $stmt = mysqli_prepare($db->openConection(),$query);
		   $res= mysqli_stmt_bind_param($stmt,'iid',$idest, $idp, $nota);

    	   if (mysqli_stmt_execute($stmt)){
		   		echo('Pauta Enviada com Sucesso<br>');
		   }else{
			   echo('Lamentamos Houve um erro no envio da Pauta<br>');
			 }
            //echo 'id estudante: '. $idest;
	   }

       /*actualuza nota estudante*/

       public function update($idNota, $nota){
		$db = new mySQLConnection();
		   $query = "UPDATE estudante_nota SET nota = '$nota' WHERE idNota = '$idNota'";
		  
        //    $stmt = mysqli_prepare($this->db->openConection(),$query);
        //    $result = mysqli_stmt_bind_param($stmt,'id',$idNota, $nota);
		
		$query_new_update = mysqli_query($db->openConection(),$query);
		if ($query_new_update) {

                echo('Nota actualizada com sucesso para ['.$nota.']');
           }else{
               echo('Nao foi possivel publicar a pauta');
             }
         $db->closeDatabase();

       }

       public function delete($id){

		 	$db = new mySQLConnection();
		     $query = "DELETE FROM `estudante_nota` WHERE `idPautaNormal`= '$id'";
			 $query_new_delete = mysqli_query($db->openConection(),$query);
			 
			//  if ($stmt = mysqli_prepare($this->db->openConection(),$query)){
			//    $result = mysqli_stmt_bind_param($stmt,'i',$id);
			
			   if($query_new_delete){
					echo('removido com sucesso!');
		  	   }else{
			   		echo('problemas na remocao!');
			   }
		    $db->closeDatabase();
           
       }

       public function selectAll(){

		   $db = new mySQLConnection();
		   $query= "SELECT * FROM `estudante_nota`";
		   $result_set = mysqli_query($db->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){
				echo $row['nota'];
			}

       }
   }

?>