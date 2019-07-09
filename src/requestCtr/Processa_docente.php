<?php

   session_start();

   require_once('../Query/PublicacaoPautaSQL.php');
   require_once("../dbconf/getConection.php");
   require_once('../controller/EstudanteNotaCtr.php');
   require_once('../controller/PautaNormalCtr.php');
   require_once('../Query/AllQuerySQL.php');

   require_once('../Query/EstudantesSQL.php');
   require_once('../controller/PautaNormalCtr.php');
   require_once('../Query/PublicacaoPautaSQL.php');
   require_once('../controller/DocenteCtr.php');
   require_once('../bibliotecas/PHPMailer/class.phpmailer.php');
   require_once('../controller/EstudanteCtr.php');
   require_once '../Query/GestaoPautasSQL.php';
   require_once '../Query/DocenteSQL.php';

$dc = new DocenteSQL();

   $query = new QuerySql();
   $ctr_est = new EstudantesSQL();
   $docente = new DocenteController();
   $sql_estudante = new EstudantesSQL();
    $publicar_pauta = new PublicarPauta();
    $gestao_pautas = new GestaoPautasSQL();
    $db = new mySQLConnection();


    $acao = $_POST['acao'];
	$temp = FALSE;

    switch ($acao) {
        case 1:

	$email = utf8_decode($_POST['email']);
	$fullname = utf8_decode($_POST['fullname']);

    if (($senha_rec = $query->recuperar_senha($email, $fullname, 1)) != -1){
		$temp = TRUE;

	}else{

		if(($senha_rec = $query->recuperar_senha($email, $fullname, 2)) != -1){
			$temp = TRUE;

		}else{

			if(($senha_rec =$query->recuperar_senha($email, $fullname, 3)) != -1){
				$temp = TRUE;
			}
		}
	}

    $temporal ="";

       if($temp == TRUE){

          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->Mailer = 'smtp';
          $mail->SMTPAuth = true;
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = 465;
          $mail->SMTPSecure = 'ssl';
          $mail->IsHTML(true);
          // Autenticacao do gmail

          $mail->Username = "rjose@unilurio.ac.mz";
          $mail->Password = "rjose1991";

          $mail->IsHTML(true); // if you are going to send HTML formatted emails
          $mail->SingleTo = true;
          //Define o remetente

          $mail->From = $email;
          $mail->FromName = $fullname;

          $mail->AddAddress($email,$fullname);

          $link = "https://mail.google.com/mail/u/";
          $assunto = "Recuperação de dados de Autenticação";
          $message = 'Confirme a senha que foi encontrada na pesquisa: <h3 style="color:red">'.$senha_rec.'</h3>';

          //Texto e Assunto
          $mail->Subject = utf8_decode($assunto);
          $mail->Body = utf8_decode($message);

          if(!$mail->Send()){
             $temporal='<div align="center" style="color:red"><h3>A mensagem nao foi enviada<br/> Ocorrer um erro na tentativa de estabelecer conexão com servidor de email </h3><div>';

           }else{
            $temporal='<h4 style="color:green">Caro:&nbsp; &nbsp;'.$fullname.' <br>Os dados de autenticação enviamos  para o seu email <a href="http://mail.google.com/mail/mu/mp/" target="_blank">Siga ja ao Gmail</a> </h4>';

          }

         }else{
                    $temporal= '<h3 style="color:red">Nenhum resultado foi encontrado</h3>';
          }
         echo json_encode($temporal);
     break;

        case 2:


            break;
        case 3:

                   $db = new mySQLConnection();
                   $name = $_POST['nome'];
	               $linha = $query->idDocenteNome($name);
                   $consulta = "SELECT DISTINCT disciplina.idDisciplina, disciplina.descricao
                                from disciplina INNER JOIN docentedisciplina
                                ON docentedisciplina.idDisciplina = disciplina.idDisciplina INNER JOIN
                                docente ON docente.idDocente = docentedisciplina.idDocente WHERE
                                docente.idDocente = '$linha'";

                   $result = mysqli_query($db->openConection(), $consulta);

                    while ($row = mysqli_fetch_assoc($result)) {

                        $vetor[] = Array('id'=>$row['idDisciplina'],
                                          'disciplina'=>$row['descricao']);
                    }
                    echo json_encode($vetor);

                    break;

              case 4:

                 $dp = $_SESSION['idDisp'];// $_GET['disp'];
                 $db = new mySQLConnection();
	             $_SESSION['nome_disp'] = $publicar_pauta->getNomeDsciplina($dp);

                        $t=0; $aux="";
                        $proc = $query->listaDocentesDisciplina($dp);
                        $result = mysqli_query($db->openConection(), $proc);

                        while ($row = mysqli_fetch_assoc($result)){ if ($t > 1){echo "   e   ";} $t++;

                            $aux.= $row['nomeCompleto'];
		        $aux.=' ';
                        }
                        echo '<label style="color:green">___Docente/s da disciplina:  '.$aux.'</label><br><br>';


            echo '<div style="width:650px; margin-left:-5em">

               <input type="text" data-theme="d" class="inpute" name="txtemail"
                   placeholder="Email do remetente ..." value="" id="txtemail"/>

               <input type="password" data-theme="d" class="inpute" name="txtsenha"
                   placeholder="Senha do remetente  ..." value="" id="txtsenha"/>

              <textarea data-mini="true"  data-theme="d" class="texta"
            placeholder="A mensagem a enviar..." name="txtarea" id="txtarea"></textarea><br>
              <p>
               <button style="color:white;border:1px solid white; padding:8px;" onclick="send_email('.$dp.')" class="sv"
          data-inline="true" data-mini="true" data-theme="b" data-icon="forward" data-iconpos="right">Enviar Mensagem</button></p>
          </div>
               ';


            break;

        case 5:

          $dp = $_POST['disp'];
          $_SESSION['idDisp'] = $dp;
          $_SESSION['nome_disp'] = $publicar_pauta->getNomeDsciplina($dp);

          $texto = utf8_decode($_POST['txtemail']);
          $email = utf8_decode($_POST['txtarea']);
          $senha = utf8_decode($_POST['senha']);

          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->Mailer = 'smtp';
          $mail->SMTPAuth = true;
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = 465;
          $mail->SMTPSecure = 'ssl';
          // Autenticacao do gmail

          $mail->Username = $email;
          $mail->Password = $senha;

          $mail->IsHTML(true); // if you are going to send HTML formatted emails
          $mail->SingleTo = true;
          //Define o remetente

          $mail->From = utf8_decode($email);
          $mail->FromName = $_SESSION['nomeC'];

          //Define os destinatário(s)
          $db = new mySQLConnection();
          $array = $query->listaDocentesDisciplina($dp);
          $result = mysqli_query($db->openConection(), $array);
          $t=0;


          while ($row= mysqli_fetch_assoc($result)) {

               $to = $query->email_docente ($row['nomeCompleto']);
               if ($t== 0){

                   $mail->AddAddress($to,$row['nomeCompleto']);
                   $t++;
               }else{

                   $mail->AddAddress($to, $row['nomeCompleto']);
               }
          }


          //Define os dados técnicos da Mensagem
          $mail->IsHTML(true); // Define que o e-mail será enviado como HTML

          $assunto = "Notificação disciplina -".$_SESSION['nome_disp'];

          //Texto e Assunto
          $mail->Subject = utf8_decode($assunto);
          $mail->Body = utf8_decode($texto);

          if(!$mail->Send()){

                echo '<div align="center" style="color:red"><h3>A mensagem nao foi enviada ocorrer um erro na<br/>
				tentativa de estabelecer conexão com servidor de email </h3><div>';

                    }else{

                    echo '<div align="center"><h3 style="color:red">A mensagem foi enviada com sucesso</h3></div>';
          }

          break;

          case 6:

                echo ($query->check_publicacao ($_POST['ptn']));

          break;

	case 7:

            $consulta = $query->listaDisciplina($_POST['nome'], 0);
		    $result = mysqli_query($db->openConection(), $consulta);

	       while ($row = mysqli_fetch_assoc($result)) {

           $my_array[] = array('id'=>$row['idDisciplina'],
                            'descricao'=>$row['descricao']);

	       }
            echo json_encode($my_array);


		break;

                    case 8:

                        $sessao = "Registo Academico";
                        $docente = new DocenteController();
                        $docente->create_user_rac($_POST['nc'],$sessao,$_POST['user'],$_POST['pass'],$_POST['email']);

                    break;

                    case 9:

                        $idDoc = $query->getDoc_id($_SESSION['username']);
                        $rs = $query->analisarDisciplina($idDoc,$_POST['curso'],$_POST['disp']);
                        echo $rs;

                    break;
					
					case 10: ?>

<table class="table">
    <thead class="info">


    <?php

    $res = mysqli_query($db->openConection(), $dc->disciplinas_professor($_REQUEST['id']) );
        while($linhas= mysqli_fetch_assoc($res)) {?>

    <tr class="alert alert-info">
        <td>Disciplina</td>
        <th><?php echo $linhas['disp'] ?></th>
    </tr>

    <tr>
        <td>Curso e Nivel Academico</td>
        <td><?php echo $linhas['c'].'/ '.$linhas['anolectivo'].'º ANO' ?></td>
    </tr>

    <tr>
        <td>Natureza  & Ano </td>
        <td><?php echo utf8_encode($linhas['natureza']).' / '. date("Y", strtotime($linhas['data'])) ?></td>
    </tr>

        <?php }?>

   </tbody> </table>

<?php


					break;

                    case 11:

                        $sql = mysqli_query($db->openConection(), $gestao_pautas->obter_datas($_POST['disp'],0));
                        echo '<select class="form-control get_estudante" data-style="btn-primary" onchange="obter_estudante_lista();" id="btn_buscar_est"
                                data-width="auto" id="txt_avaliacao">';
                        echo '<option value=""><h2 style="color:blue">Seleccionar Avaliação</h2></option>';

                        while ($rows = mysqli_fetch_assoc($sql)){
                          echo '<option value="'.$rows['idTipoAvaliacao'].'" id="btn_buscar_est">'. $rows['descricao'] .'</option>';
                        }
                        echo '</select>';


                        break;

        case 12:

                $idcurso = $_REQUEST['curso'];
                echo '<select name="turma_x" id="turma_x" class="form-control"><option value=""></option>';
                      $rs = mysqli_query($db->openConection(), 'SELECT * FROM turma WHERE idcurso='.$idcurso);
                      while ($row = mysqli_fetch_assoc($rs)){
                       echo"<option value=".$row['idturma'].">".utf8_encode( $row['descricao'] )."</option>";
                      }

            echo '</select>';
            break;

            default:
            echo 'Nenhum parametro enviado';
}
