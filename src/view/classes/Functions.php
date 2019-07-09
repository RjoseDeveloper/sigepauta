<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 2/4/2019
 * Time: 10:59 PM
 */
//require 'getConection.php';
class Functions {
    private $con;

    public function __construct(){
        $this->con = new mySQLConnection();
    }

    function getCountRow($table,$row){

        $query=mysqli_query($this->con->openConection(),
            "SELECT COUNT($row) AS $row  FROM $table");

        if ($rw=mysqli_fetch_array($query)){
             return  $rw[$row];
        }
    }

    function get_row($table,$row, $id, $equal){

        $query=mysqli_query($this->con->openConection(),
            "select $row from $table where $id='$equal'");
        $rw=mysqli_fetch_array($query);

        $value=$rw[$row];
        return $value;
    }

    function get_rows($id){

        $sql = "SELECT count(utilizador.id) as contador
from utilizador INNER JOIN inscricao ON utilizador.id = inscricao.idutilizador
INNER JOIN turma ON turma.idturma = inscricao.idturma
INNER JOIN curso ON curso.idcurso = turma.idcurso
WHERE curso.idcurso = '$id'";

        $query=mysqli_query($this->con->openConection(),$sql);
        $rw=mysqli_fetch_array($query);
        $value=$rw['contador'];
        return $value;
    }

    function getSumRow($table,$row){

        $query=mysqli_query($this->con->openConection(),"select SUM($row) as contador from $table");
        $rw=mysqli_fetch_array($query);
        $value=$rw['contador'];

        return $value;
    }
}