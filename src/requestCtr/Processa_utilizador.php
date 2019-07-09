<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/6/2018
 * Time: 9:07 PM
 */

require_once('../dbconf/getConection.php');
require_once('../Query/UtilizadorSQL.php');

$sql_utilizador = new UtilizadorSQL();
$db = new mySQLConnection();

$estado = 2;
$acao = $_GET['acao'];

switch ($acao) {

    case 1:

        $idsexo= $_REQUEST['sexo'];
        $fullname = $_REQUEST['fullname'];
        $pass = $_REQUEST['password'];
        $user = $_REQUEST['username'];
        $prev = $_REQUEST['previlegio'];

        $stmt = mysqli_prepare($db->openConection(), $sql_utilizador->insert());
        $rs = mysqli_stmt_bind_param($stmt, 'issis',$idsexo, $user, $pass,$prev,$fullname);

        if (mysqli_stmt_execute($stmt)){
            echo 'Utilizador inserido com sucesso';
        }else{
            echo 'Problemas na Insercao do Utilizador';
        }

        break;

    default:
        echo 'Nenhum paraentro enviado';
}