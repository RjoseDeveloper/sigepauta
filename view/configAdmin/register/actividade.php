<?php
//include('is_logged');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version

session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: index.php");
    exit;
}

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}
if (empty($_POST['actividade'])){
    $errors[] = "actividade esta Vazio";
} elseif (empty($_POST['curso'])) {
    $errors[] = "curao esta vazio";
} elseif (
    !empty($_POST['datainicio'])
    && !empty($_POST['datainicio'])
    && !empty($_POST['datafim'])

) {
    require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $descricao = mysqli_real_escape_string($con,(strip_tags($_POST["actividade"],ENT_QUOTES)));
    $curso = mysqli_real_escape_string($con,(strip_tags($_POST["curso"],ENT_QUOTES)));
    $di = mysqli_real_escape_string($con,(strip_tags($_POST["datainicio"],ENT_QUOTES)));
    $df = mysqli_real_escape_string($con,(strip_tags($_POST["datafim"],ENT_QUOTES)));
    $date_added=date("Y-m-d");

    // check if user or email address already exists
    $sql = "SELECT * FROM actividade WHERE idactividade = '" . $descricao. "'";
    $query_check_user_name = mysqli_query($con,$sql);
    $query_check_user=mysqli_num_rows($query_check_user_name);
    $id=$_SESSION['id'];
    if ($query_check_user == 1) {
        $errors[] = "O sessao ja foi registada.";
    } else {
        // write new user's data into database
        $sql1 = "INSERT INTO actividade (descricao, data_inicio, data_fim, idutilizador, idcurso, data_added)
                            VALUES('".$descricao."','".$di."','" . $df . "','" .$id. "','" .$curso. "','" . $date_added . "')";

        $query_new_user_insert = mysqli_query($con,$sql1);
        //echo $sql1;
        // if user has been added successfully
        if ($query_new_user_insert) {
            $messages[] = "Actividade registada com sucesso.";
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