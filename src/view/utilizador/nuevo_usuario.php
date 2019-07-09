<?php

if (isset($_SESSION['username'])){
    include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
}

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing phpUnitTest to older versions of PHP)
    require_once("../..//password_compatibility_library.php");
}
if (empty($_POST['firstname'])){
    $errors[] = "Nome Vazio";
} elseif (empty($_POST['user_name'])) {
    $errors[] = "username vazio";
} elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
    $errors[] = "Palavra passe vazia";
} elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
    $errors[] = "As palavras passe não concidem";
} elseif (strlen($_POST['user_password_new']) < 6) {
    $errors[] = "Nome do utilizador não pode ter 2 o mais de 64 caracteres";
} elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
    $errors[] = "Nome do utilizador deve ter o esquema: entre aZ e numeros permitidos , de 2 a 64 caracteres";
} elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
    $errors[] = "Nome de utilizador não segue o esquema de nome: que começa de aZ  e os números permitidos são 2 a 64 caracteres";
} elseif (empty($_POST['user_email'])) {
    $errors[] = "O campo correio electronico não pode estar vazio";
} elseif (strlen($_POST['user_email']) > 64) {
    $errors[] = "O correio electronico não pode ter mais 64 caracteres";
} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Seu endereço de email não esta no formato correcto de correo electrónico válida";
} elseif (
    !empty($_POST['user_name'])
    && !empty($_POST['firstname'])
    //&& !empty($_POST['lastname'])
    && strlen($_POST['user_name']) <= 64
    && strlen($_POST['user_name']) >= 2
    && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
    && !empty($_POST['user_email'])
    && strlen($_POST['user_email']) <= 64
    && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
    && !empty($_POST['user_password_new'])
    && !empty($_POST['user_password_repeat'])
    && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
) {
    require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos

    // escaping, additionally removing everything that could be (html/javascript-) code
    $firstname = mysqli_real_escape_string($con,(strip_tags($_POST["firstname"],ENT_QUOTES)));
    //$lastname = mysqli_real_escape_string($con,(strip_tags($_POST["lastname"],ENT_QUOTES)));
    $user_name = mysqli_real_escape_string($con,(strip_tags($_POST["user_name"],ENT_QUOTES)));
    $user_email = mysqli_real_escape_string($con,(strip_tags($_POST["user_email"],ENT_QUOTES)));
    $user_password = $_POST['user_password_new'];
    $date_added=date("Y-m-d H:i:s");
    // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
    // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
    // PHP 5.3/5.4, by the password hashing compatibility library
    $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

    $estado = $_POST['estado'];
    $role = $_POST['previlegio'];
    $celular = $_POST['celular'];
    $sexo = $_POST['sexo'];
    // check if user or email address already exists
    $sql = "SELECT * FROM utilizador WHERE username = '" . $user_name . "' OR email = '" . $user_email . "';";
    $query_check_user_name = mysqli_query($con,$sql);
    //echo $sql;
    $query_check_user=mysqli_num_rows($query_check_user_name);
    if ($query_check_user == 1) {
        $errors[] = "O nome do utilizador e o endereço de correio electronico está em uso.";
    } else {
        // write new user's data into database
        $sql = "INSERT INTO utilizador (username,password, data_ingresso, nomeCompleto, idprevilegio,estado, email, celular,sexo)
                            VALUES('".$user_name."','".$user_password."','" . $date_added . "','" .$firstname. "',
                            '" .$role. "','" .$estado. "','" .$user_email. "','".$celular."','".$sexo."')";


        $query_new_user_insert = mysqli_query($con,$sql);

        // if user has been added successfully
        if ($query_new_user_insert) {
            $messages[] = "A conta registada com sucesso.";
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