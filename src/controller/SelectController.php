<?php
require_once '../dbconf/getConection.php';

class SelectController{

    public function selectDataFromTable(){
        $mydb = new mySQLConnection();
        
        $query = 'SELECT nome as tabela From Testar Where id = 1';
        $result = mysqli_query($mydb->openConection(), $query);
        $row = mysqli_fetch_array($result);
        $nome= $row['tabela'];
        return $nome;
        
    }
}


?>