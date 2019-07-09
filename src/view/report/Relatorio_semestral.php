<?php

   session_start();

   require_once('../../Query/PublicacaoPautaSQL.php');
   require_once("../../dbconf/getConection.php");
   require_once('../../Query/AllQuerySQL.php');
   require_once('../../Query/PautaFrequenciaSQL.php');

    require_once '../../bibliotecas/fpdf/fpdf.php';
    require_once '../../bibliotecas/fpdf/fpdf.css';
    define('FPDF_FONTPATH','../../bibliotecas/fpdf/font/');
    include '../../Query/EstudantesSQL.php';

    $ctr_est = new EstudantesSQL();


   echo '<meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">';

            $query = new QuerySql();
            $disp = $_REQUEST['disp'];
            $idreport = $_REQUEST['idreport'];
            $curso =30;
            $db = new mySQLConnection();
$publicar_pauta = new PublicarPauta();

            $_id = '';
            $avaliacao = '';
            $cplano = '';
            $desafio = '';
            $contrag = '';
            $date_added = '';
            $disciplina ='';

	       $pdf=new FPDF();
                 $pdf->AddPage();
                 $pdf->SetFont('Arial','B',11);

              $pdf->Image('../fragments/img/unilurio.png',85,10,25);
              $pdf->setXY(75,40);
              $pdf->Cell(50,6,utf8_decode('UNIVERSIDADE LÚRIO'),0,0,'C');
              $pdf->ln();$pdf->setX(75);
              $pdf->Cell(50,6,'FACULDADE DE ENGENHARIA',0,0,'C');
              $pdf->ln();$pdf->setX(75);
              $pdf->Cell(50,6,utf8_decode('DIRECÇÃO PEDAGÓGICA '),0,0,'C');

              $pdf->SetFont('Arial','',10);
              $pdf->ln();$pdf->setX(75);
              $pdf->Cell(50,6,utf8_decode('Campus Universitário, Bairro Eduardo Mondlane, C.P. 958'),0,0,'C');
              $pdf->ln();$pdf->setX(75);
              $pdf->Cell(50,6,utf8_decode('Cabo Delgado - Moçambique'),0,0,'C');

              $pdf->SetFont('Arial','B',10);

              $pdf->ln(10);
              $pdf->SetX(20);


                $res = mysqli_query($db->openConection(), 'SELECT * FROM rsemestre WHERE idreport ='.$idreport);
                while ($row=mysqli_fetch_array($query)) {
                    $i++;

                    $_id = $row['idreport']."\n";
                    $avaliacao = $avaliacao. $row['avaliacoes']."\n";
                    $cplano = $cplano.$row['cplano']."\n";
                    $desafio = $desafio. $row['desafios']."\n";
                    $contrag = $contrag. $row['constraing']."\n";
                    $date_added = $date_added. date('d/m/Y', strtotime($row['data_added']))."\n";
                    $disciplina = $disciplina. $row['disciplina']."\n";

                }

$pdf->MultiCell(170,10,'RELATORIO SEMESTRAL DISCIPLINA DE '.$_id,0,'J');



