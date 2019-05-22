<?php

   session_start();
   require_once('../QuerySql/PublicacaoPautaSQL.php');
   require_once("../functions/Conexao.php");
   require_once('../controller/EstudanteNotaCtr.php');
   require_once('../controller/PautaNormalCtr.php');
   require_once('../QuerySql/AllQuerySQL.php');

   require_once('../QuerySql/EstudantesSQL.php');
   require_once('../controller/PautaNormalCtr.php');
   require_once('../QuerySql/PublicacaoPautaSQL.php');
   require_once('../QuerySql/PautaFrequenciaSQL.php');

    require_once '../libs/fpdf/fpdf.php';
    require_once '../libs/fpdf/fpdf.css';
    define('FPDF_FONTPATH','../libs/fpdf/font/') ;

   echo '<meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">';

   $ctr_est = new EstudantesSQL();
   $link = new mySQLConnection();
   $publicar_pauta = new PublicarPauta();
   $pautaFreq = new PautaFrequencia();
   $query = new QuerySql();


          if ($_GET['ctr'] == 1){

                 $_SESSION['disp']= $_GET['disp'];
                 $_SESSION['curso'] =$_GET['curso'];
                 $_SESSION['nomedisp']=utf8_decode( $_GET['nomedisp']);
                 $_SESSION['cplano']= utf8_decode($_GET['cplano']);
                 $_SESSION['avaliacao']=utf8_decode($_GET['av']);
                 $_SESSION['constrag'] = utf8_decode($_GET['constrag']);
                 $_SESSION['desafios'] = utf8_decode($_GET['desafios']);

           }else{

	       $pdf=new FPDF();
                 $pdf->AddPage();
                 $pdf->SetFont('Arial','B',11);

              $pdf->Image('../img/unilurio.png',85,10,25);
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

              $pdf->MultiCell(170,10,'RELATORIO SEMESTRAL DA DISCIPLINA DE '.$_SESSION['nomedisp'],0,'J');

              $pdf->SetX(20);
              $pdf->Cell(60,6,'Cumprimento do Plano',0,0,'L');
              $pdf->ln();
              $pdf->SetFont('Arial','',10);
              $pdf->SetX(20);
              $pdf->MultiCell(170,6,$_SESSION['cplano'],0,'J');

              $pdf->SetFont('Arial','B',10);
              $pdf->SetX(20);
              $pdf->Cell(60,6,utf8_decode('Avaliações'),0,0,'L');
              $pdf->ln();
              $pdf->SetFont('Arial','',10);
              $pdf->SetX(20);
              $pdf->MultiCell(170,6,$_SESSION['avaliacao'],0,'J');

              $pdf->SetFont('Arial','B',10);
              $pdf->SetX(20);
              $pdf->Cell(60,6,'Constrangimentos na disciplina',0,0,'L');
              $pdf->ln();
              $pdf->SetX(20);
              $pdf->SetFont('Arial','',10);
              $pdf->MultiCell(170,6, $_SESSION['constrag'],0,'J');

              $pdf->SetFont('Arial','B',10);
              $pdf->SetX(20);
              $pdf->Cell(60,6,'Perpectivas/Desafios',0,0,'L');
              $pdf->ln();

              $pdf->SetFont('Arial','',10);
              $pdf->SetX(20);
              $pdf->MultiCell(170,6,  $_SESSION['desafios'],0,'J');
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
                    $pdf->Cell($largura1, $altura, 'Disciplina', 1, 0, 'C');
                    $pdf->Cell($largura2, $altura, $_SESSION['nomedisp'], 1, 0, 'C');
                    $pdf->SetFont('Arial','',10);

                    $pdf->ln();
                    $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Ano', 1, 0, 'L');
                    $pdf->Cell($largura2, $altura, utf8_decode($query->get_creditos_ano($_SESSION['disp'], 0).'º'), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Semestre', 1, 0, 'L');
                    $pdf->Cell($largura2, $altura, utf8_decode($semestre), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Estudantes Inscritos', 1, 0, 'L');
                    $pdf->Cell($largura2, $altura, $ctr_est->contas_estudantes($_SESSION['disp'], $_SESSION['curso'],1,0), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Estudantes Avaliados', 1, 0, 'L');
                    $est_av = $ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 2, 0);
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
                    if ($est_add_ex = $ctr_est->contar_media($_SESSION['curso'], $_SESSION['disp'],3) == 0){
                        $est_add_ex = 1;
                    }
                    $pdf->Cell($largura2/2, $altura, $est_add_ex, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_add_ex/$est_av)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Excluidos do Exame Normal', 1, 0, 'L');
                    $est_ex_nor= $ctr_est->contar_media($_SESSION['curso'], $_SESSION['disp'],2);
                    $pdf->Cell($largura2/2, $altura,$est_ex_nor , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_ex_nor/$est_av)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Aprovados do Exame Normal', 1, 0, 'L');
                    $est_apr_exN= $ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 5, 4);
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
                    if (( $est_aus_exN = $ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 6, 4) )==  0){
                          $est_aus_exN  = 1;
                    }
                    $pdf->Cell($largura2/2, $altura,$est_aus_exN , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_aus_exN/$est_add_ex)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Admitidos ao Exame de Recorrência'), 1, 0, 'L');

                    if ( ($est_add_exR=$ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 7, 4) )== 0){
                        $est_add_exR = 1 ;
                    }

                    $pdf->Cell($largura2/2, $altura,$est_add_exR , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_add_exR/$est_add_ex)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Ausências no Exame de Recorrência'), 1, 0, 'L');
                    $est_aus_exR= $ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 6, 5);
                    $pdf->Cell($largura2/2, $altura, $est_aus_exR, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_aus_exR/$est_add_exR)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, utf8_decode('Aprovados do Exame de Recorrência'), 1, 0, 'L');

                    $est_apr_exR=$ctr_est->aprovados_exa_rec($_SESSION['curso'],$_SESSION['disp']);
                    $pdf->Cell($largura2/2, $altura, $est_apr_exR, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_apr_exR/$est_add_exR)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Dispensados', 1, 0, 'L');
                    $dipensa = $ctr_est->contar_media($_SESSION['curso'], $_SESSION['disp'],1);
                    $pdf->Cell($largura2/2, $altura,$dipensa , 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($dipensa/$est_av)*100,1), 1, 0, 'C');


                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Aprovados no Geral', 1, 0, 'L');
                    $est_aprG=$ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 8, 5)+$dipensa;
                    $pdf->Cell($largura2/2, $altura,$est_aprG, 1, 0, 'C');
                    $pdf->Cell($largura2/2, $altura, round(($est_aprG/$est_av)*100,1), 1, 0, 'C');

                      $pdf->ln();
                      $pdf->SetX(20);
                    $pdf->Cell($largura1, $altura, 'Reprovados no Geral', 1, 0, 'L');
                    $est_repG= $ctr_est->contas_estudantes($_SESSION['disp'],$_SESSION['curso'], 9, 5);
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
                    $pdf->Cell(50, 5, utf8_decode($publicar_pauta->buscar_docente($_SESSION['disp'])), 0, 0, 'C');


             ob_clean();
             $pdf->Output('Relatorio_Semestral_'.$_SESSION['nomedisp'].'.pdf','D');
}

?>