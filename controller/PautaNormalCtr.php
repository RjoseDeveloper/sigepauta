<?php
   class PautaNormalController{
       private $db;
       public function __construct(){
           $this->db = new mySQLConnection();
       }

       public function read($id){
		   if ($this->db){
			   $query= "SELECT * FROM pautaNormal WHERE idpautaNormal ={$id}";
			   $result_set = mysqli_query($this->db->openConection(),$query);
			   $found = mysqli_fetch_assoc($result_set);
               return($found);

		   }else{return(false);}
		$this->db->closeDatabase();
       }

       public function insert($idDisp,$avaliacao, $curso){

           $semetre = date('m') < 6 ? 1:2;    // caso o mes corrente for menor que um 6 recebe 1 -primeiro semestre
           $estado = 1; // estado 1 pauta nao publicada
           $data = date('Y-m-d');
           $data2 = null;
           $sql = "INSERT INTO `pautanormal`(`idcurso`, `idDisciplina`, `idTipoAvaliacao`,`estado`, `dataReg`, `dataPub`, `idsemestre`,`idusers`)
                    VALUES (?,?,?,?,?,?,?,?)";

           $data2 = null;
           //echo $sql;
           $stmt = mysqli_prepare($this->db->openConection(),$sql);
           $result = mysqli_stmt_bind_param($stmt,'iiiissii',$curso, $idDisp,$avaliacao,$estado,$data, $data2,$semetre, $_SESSION['id']);

           if (mysqli_stmt_execute($stmt)){
               $_SESSION['last_id']= mysqli_stmt_insert_id($stmt);
               //echo 'id '. $_SESSION['last_id'];
               $sql = "UPDATE data_avaliacao SET status = 2 WHERE id_data='".$avaliacao."'";
               $rs = mysqli_query($this->db->openConection(), $sql);
               if($rs){
                   echo 'Data avaliacao actualizada com sucesso';
               }else{
                   echo 'Nao foi error';
               }
           }else{echo 'error';}
       }

       public function update($estado, $idpauta){
          		   $query = "UPDATE `pautanormal` SET `estado`= ?,`dataPub`= now() WHERE `idPautaNormal`= ?";
		   $stmt = mysqli_prepare($this->db->openConection(),$query);
		   $result = mysqli_stmt_bind_param($stmt,'ii',$estado, $idpauta);
		   if (mysqli_stmt_execute($stmt)){
		   		echo('Pauta publicada com sucesso');
		   }else {
               echo('Nao foi possivel publicar a pauta');
           }
       }

       public function delete($id){

		     $query = "DELETE FROM `pautanormal` WHERE `idPautaNormal`= ?";
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

		   $query= "SELECT * FROM pautaNormal";
		   $result_set = mysqli_query($this->db->openConection(),$query);
		   while ($row = mysqli_fetch_assoc($result_set)){
				echo $row['classificacao'];
			}
       }
       public function getMaxRowValue(){

		   $query = "SELECT pautanormal.idPautaNormal as contador FROM pautanormal
                      ORDER BY pautanormal.idPautaNormal DESC LIMIT 1";
		   $result_set = mysqli_query($this->db->openConection(),$query);
		   if ($row = mysqli_fetch_assoc($result_set)){
	                   return  $row['contador'];
	              }
		$this->db->closeDatabase();
	}
   }

