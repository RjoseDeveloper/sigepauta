<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 2/4/2019
 * Time: 10:59 PM
 */
//require 'Conexao.php';
class functions {

    function getCountRow($table,$row){

        $db = new mySQLConnection();

        $query=mysqli_query($db,"select COUNT($row) from $table");
        echo "select COUNT($row) from $table";
        if ($rw=mysqli_fetch_array($query)){
             return  $rw[$row];
        }
    }
}