$i=0; $coluna= 76;

              $pdf->SetX(20);
              $pdf->Cell(60,6,'Cumprimento do Plano',0,0,'L');
              $pdf->ln();
              $pdf->SetFont('Arial','',10);
              $pdf->SetX(20);
              $pdf->MultiCell(170,6,$cplano,0,'J');

              $pdf->SetFont('Arial','B',10);
              $pdf->SetX(20);
              $pdf->Cell(60,6,utf8_decode('Avaliações'),0,0,'L');
              $pdf->ln();


              $pdf->SetFont('Arial','',10);
              $pdf->SetX(20);
              $pdf->MultiCell(170,6,$avaliacao,0,'J');

              $pdf->SetFont('Arial','B',10);
              $pdf->SetX(20);
              $pdf->Cell(60,6,'Constrangimentos na disciplina',0,0,'L');
              $pdf->ln();
              $pdf->SetX(20);
              $pdf->SetFont('Arial','',10);
              $pdf->MultiCell(170,6, $contrag,0,'J');

              $pdf->SetFont('Arial','B',10);
              $pdf->SetX(20);
              $pdf->Cell(60,6,'Perpectivas/Desafios',0,0,'L');
              $pdf->ln();

              $pdf->SetFont('Arial','',10);
              $pdf->SetX(20);
              $pdf->MultiCell(170,6,  $desafio,0,'J');
              $pdf->ln(10);

              $pdf->SetFont('Arial','I',9);
              $pdf->Cell(170,6, utf8_decode('Tabela de dados estatísticos do aproveitamento da disciplina'),0,0,'C');
              $pdf->ln(10);
              $pdf->SetFont('Arial','B',9);


              /*----------------------------------------------------*/

              $semestre = date('m') < 7 ? '1º':' 2º';

              
              /*---------------------------------------------------*/
              $pdf->SetX(20);
                    $largura1 = 70;
                    $largura2 = 100;
                    // altura padrão das linhas das colunas
                    $altura = 5;
              $est_add_ex = 1;

                    // criando os cabeçalhos para 5 colunas
                    $pdf->Cell($largura1, $altura, 'disciplina', 1, 0, 'C');
                    $pdf->Cell($largura2, $altura, $disciplina, 1, 0, 'C');
                    $pdf->SetFont('Arial','',10);

                    $pdf->ln();
                    $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Ano', 1, 0, 'L');
                    $pdf->Cell($largura2, $altura, utf8_decode($query->get_creditos_ano($disp, 0).'º'), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Semestre', 1, 0, 'L');
                    $pdf->Cell($largura2, $altura, utf8_decode($semestre), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Estudantes Inscritos', 1, 0, 'L');
                    $pdf->Cell($largura2, $altura, $ctr_est->contas_estudantes($disp, $curso,1,0), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Estudantes Avaliados', 1, 0, 'L');
                    $est_av = $ctr_est->contas_estudantes($disp,$curso, 2, 0);
                    $pdf->Cell($largura2, $altura, $est_av, 1, 0, 'C');

                    $pdf->ln();
                    $pdf->SetX(20);
                    $pdf->Cell(170, $altura, 'Aproveitamento', 1, 1, 'C');
                    $pdf->SetX(20);

                    $pdf->Cell($largura1, $altura, '', 1, 0, 'L');
                    $pdf->Cell($largura2/2, $altura, 'Quantidade(#)', 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, 'Percentagens(%)', 1, 0, 'C');
                    $pdf->ln();
                    $pdf->SetX(20);

                    $pdf->Cell($largura1, $altura, 'Admitidos ao Exame Normal', 1, 0, 'L');
                    if ($est_add_ex = $ctr_est->contar_media($curso, $disp,3) == 0){
                        $est_add_ex = 1;
                    }
                    $pdf->Cell($largura2/2, $altura, $est_add_ex, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_add_ex/$est_av)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Excluidos do Exame Normal', 1, 0, 'L');
                    $est_ex_nor= $ctr_est->contar_media($curso, $disp,2);
                    $pdf->Cell($largura2/2, $altura,$est_ex_nor , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_ex_nor/$est_av)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Aprovados do Exame Normal', 1, 0, 'L');
                    $est_apr_exN= $ctr_est->contas_estudantes($disp,$curso, 5, 4);
                    $pdf->Cell($largura2/2, $altura,$est_apr_exN , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_apr_exN/$est_add_ex)*100,1), 1, 0, 'C');

                    if ($pdf->getY() > 255){
                        $pdf->addPage();
                        $pdf->SetFont('Arial','B',11);
                        $pdf->ln();
                    }
                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Ausências no Exame Normal'), 1, 0, 'L');
                    if (( $est_aus_exN = $ctr_est->contas_estudantes($disp,$curso, 6, 4) )==  0){
                          $est_aus_exN  = 1;
                    }
                    $pdf->Cell($largura2/2, $altura,$est_aus_exN , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_aus_exN/$est_add_ex)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Admitidos ao Exame de Recorrência'), 1, 0, 'L');

                    if ( ($est_add_exR=$ctr_est->contas_estudantes($disp,$curso, 7, 4) )== 0){
                        $est_add_exR = 1 ;
                    }

                    $pdf->Cell($largura2/2, $altura,$est_add_exR , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_add_exR/$est_add_ex)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Ausências no Exame de Recorrência'), 1, 0, 'L');
                    $est_aus_exR= $ctr_est->contas_estudantes($disp,$curso, 6, 5);
                    $pdf->Cell($largura2/2, $altura, $est_aus_exR, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_aus_exR/$est_add_exR)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Aprovados do Exame de Recorrência'), 1, 0, 'L');

                    $est_apr_exR=$ctr_est->aprovados_exa_rec($curso,$disp);
                    $pdf->Cell($largura2/2, $altura, $est_apr_exR, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_apr_exR/$est_add_exR)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Dispensados', 1, 0, 'L');
                    $dipensa = $ctr_est->contar_media($curso, $disp,1);
                    $pdf->Cell($largura2/2, $altura,$dipensa , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($dipensa/$est_av)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Aprovados no Geral', 1, 0, 'L');
                    $est_aprG=$ctr_est->contas_estudantes($disp,$curso, 8, 5)+$dipensa;
                    $pdf->Cell($largura2/2, $altura,$est_aprG, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_aprG/$est_av)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Reprovados no Geral', 1, 0, 'L');
                    $est_repG= $ctr_est->contas_estudantes($disp,$curso, 9, 5);
                    $pdf->Cell($largura2/2, $altura,$est_repG , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_repG/$est_av)*100,1), 1, 0, 'C');


                    // pulando a linha
                    $pdf->ln(10);
                    $pdf->SetX(80);
                    $pdf->Cell(50,5,utf8_decode('Pemba, '.date('d').' de '.$ctr_est->return_mes().' de '.date('Y')),0,0,'C');

                    $pdf->ln();
                    $pdf->SetX(80);
                    $pdf->Cell(50, 5, 'O Docente', 0, 0, 'C');

                    $pdf->ln();
                    $pdf->SetX(81);
                    $pdf->Cell(50,5,"","B",1,'C');

                    $pdf->ln();
                    $pdf->SetX(82);
                    $pdf->Cell(50, 5, utf8_decode($publicar_pauta->buscar_docente($disp)), 0, 0, 'C');


             ob_clean();
             $pdf->Output('Relatorio_Semestral_'.$disciplina.'.pdf','I');


?>