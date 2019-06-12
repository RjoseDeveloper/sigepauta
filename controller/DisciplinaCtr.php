<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 1/6/2019
 * Time: 11:16 PM
 */

require_once '../dbconf/db.php';
require_once '../dbconf/conexion.php';
require_once '../Query/DisciplinaSQL.php';
$discplina = new DisciplinaSQL();

if(isset($_REQUEST['acao'])){
    $acao = $_REQUEST['acao'];


switch ($acao) {
    case 1:

        $rs = mysqli_query($con, $discplina->selectAll($_REQUEST['idcurso'], 1));
        echo '<select name="disciplina" id="disciplina" class="form-control">';
        while ($row = mysqli_fetch_assoc($rs)) {
            echo ' <option value="' . $row['idDisciplina'] . '">' . $row['descricao'] . '</option>';
        }
        echo '</select>';

        break;
    case 2:
        break;
    default:
        'Opcao Invalida';
}
}