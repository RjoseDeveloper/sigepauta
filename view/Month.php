<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 10/6/2017
 * Time: 11:45 AM
 */

require_once 'enotas/functions/Conexao.php';

echo date('n');
$mydb = new mySQLConnection();
$sql = "SELECT idplano FROM planoavaliacao ORDER BY idplano DESC LIMIT 1";
$plano = mysqli_fetch_assoc(mysqli_query($mydb->openConection(),$sql));
echo 'Data F: '. $plano['idplano'];
