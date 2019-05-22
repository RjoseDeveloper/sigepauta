<?php

function get_row($id,mySQLConnection $db){

    $sql = "SELECT count(utilizador.id) as contador
from utilizador INNER JOIN inscricao ON utilizador.id = inscricao.idutilizador
INNER JOIN turma ON turma.idturma = inscricao.idturma
INNER JOIN curso ON curso.idcurso = turma.idcurso
WHERE curso.idcurso = '$id'";

	$query=mysqli_query($db->openConection(),$sql);
	$rw=mysqli_fetch_array($query);
	$value=$rw['contador'];
	return $value;
}

function getCountRow($table,$row, mySQLConnection $db){
        $query=mysqli_query($db->openConection(),"select COUNT($row) as contador from $table");
        $rw=mysqli_fetch_array($query);
        $value=$rw['contador'];

    return $value;
}

function getSumRow($table,$row, mySQLConnection $db){
    $query=mysqli_query($db->openConection(),"select SUM($row) as contador from $table");
    $rw=mysqli_fetch_array($query);
    $value=$rw['contador'];

    return $value;
}
?>