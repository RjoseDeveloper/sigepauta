<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}

    require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code

    $user_name = mysqli_real_escape_string($con,(strip_tags($_POST["user_id"],ENT_QUOTES)));
    $disciplina = mysqli_real_escape_string($con,(strip_tags($_POST["disciplina_x"],ENT_QUOTES)));
    $date_added=date("Y-m-d");
    $curso = mysqli_real_escape_string($con,(strip_tags($_POST["curso"],ENT_QUOTES)));
    $posicao = mysqli_real_escape_string($con,(strip_tags($_POST["posicao"],ENT_QUOTES)));
    $turma = mysqli_real_escape_string($con,(strip_tags($_POST["turma_x"],ENT_QUOTES)));

    //check if user or email address already exists
    $sql = "SELECT * FROM disciplina_curso WHERE idutilizador = '" . $user_name . "' AND iddisciplina='". $disciplina ."' AND data = '".$date_added."'";
    $query_check_user_name = mysqli_query($con,$sql);
    $query_check_user=mysqli_num_rows($query_check_user_name);
    if ($query_check_user == 1) {
        $errors[] = "A disciplina com este docente ja foi registado para este semestre.";
    } else {

        // write new user's data into database
        $sql = "INSERT INTO disciplina_curso (iddisciplina, data, idutilizador,idcurso,posicao, idturma)
                            VALUES('".$disciplina."','".$date_added."','".$user_name."','".$curso."','".$posicao."','".$turma."')";
        $query_new_user_insert = mysqli_query($con, $sql);

        //echo $sql;

        // if user has been added successfully
        if ($query_new_user_insert) {
            $messages[] = "Professor Associado a disciplina com sucesso.";
        } else {
            $errors[] = "Lamentamos houve problemas com os dados fornecidos";
        }
    }

if (isset($errors)){

    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}


if (isset($messages)){

    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Operação efectuada</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
<?php
}

?>