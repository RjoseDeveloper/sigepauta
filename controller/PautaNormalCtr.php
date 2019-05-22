<?php

    require_once '../functions/db.php';
    require_once '../functions/conexion.php';
   

   class PautaNormalController{

       public function read($id){
		   $db = new mySQLConnection();
		   if ($db){

			   $query= "SELECT * FROM pautaNormal WHERE idpautaNormal ={$id}";
			   $result_set = mysqli_query($db->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);

               return($found);

		   }else{return(false);}
		$db->closeDatabase();
       }

       public function insert($idDisp,$avaliacao, $curso){

           $semetre = date('m') < 6 ? 1:2;    // caso o mes corrente for menor que um 6 recebe 1 -primeiro semestre
           $estado = 1; // estado 1 pauta nao publicada
           $data = date('Y-m-d');
           $data2 = null;
           global $con;

           //$db = new mySQLConnection();

           $sql = "INSERT INTO `pautanormal`(`idcurso`, `idDisciplina`, `idTipoAvaliacao`,`estado`, `dataReg`, `dataPub`, `idsemestre`,`idusers`)
                    VALUES (?,?,?,?,?,?,?,?)";

           $data2 = null;
           //echo $sql;

           $stmt = mysqli_prepare($con,$sql);
           $result = mysqli_stmt_bind_param($stmt,'iiiissii',$curso, $idDisp,$avaliacao,$estado,$data, $data2,$semetre, $_SESSION['id']);

           if (mysqli_stmt_execute($stmt)){
               $_SESSION['last_id']= mysqli_stmt_insert_id($stmt);
               //echo 'id '. $_SESSION['last_id'];
               $sql = "UPDATE data_avaliacao SET status = 2 WHERE id_data='".$avaliacao."'";
               $rs = mysqli_query($con, $sql);
               if($rs){
                   echo 'Data avaliacao actualizada com sucesso';
               }else{
                   echo 'Nao foi error';
               }
           }else{echo 'error';}
       }

       public function update($estado, $idpauta){
           global $con;

		   $query = "UPDATE `pautanormal` SET `estado`= ?,`dataPub`= now() WHERE `idPautaNormal`= ?";
		   $stmt = mysqli_prepare($con,$query);
		   $result = mysqli_stmt_bind_param($stmt,'ii',$estado, $idpauta);
		   if (mysqli_stmt_execute($stmt)){
		   		echo('Pauta publicada com sucesso');
		   }else {
               echo('Nao foi possivel publicar a pauta');
           }
       }

       public function delete($id){
		   	 $db = new mySQLConnection();
		     $query = "DELETE FROM `pautanormal` WHERE `idPautaNormal`= ?";
		     if ($stmt = mysqli_prepare($db->openConection(),$query)){
			   $result = mysqli_stmt_bind_param($stmt,'i',$id);
			   if(mysqli_stmt_execute($stmt)){
					echo('removido com sucesso!');
		  	   }else{
			   		echo('problemas na remocao!');
			   }
		    $db->closeDatabase();
           }
       }

       public function selectAll(){
		   $db = new mySQLConnection();
		   $query= "SELECT * FROM pautaNormal";
		   $result_set = mysqli_query($db->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){
				echo $row['classificacao'];
			}
       }
       public function getMaxRowValue(){
		   $db = new mySQLConnection();
		   $query = "SELECT pautanormal.idPautaNormal as contador FROM pautanormal
                      ORDER BY pautanormal.idPautaNormal DESC LIMIT 1";
		   $result_set = mysqli_query($db->openConection(),$query);
		   if ($row = mysqli_fetch_assoc($result_set)){
	                   return  $row['contador'];
	              }
		$db->closeDatabase();
	}
   }

