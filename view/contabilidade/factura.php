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
    // (this library adds the PHP 5.5 password hashing phpUnitTest to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");

}
if (empty($_POST['id_aluno'])){
    $errors[] = "Campo aluno esta Vazio";
} elseif (empty($_POST['curso'])) {
    $errors[] = "Campo curso esta vazio";
}elseif (empty($_POST['valor'])) {
    $errors[] = "Campo valor esta vazio";
}elseif (
    !empty($_POST['finality'])
    && !empty($_POST['modo_pay'])
    && !empty($_POST['juro'])

) {
    require_once("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once("../config/conexion.php");//Contiene funcion que conecta a la base de datos
    require_once("../../../Query/ContabilidadeSQL.php");
    $contas = new ContabilidadeSQL();

    // escaping, additionally removing everything that could be (html/javascript-) code
    $idaluno = mysqli_real_escape_string($con,(strip_tags($_POST["id_aluno"],ENT_QUOTES)));
    $curso = mysqli_real_escape_string($con,(strip_tags($_POST["curso"],ENT_QUOTES)));
    $finality = mysqli_real_escape_string($con,(strip_tags($_POST["finality"],ENT_QUOTES)));
    $juro = mysqli_real_escape_string($con,(strip_tags($_POST["juro"],ENT_QUOTES)));
    $valor = mysqli_real_escape_string($con,(strip_tags($_POST["valor"],ENT_QUOTES)));
    $modopay = mysqli_real_escape_string($con,(strip_tags($_POST["modo_pay"],ENT_QUOTES)));
    $date_added=date("Y-m-d");
    $id=$_SESSION['id'];
    $status = mysqli_real_escape_string($con,(strip_tags($_POST["status"],ENT_QUOTES))); ;

//    // check if user or email address already exists
    $sql = $contas->consult_actividade($curso);
    $query_check_user_name = mysqli_query($con,$sql);
    $query_check_user=mysqli_num_rows($query_check_user_name);
    $taxa_juro =0;

    if ($query_check_user < 0) {
        $errors[] = "Passou a data limite de inscrições.";
    } else {
//        // write new user's data into database
        $taxa_juro = ($_POST["juro"]*$_POST["valor"])/100+ $_POST["valor"];
        $sql1 = "INSERT INTO prestacao(valor, datapay, idjuro, status, modepay, idfinalidade,
                                        idcurso, idaluno, user_session_id)
                            VALUES('".$taxa_juro."','".$date_added."','" . $juro . "','" .$status. "',
                            '" .$modopay. "','" .$finality. "','" . $curso . "','" . $idaluno . "','" . $id . "')";

        //echo $sql1;
        $query_new_user_insert = mysqli_query($con,$sql1);
         ///if user has been added successfully
        if ($query_new_user_insert) {
            $messages[] = "Pagamento Efectuado com Sucesso.";
        } else {
            $errors[] = "Lamentamos houve Problemas com os dados fornecidos";
        }
    }

} else {
    $errors[] = "Um error desconhecido ocorreu.";
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