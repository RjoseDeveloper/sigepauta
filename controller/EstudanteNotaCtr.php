<?php


   class EstudanteNotaController{
       private $db;

       public function __construct(){
           $this->db = new mySQLConnection();
       }

       public function read($id){
		   if ($this->db){

			   $query= "SELECT * FROM estudante_nota WHERE idPautaNormal={$id}";
			   $result_set = mysqli_query($this->db->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);

               return(print_r($found));

		   }else{return(false);}
		$this->db->closeDatabase();
       }

	   //In this Place use this form

	    public function insertF1($idp, $nota, $idest){

 		   $query = 'INSERT INTO `estudante_nota`(`idaluno`, `idPautaNormal`, `nota`) VALUES (?,?,?)';

		   $stmt = mysqli_prepare($this->db->openConection(),$query);
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

           $query = "UPDATE estudante_nota SET nota = ? WHERE idNota = ?";
           $stmt = mysqli_prepare($this->db->openConection(),$query);
           $result = mysqli_stmt_bind_param($stmt,'id',$idNota, $nota);
           if (mysqli_stmt_execute($stmt)){

                echo('Nota actualizada com sucesso para ['.$nota.']');
           }else{
               echo('Nao foi possivel publicar a pauta');
             }
         $this->db->closeDatabase();

       }

       public function delete($id){

		     $query = "DELETE FROM `estudante_nota` WHERE `idPautaNormal`= ?";
		     if ($stmt = mysqli_prepare($this->db->openConection(),$query)){
			   $result = mysqli_stmt_bind_param($stmt,'i',$id);
			   if(mysqli_stmt_execute($stmt)){
					echo('removido com sucesso!');
		  	   }else{
			   		echo('problemas na remocao!');
			   }
		    $this->db->closeDatabase();
           }
       }

       public function selectAll(){

		   $db = new mySQLConnection();
		   $query= "SELECT * FROM `estudante_nota`";
		   $result_set = mysqli_query($this->db->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){
				echo $row['nota'];
			}

       }
   }

?>
