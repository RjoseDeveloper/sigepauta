<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 9/24/2018
 * Time: 11:49 AM
 */

class Processa_gestao_academica {



    function listarCurso(mySQLConnection $db,$query){
        $vector = array();

        $result = mysqli_query($db->openConection(), $query);
        while($row = mysqli_fetch_assoc($result)){
            $vector[] = array('idcurso'=>$row['idcurso'],
                'descricao'=>$row['descricao']);
        }
        if ($vector!= null){
            return $vector;
        }

            }

}