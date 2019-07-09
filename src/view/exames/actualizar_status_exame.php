<?php

/*-------------------------
Autor: rjose
---------------------------*/
/* Connect To Database*/
require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
require_once("../../Query/DocenteSQL.php");

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
$inscricao = (isset($_REQUEST['id'])&& $_REQUEST['id'] !=NULL)?$_REQUEST['id']:'';

//mudando status do exame extraordinario
if($action == 'ajax') {
//    echo $action;
    $result = mysqli_query($con, "SELECT * FROM inscricao
                                   WHERE inscricao.idinscricao='$inscricao'");
    $linha = mysqli_fetch_array($result);

    if ($linha['status_exame'] == 'HABILITADO') {
        $query = mysqli_query($con, "UPDATE inscricao
                                      set status_exame='NAO HABILITADO'
                                    WHERE inscricao.idinscricao='$inscricao'");

        $aluno=mysqli_query($con, "select nomeCompleto from inscricao i,
                                  utilizador u where u.id=i.idutilizador and i.idinscricao='$inscricao'");

        $row = mysqli_fetch_array($aluno);

        $nomeAluno=$row['nomeCompleto'];
        $messages[] = "O Estado do Estudante $nomeAluno foi Desabilitado com Sucesso.";
    } else {
        $query = mysqli_query($con, "UPDATE inscricao
                                      set status_exame='HABILITADO'
                                    WHERE inscricao.idinscricao='$inscricao'");

        $aluno=mysqli_query($con, "select nomeCompleto from inscricao i,
                                  utilizador u where u.id=i.idutilizador and i.idinscricao='$inscricao'");

        $row = mysqli_fetch_array($aluno);

        $nomeAluno=$row['nomeCompleto'];

        $messages[] = "O Estado do Estudante $nomeAluno foi habilitado com Sucesso.";
    }
}

 ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Operação Efectuada: </strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
