<?php
include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing phpUnitTest to older versions of PHP)

}
if (empty($_POST['campo_utilizador'])){
    $errors[] = "Utilizador esta Vazio";
} elseif (empty($_POST['grau'])) {
    $errors[] = "grau esta vazio";
} elseif (
    !empty($_POST['campo_utilizador'])
    && !empty($_POST['grau'])
    && !empty($_POST['regime'])

) {
    require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $grau = mysqli_real_escape_string($con,(strip_tags($_POST["grau"],ENT_QUOTES)));
    $user_name = mysqli_real_escape_string($con,(strip_tags($_POST["campo_utilizador"],ENT_QUOTES)));
    $regime = mysqli_real_escape_string($con,(strip_tags($_POST["regime"],ENT_QUOTES)));
    $date_added=date("Y-m-d H:i:s");

    // check if user or email address already exists
    $sql = "SELECT * FROM professor WHERE idutilizador = '" . $user_name . "'";
    $query_check_user_name = mysqli_query($con,$sql);
    $query_check_user=mysqli_num_rows($query_check_user_name);
    if ($query_check_user == 1) {
        $errors[] = "O professor ja foi registado.";
    } else {
        // write new user's data into database
        $sql = "INSERT INTO professor (tempo,dataregisto, idutilizador, idgrau)
                            VALUES('".$regime."','".$date_added."','" . $user_name . "','" .$grau. "')";

        $query_new_user_insert = mysqli_query($con,$sql);
        // if user has been added successfully
        if ($query_new_user_insert) {
            $messages[] = "Professor registado com sucesso.";
        } else {
            $errors[] = "Lamentamos houve problemas com os dados fornecidos";
        }
    }

} else {
    $errors[] = "Un error desconhecido ocorreu.";
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