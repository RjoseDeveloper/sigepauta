<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 4/22/2018
 * Time: 1:36 PM
 */

   session_start();

   require_once('../functions/Conexao.php');
   require_once('../QuerySql/GestaoPautasSQL.php');

    $query = new GestaoPautasSQL();
    $db = new mySQLConnection();
$q = new QuerySql();
$idDoc = $q->getDoc_id($_SESSION['username']);

    $semestre = date('m') < 7 ? '1º':' 2º';
    $ano = date('Y');

    $acao = $_POST['acao'];
    switch ($acao) {
        case 1:

            $data_ini = $_POST['data_ini'];
            $data_fim = $_POST['data_fim'];
            $actividade = $_POST['actividade'];


            $stmt = mysqli_prepare($db->openConection(), $query->insert_actividade());
            $rs = mysqli_stmt_bind_param($stmt, 'sssi',$actividade,$data_ini, $data_fim, $idDoc);

            if (mysqli_stmt_execute($stmt)){
                echo 'Actividade inserido com sucesso';
            }else{
                echo 'Problemas na Insercao da actividade';
            }

            break;
    }
?>