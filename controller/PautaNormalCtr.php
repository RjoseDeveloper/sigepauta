<?php
require_once '../../dbconf/getConection.php';

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
        $db = new mySQLConnection();
           $semetre = date('m') < 6 ? 1:2;    // caso o mes corrente for menor que um 6 recebe 1 -primeiro semestre
           $estado = 1; // estado 1 pauta nao publicada
           $data = date('Y-m-d');
           $data2 = null;
           $sql = "INSERT INTO `pautanormal`(`idcurso`, `idDisciplina`, `idTipoAvaliacao`,`estado`, `dataReg`, `dataPub`, `idsemestre`,`idusers`)
                    VALUES (?,?,?,?,?,?,?,?)";

           $data2 = null;
           //echo $sql;
           $stmt = mysqli_prepare($db->openConection(),$sql);
           $result = mysqli_stmt_bind_param($stmt,'iiiissii',$curso, $idDisp,$avaliacao,$estado,$data, $data2,$semetre, $_SESSION['id']);

           if (mysqli_stmt_execute($stmt)){
               $_SESSION['last_id']= mysqli_stmt_insert_id($stmt);
               //echo 'id '. $_SESSION['last_id'];
               $sql = "UPDATE data_avaliacao SET status = 2 WHERE id_data='".$avaliacao."'";
               $rs = mysqli_query($db->openConection(), $sql);
               if($rs){
                   echo 'Data avaliacao actualizada com sucesso';
               }else{
                   echo 'Nao foi error';
               }
           }else{echo 'error';}
       }

       public function update($estado, $idpauta){
        $db = new mySQLConnection();
            $query = "UPDATE `pautanormal` SET `estado`= '$estado',`dataPub`= now() WHERE `idPautaNormal`= '$idpauta'";
		//    $stmt = mysqli_prepare($db->openConection(),$query);
        //    $result = mysqli_stmt_bind_param($stmt,'ii',$estado, $idpauta);
        $query_new_update = mysqli_query($db->openConection(), $query);
		   if ($query_new_update){
		   		echo('Pauta publicada com sucesso');
		   }else {
               echo('Nao foi possivel publicar a pauta');
           }
       }

       public function delete($id){
        $db = new mySQLConnection();
        
		     $query = "DELETE FROM `pautanormal` WHERE `idPautaNormal`= '$id";
		    //  if ($stmt = mysqli_prepare($db->openConection(),$query)){
            //    $result = mysqli_stmt_bind_param($stmt,'i',$id);
            $query_new_delete = mysqli_query($db->openConection(),$query);
			   if($query_new_delete){
					echo('removido com sucesso!');
		  	   }else{
			   		echo('problemas na remocao!');
			   }
		    $db->closeDatabase();
           
       }

       public function selectAll(){

		   $query= "SELECT * FROM pautaNormal";
		   $result_set = mysqli_query($this->db->openConection(),$query);
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