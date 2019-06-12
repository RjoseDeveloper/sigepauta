<?php

    require_once '../dbconf/getConection.php';

   class DocenteController{

       public function read($id){
           $db = new mySQLConnection();
           if ($db){

               $query= "SELECT * FROM `docente` WHERE idDocente ={$id}";
               $result_set = mysqli_query($db->openConection(),$query);
               $found = mysqli_fetch_assoc($result_set);
           return($found);

           }else{
               return(false);
               }

        $db->closeDatabase();
       }

       public function insert_docente($nomec,$user, $grau){

           $db = new mySQLConnection();

           $query = "INSERT INTO `docente`(`idGrauAcademico`, `idUtilizador`, `nomeCompleto`) VALUES (?,?,?)";

           if ($stmt = mysqli_prepare($db->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'iis',$grau, $user, $nomec);

               if(mysqli_stmt_execute($stmt)){
                    echo('Docente inserido com sucesso !');
               }else{
                    echo('Houve problemas na insercao !');
               }

           $db->closeDatabase();

           }

       }

       public function associar_doc_disp($curso,$disp,$doc)
       {
                 $query="INSERT INTO `docentedisciplina`(`idCurso`, `idDisciplina`, `idDocente`, `semestre`) VALUES (?,?,?,?)";
                 $db = new mySQLConnection();
               $semestre = "";
               if (date('m') < 7){$semestre = 1;}else{$semestre = 2;}

               if ($stmt = mysqli_prepare($db->openConection(),$query)){
               $result = mysqli_stmt_bind_param($stmt,'iiii',$curso, $disp, $doc, $semestre);

               if(mysqli_stmt_execute($stmt)){
                    echo('Docente associado com sucesso.');
               }else{
                    echo('problemas na insercao!<br>');
               }


           $db->closeDatabase();

           }
       }


       public function readDadosDocente($fullname,$email, $ctr)
{

      $db = new mySQLConnection();

      switch ($ctr) {

          case 1:

          $query = "SELECT idDocente FROM docente WHERE docente.nomeCompleto= '$fullname' AND docente.email ='$email'";
          $result = mysqli_query($db->openConection(), $query);

          if ($row = mysqli_fetch_assoc($result))
              return ($row['idDocente']);

          break;

          case 2:
           $query = "SELECT username FROM docente WHERE docente.nomeCompleto= '$fullname' AND docente.email = '$email'";
           $result = mysqli_query($db->openConection(), $query);

         if ($row = mysqli_fetch_assoc($result))
              return ($row['username']);

      break;
          default:
              echo "Os seus dados nao conferem com os do nosso repositorio\n por favor tende de novo ou contacte o Registo Academico";
      }
 }

       public function create_user_rac($nc,$cargo,$user,$pass,$mail)
          {
           $query ="INSERT INTO `userrac`(`fullname`, `categoria`, `username`, `password`, `email`) VALUES (?,?,?,?,?)";
             $db = new mySQLConnection();

                       $stmt = mysqli_prepare($db->openConection(),$query);
                       $result = mysqli_stmt_bind_param($stmt,'sssss',$nc,$cargo,$user,$pass,$mail);

                       if (mysqli_stmt_execute($stmt)){
                          echo('Utilizador criado com sucesso');
                       }else{
                          echo('Nao foi possivel criar utilizador');
                       }
                     $db->closeDatabase();

          }

       public function inserir_utilizador($sexo,$emal,$pass,$nomec,$prev)
       {
             $db = new mySQLConnection();

             $query="INSERT INTO `utilizador`(`idSexo`, `username`, `password`,`data_ingresso`,`previlegio`,`nomeCompleto`) VALUES (?,?,?,now(),?,?)";

                       $stmt = mysqli_prepare($db->openConection(),$query);
                       $result = mysqli_stmt_bind_param($stmt,'issis',$sexo,$emal,$pass,$prev,$nomec);

                       if (mysqli_stmt_execute($stmt)){
                          echo('Registado  com sucesso');
                       }else{
                          echo('Nao foi possivel inserir');
                       }


                     $db->closeDatabase();

       }
}

?>
