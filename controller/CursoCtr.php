<?php

    require_once '../../dbconf/getConection.php';

   class CursoController{

       public function insert($dir,$nome,$facul,$codigo){

           $mydb = new mySQLConnection();
           $query = "INSERT INTO `curso`( `coordenador`, `descricao`, `idperfil_instituicao`, `codigo`) VALUES (?,?,?,?)";

               $stmt = mysqli_prepare($mydb->openConection(),$query);
               $result = mysqli_stmt_bind_param($stmt,'isii',$dir,$nome,$facul,$codigo);

               if(mysqli_stmt_execute($stmt)){
                    echo 'Curso Criado com sucesso.';
               }else{
                    echo 'Encontramos problemas ao Criar  o Curso';
               }
           $mydb->closeDatabase();
       }
}

?>