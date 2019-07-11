<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/30/2018
 * Time: 7:03 AM
 */

require_once './src/dbconf/getConection.php';
class MannagerController {
 
    public function create($descricao){
        $conn = new mySQLConnection();
        
        $query = "INSERT INTO actividade (descricao) VALUE (?)";
        $stmt = mysqli_prepare($conn->openConection(),$query);
        $result = mysqli_stmt_bind_param($stmt,'s',$descricao);

        if(mysqli_stmt_execute($stmt)){
            echo 'Actividade Criada com sucesso.';
        }else{
            echo 'Encontramos problemas ao Criar a actividade';
        }

        $conn->closeDatabase();
    }

}
