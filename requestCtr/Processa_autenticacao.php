<?php



	require_once("../functions/Conexao.php");
	require_once('../QuerySql/AutenticarSQL.php');

if (!session_start()){
    session_start();
}

$user = $_POST['username'];
$pass = $_POST['password'];
$acao = $_POST['acao'];


$db = new mySQLConnection();
$autenticarSQL = new AutenticarSQL();

	switch($acao){

		case 1:


			break;

		    case 2:

                $sql =  $autenticarSQL->acesso_sistema($user,$pass);
                $dados = mysqli_query($db->openConection(),$sql);

                if ($row = mysqli_fetch_assoc($dados)){

                    $_SESSION['tipo'] = $row['tipo'];
                    $_SESSION['nomeC'] = $row['nomeCompleto'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_login_status'] =1;
                    $_SESSION['id']= $row['id'];

                    ?>
                    <script>window.location="view/main.php";</script>

               <?php }else{
                    echo 'Talvez nome ou senha esteja errado!';

                }
	        break;
            case 3:
                session_start(); //to ensure you are using same session
                session_destroy(); //destroy the sessio
                exit();
            break;
	}
?>
