
<?php

    session_start();
   header('Content-Type: text/html; charset=UTF-8');

   require_once('../functions/Conexao.php');
   require_once('../model/EstudanteNotaCtr.php');
   require_once('../model/PautaNormalCtr.php');

   require_once('../model/QueryEstudanteSQL.php');
   require_once('../model/PautaNormalCtr.php');
   require_once('../model/PublicacaoPautaSQL.php');

   require_once('../model/SexoCtr.php');
   require_once('../model/AllQuerySQL.php');
   require_once('../model/QueryEstudanteSQL.php');

   require_once '../libs/fpdf/fpdf.php';
   require_once '../libs/fpdf/fpdf.css';
   define('FPDF_FONTPATH', '../libs/fpdf/font/') ;

   $ctr_est = new SqlQueryEstudante();
   $link = new mySQLConnection();
   $query = new QuerySql();
?>

<?php

 $pdf= new FPDF("P","pt","A4");
            $pdf->AddPage();
            $pdf->Image('../img/logo_unilurio.jpg');





            $cep = date('Y-m-d H:i:s');


                  $t1="eSimop-ac (Sistema Integrado Web Mobile  de Pautas Académicas)";


                  $contente= "Aos Estudantes:";
                  $pdf->ln(10);

                  $contente.="O sistema permite a consulta de resultados de Avaliações diversas apartir do seu dispositivo Móvel (Smartphone ou PC) a qualquer  disciplina do curso no qual o estudante encontra-se inscrito no semestre corrente";
                  $contente.="Aos Docentes:";
                  $pdf->ln(10);
                  $contente.="o Sistema possibilita registar pauta (online ou offline), realizar plano e Avaliação que estara disponivel aos Docentes e Estudantes, relatorio de Pautas Normal, Final, e Semestral de Disciplina gerados automaticamente pelo sistema";
                  $contente.="Aos Directores do Cursos";
                  $pdf->ln(10);
                  $contente.="Confirmar a Publicação das Pautas submetidas pelos Docentes no Curso associado.";


                  $tr2 ="Outros critérios e restrições:";

                  $tr3="*   Mostrar Pauta Normal por tipo de Avaliação (Testes, Mini-Testes, Trabalhos, Exame Normal e de Recorrência)";
                  $tr4="*   Mostrar Pauta de frequência e o respectivo disponivel no final do Semestre;";
                  $tr5="*   Mostrar Pauta do exame de recorrencia mediante a taxa paga;";
                  $tr6="*   Permite ainda armazenar no dispositivo local o resultado pesquisado;";



            $pdf->SetFont('arial','B',16);
            $pdf->Ln(2);
            $pdf->Cell(0,5,utf8_decode("Manual de Introdução do eSimop-ac"),0,1,'C');
            $pdf->Cell(0,5,"","B",1,'C');
            $pdf->Ln(8);

            $pdf->SetFont('arial','B',12);
            $pdf->setFont('arial','',12);
            $pdf->Cell(0,20,utf8_decode($nome),0,1,'L');

            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Data:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,utf8_decode($cep),0,1,'L');

            $pdf->Cell(0,5,"","B",1,'C');

            $pdf->ln(20);
            //Observações
            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Resumo",0,1,'L');

            $pdf->setFont('arial','',12);
            $pdf->cell(0,25,utf8_decode($t1),0);
            $pdf->ln(20);

            $pdf->MultiCell(0,20,utf8_decode($contente),0,'J');

            $pdf->ln(10);

            $pdf->SetFont('arial','U',12);
            $pdf->SetTextColor(232,  25, 255);
            $pdf->MultiCell(0,10,utf8_decode($tr2),0,'J');

            $pdf->ln(20);

            $pdf->setFont('arial','',12);
            $pdf->SetTextColor('');
            $pdf->setX(60);
            $pdf->MultiCell(0,10,utf8_decode($tr3),0,'J');
            $pdf->ln(8);$pdf->setX(60);
            $pdf->MultiCell(0,10,utf8_decode($tr4),0,'J');
            $pdf->ln(8);$pdf->setX(60);
            $pdf->MultiCell(0,10,utf8_decode($tr5),0,'J');
            $pdf->ln(8);$pdf->setX(60);
            $pdf->MultiCell(0,10,utf8_decode($tr6),0,'J');

            $pdf->ln(30);

            $pdf->SetTextColor(240,200,200);
            $pdf->cell(0,20,utf8_decode("Primeira iteração com o Sistema"),1,1,'C', true);
            $pdf->SetTextColor('');


                $texto = "[1] - Ser Estudante, Docente, Funcionário/a do Registo Académico,  Director Adjunto Pedagógico, Director do Curso na Faculdade de Engenharia da Universidade Lúrio.";


            $pdf->MultiCell(0,20, utf8_decode($texto),0,'J');

            $pdf->AddPage();
            $pdf->Image('../img/tela_inicial.png',80,30,'470','200');
            ob_clean();
            $pdf->Output("Manual_utilizacao.pdf","D");

?>