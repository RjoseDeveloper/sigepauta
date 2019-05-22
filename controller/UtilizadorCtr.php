<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/11/2018
 * Time: 6:04 AM
 */

require_once '../model/UtilizadorMDL.php';

class UtilizadorCtr implements Factory {

    public function create($sql,UtilizadorMDL $u, mySQLConnection $db){

        $idsexo= $u->getIdsexo();
        $fullname = $u->getFullname();
        $pass = $u->getPassword();
        $user = $u->getUsername();
        $prev = $u->getIdprevilegio();
        $data = $u->getDataRegisto();

        $stmt = mysqli_prepare($db->openConection(), $sql);
        $rs = mysqli_stmt_bind_param($stmt, 'issdis',$idsexo, $user, $pass, $fullname,$data,$prev);

        if (mysqli_stmt_execute($stmt)){
            echo 'Utilizador inserido com sucesso';
        }else{
            echo 'Problemas na Insercao do Utilizador';
        }
    }

    public function read($_id, mySQLConnection $db){

    }
    public function update($sql,UtilizadorMDL $u, mySQLConnection $db){

    }
    public function delete($_id, mySQLConnection $db){

    }
    public function listall(mySQLConnection $db){

    }

}