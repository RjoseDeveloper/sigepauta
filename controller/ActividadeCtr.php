<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/30/2018
 * Time: 7:03 AM
 */

require '../dbconf/getConection.php';
class MannagerController {

    private $conn;

    public function __construct(){
        $this->conn= new mySQLConnection();
    }

    public function create($descricao){

        $query = "INSERT INTO actividade (descricao) VALUE (?)";

        $stmt = mysqli_prepare($this->conn->openConection(),$query);
        $result = mysqli_stmt_bind_param($stmt,'s',$descricao);

        if(mysqli_stmt_execute($stmt)){echo 'Actividade Criada com sucesso.';
        }else{echo 'Encontramos problemas ao Criar a actividade';}

        $this->conn->closeDatabase();
    }

}