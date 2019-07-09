<?php

	session_start();

	require_once("../Query/AllQuerySQL.php");
	require_once("../controller/DisciplinaCtr.php");
	require_once("../controller/EstudanteNotaCtr.php");
	require_once("../controller/PautaRecorrenciaCtr.php");
	require_once("../controller/PautaNormalCtr.php");
    require_once('../Query/EstudantesSQL.php');
    require_once("../dbconf/getConection.php");
    require_once('../Query/PublicacaoPautaSQL.php');
    require_once('../Query/PautaFrequenciaSQL.php');
    require_once('../bibliotecas/PHPMailer/class.phpmailer.php');
    require_once('../controller/EstudanteCtr.php');

    $pauta_frequencia = new PautaFrequencia();
    $publicar_nota = new EstudanteController();
    $sql_estudante = new EstudantesSQL();
    $pautaNormal = new PautaNormalController();
	$db = new mySQLConnection();
    $query = new QuerySql();

	$acao = $_POST['acao'];

	switch($acao){

		case 1:
					$id = $_POST['idNota'];
					$idDisp = $query_estudante->returnTipo($id, 1);
					$idAluno=  $query_estudante->getIdEstudante($_SESSION['username'],1);

					if (($query_estudante->returnTipo($id, 0) == 5) &&
                        ($query_estudante->validarRecorrencia ($idAluno, $idDisp)  == 1)){
					    echo'Taxa de recorrencia não paga';

					}else{
					    echo floatval($sql_estudante->getEstNota($id));
					    $_SESSION['idNota'] = $id;
					}
					break;
		 case 2:
				    $data = $_POST['curso'];
                    $vetor=$sql_estudante->pautaPublicadas(2, $data);
                    foreach ($vetor as $row) {

                        if ($row!=null){

                            $t1= $sql_estudante->getCoutEstdPauta($row['idtipo'], 2);
                            $t2 = $sql_estudante->getCoutEstdPauta($row['idtipo'], 1);

                            echo '<tr>';
                            echo '<td>'.$row['descricao'].'</td>';
                            echo '<td>'.$row['conta'].'</td>';
                            echo '<td>'.$t1.'</td>';
                            echo '<td>'.$t2.'</td>';
                            echo '</tr>';
                          }
                     }
		break;

		case 3:
			//Actuliza publicco de puta;
			$pauta = $_POST['pauta'];
			$pautaNormal->update(2, $pauta);

		break;

		case 4:

                 $pauta = $query->obterPautaNormal($_POST['idnota']);
                 if ($query->return_dif_data($pauta, 0) > 7){

                     echo '<div style="color:red">O sistema nao lhe permite alterar classificações
                     de pautas publicadas ou com mais de 7 dias no sistema</div>';

                 }else{

                 $idDisp = $sql_estudante->returnTipo($_POST['idnota'], 1);
                 $stmt = mysqli_prepare($db->openConection(),"UPDATE estudante_nota SET nota = ? WHERE idNota = ?");
                 $stmt->bind_param('di', $_POST['nota'], $_POST['idnota']);

                 if(!$stmt->execute()){
                       echo 'Nao foi possivel alterar a classificação';
                 }else{
                       echo "Classificação actualizada com sucesso";
                       $stmt->close();
                 }
        }

        break;
        case 5:

                 $query = $sql_estudante->getPlanoAvaliacao($_POST['disciplina']);
                 $nomeDisp =  $pautaFreq->getnomeDisp($_POST['disciplina']);
                 $result = mysqli_query($db->openConection(), $query);
                 $t=0;

                 while ($row = mysqli_fetch_assoc($result)) {
                    $peso = $row['peso'];

                     echo '<tr>';

                         echo '<td>'.++$t.'</td>';
                         echo '<td>'.$row['descricao'].'</td>';
                         echo '<td align="center">'.$row['qtd'].'</td>';
                         echo '<td align="center">'.$peso.'</td>';
                         echo '<td align="center">'.date('d-m-Y').'</td>';

                     echo '</tr>';
                 }

                   echo '<tr>';

                         echo '<td>&nbsp;</td>';
                         echo '<td>&nbsp;</td>';
                         echo '<td align="center" style="background:#ff9933; color:blue">'.strtoupper($nomeDisp).'</td>';
                         echo '<td align="center">&nbsp;</td>';
                 echo '</tr>';

                break;
    case 6:
	        if ($_POST['ctr'] === 2 && $query->return_dif_data($pauta, 0) <= 5){

                 $db = new mySQLConnection();

                 $email= utf8_decode($_POST['email_doc_ass']);
                 $msg =utf8_decode($_POST['txtmotivo']);
                 $user=utf8_decode($_POST['user']);
                 $pass= utf8_decode($_POST['senha_doc']);
                 $idDisp = $sql_estudante->returnTipo($_SESSION['idNota'], 1);

                 $stmt = mysqli_prepare($db->openConection(),"UPDATE estudante_nota SET nota = ? WHERE idNota = ?");
                 $stmt->bind_param('di', $_POST['nota'], $_SESSION['idNota']);

                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Mailer = 'smtp';
                    $mail->SMTPAuth = true;
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true);
                    // Autenticacao do gmail

                    $mail->Username = $user;
                    $mail->Password = $pass;
                    $mail->IsHTML(true); // if you are going to send HTML formatted emails
                    $mail->SingleTo = true;
                    //Define o remetente
                    $mail->From = $email;
                    $mail->FromName = $_SESSION['nomeC'];
                    $mail->AddAddress($email,$_SESSION['nomeC']);
                    //$mail->AddAddress($email,$_SESSION['nomeC']);
                    $assunto = "Alteração de nota disciplina: ".$publicar->getNomeDsciplina($idDisp);
                    $message ='Motivo: '.$msg.'<br />Houve alteração de nota para o estudante [ '.$query->mostrar_nome_estudante($_SESSION['idNota']).' ]';

                    //Texto e Assunto
                    $mail->Subject = utf8_decode($assunto);
                    $mail->Body = utf8_decode($message);
                    if(!$mail->Send() && $stmt->execute()){
                       echo '<div align="center" style="color:red"><h3>Nao foi possivel alterar a classificação e ocorrer um erro na <br/>
                                        tentativa de estabelecer conexão com servidor de email</h3><div>';
                    }else{
                       echo "Operação efectuada com sucesso";
                       $stmt->close();
                    }
               }
	break;

}

?>
