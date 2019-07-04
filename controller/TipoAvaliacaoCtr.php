<?php

  require_once '../dbconf/getConection.php';

   class TipoAvaliacaoController{


       public function create($descricao){
          $db = new mySQLConnection();
          
           $estado = 2;  // estado = 1 avaliacao ainda nao foi validade pelo director do curso.
                          //um if soh para assegurar a condicao na execuacao
           $queries = "INSERT INTO `tipoavaliacao`(`descricao`,`estado`) VALUES (?,?)";
           $stmt = mysqli_prepare($db->openConection(),$queries);
           mysqli_stmt_bind_param($stmt,'si',$descricao, $estado);

           if(mysqli_stmt_execute($stmt)){
               echo 'Sucesso !! Aguarde Homologação Pedagógica ou Direcção do Curso';
           }else{
            echo 'Ocorreu um erro ao registar avaliacao';
        }
       }
       public function metodo($id){
        $mydb = new mySQLConnection();
           
            
           if ($mydb){
               $query= "SELECT * FROM `professor` WHERE idprofessor ={$id}"; 
               $result_set = mysqli_query($mydb->openConection(),$query);
               $found = mysqli_fetch_assoc($result_set);   
               
            return($found);

           }else{
               return(false);
               }
           

        $mydb->closeDatabase();
    }
       public function read($id){
           $mydb = new mySQLConnection();
           
            
           if ($mydb){
               $query= "SELECT * FROM `professor` WHERE idprofessor ={$id}"; 
               $result_set = mysqli_query($mydb->openConection(),$query);
               $found = mysqli_fetch_assoc($result_set);   
               
            return($found);

           }else{
               return(false);
               }
           

        $mydb->closeDatabase();
       }

       public function insert($avaliacao,$discp,$qtd){

           $mydb = new mySQLConnection();

           $query = "INSERT INTO `tipoavaliacao`(`idTipoAvaliacao`, `descricao`, `estado`)
                                VALUES (?,?)";

        //    $stmt = mysqli_prepare($mydb->openConection(),$query);
        //    $result = mysqli_stmt_bind_param($stmt,'iii',$avaliacao,$discp,$qtd);
        $query_new_insert = mysqli_query($mydb->openConection(), $query);

           if($query_new_insert){
                echo('registado com sucesso!<br>');
           }else{
                echo('problemas na insercao!<br>');
           }
           $mydb->closeDatabase();

       }

       public function update($peso, $id){

              $mydb = new mySQLConnection();

               $query = "UPDATE tipoavaliacao SET peso = '$peso' WHERE idTipoAvaliacao = '$id'";
            //    $stmt = mysqli_prepare($mydb->openConection(),$query);
            //    $result = mysqli_stmt_bind_param($stmt,'ii',$peso,$id);
            $query_new_update=mysqli_query($mydb->openConection(), $query);

               if($query_new_update){
                    echo('Actualizado com Sucesso!<br>');

               }else{
                   echo('Problemas na codigo!<br>');
               }
            $mydb->closeDatabase();
       }

       public function delete($id){

             $mydb = new mySQLConnection();

             $query = "DELETE FROM `tipoavaliacao` WHERE `idTipoAvaliacao`= '$id";
             $query_new_delete=mysqli_query($mydb->openConection(), $query);
            //  if ($stmt = mysqli_prepare($mydb->openConection(),$query)){
            //    $result = mysqli_stmt_bind_param($stmt,'i',$id);
            
               if($query_new_delete){
                    echo('Plano removido com sucesso!');
               }else{
                    echo('problemas na remocao!');
               }
            $mydb->closeDatabase();
           
       }

       public function selectAll(){

           $mydb = new mySQLConnection();
           $query= "SELECT * FROM tipoavaliacao";
           if ($mydb){
              $result_set = mysqli_query($mydb->openConection(),$query);
           }
        return($result_set);

       }
      
   }