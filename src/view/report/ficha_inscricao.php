<?php

            session_start();

            require_once '../Query/Classes.php';
            require_once '../bibliotecas/fpdf/fpdf.php';
            require_once '../bibliotecas/fpdf/fpdf.css';
            define('FPDF_FONTPATH', '../bibliotecas/fpdf/font/') ;

            echo '<meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">';

            $classes = new Classes();
            $db = new mySQLConnection();
            $curso = $_REQUEST['curso'];
            $formando = $_REQUEST['formando'];

            // variaveis que guardam textos

            $obs = '';// VARIAVEIS DE SEPARACAO DE COLUNAS

            $setx = 10; // this variable is constant

            $pdf=new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',11);
            $pdf->Image('../img/unilurio.png',85,15,30);

            $pdf->setXY(0,0);
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetTextColor('');

            // ------------ Coloca um fundo no cabecalho

            $pdf->SetFont('arial','I',8);
            $pdf->cell(0,12, utf8_decode('SIGPFE - Sistema de Gestão de Pautas Academicas'),0,0,'C');

            $pdf->SetTextColor('');
            $pdf->SetFont('arial','',12);
            //  -----------  Fim fundo .

              $pdf->setXY(75,50);
              $pdf->Cell(50,6,utf8_decode('UNIVERSIDADE LÚRIO'),0,0,'C');
              $pdf->ln();$pdf->setX(75);
              $pdf->Cell(50,6,utf8_decode('FACULDADE DE ENGENHARIA'),0,0,'C');

              $pdf->SetFont('Arial','',9);
              $pdf->ln();$pdf->setX(75);
              $pdf->Cell(50,6,utf8_decode('Bairro Eduardo Mondlane, Cidade de Pemba'),0,0,'C');

                // acesso a registros da base de dados
              $pdf->SetFont('Arial','B',10);
              $pdf->ln(10);
              $pdf->SetX($setx);

                    $query = $classes->find_frm_periodos_or_mes($curso,0,0,$formando,2);
                    $db_row= mysqli_query($db->openConection(), $query);

                   if ($rs = mysqli_fetch_assoc($db_row)) {

                       $pdf->MultiCell(170, 10, utf8_decode('FICHA DE INSCRIÇÃO - ' . strtoupper(utf8_decode($rs['nomeCompleto']))), 0, 'C');

                       $pdf->SetX($setx + 12);
                       $pdf->Cell(60, 6, utf8_decode('Ementa *'), 0, 0, 'L');
                       $pdf->ln();
                       $pdf->SetFont('Arial', '', 10);
                       $pdf->SetX($setx + 12);
                       $pdf->MultiCell(170, 6, utf8_decode($obs), 0, 'J');

                       $pdf->ln();
                       $pdf->SetFont('Arial', 'I', 9);
                       $pdf->Cell(200, 6, utf8_decode('DADOS GERAIS DO CADASTRO'), 0, 0, 'C');
                       $pdf->SetFont('Arial', 'B', 9);
                       $pdf->ln(10);

                       $pdf->SetX($setx);
                       $largura1 = 70; // Largura da coluna 1
                       $largura2 = 80; // largura da coluna 2
                       // altura padrão das linhas das colunas
                       $altura = 4;

                       // criando os cabeçalhos para 5 colunas
                       //$pdf->SetTextColor(255, 250, 250);
					   $pdf->SetFillColor(255,255,240);
                       $pdf->Cell($largura1, $altura, 'Nome Completo:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['nomeCompleto'], 'B', 1, 'C', true);
                       $pdf->SetFont('Arial', '', 10);
					   
					   $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(240,255,240);
                       $pdf->Cell($largura1, $altura, 'BI ou Recibo:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['bi_recibo'], 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(255,255,240);
                       $pdf->Cell($largura1, $altura, 'Sexo:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['sexo'], 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(240,255,240);
                       $pdf->Cell($largura1, $altura, 'Nivel Escolar:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['nivel'], 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(255,255,240);
                       $pdf->Cell($largura1, $altura, utf8_decode('Endereço Domicilio'), 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['bairro'], 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(240,255,240);
                       $pdf->Cell($largura1, $altura, 'Curso:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['curso'], 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(255,255,240);
                       $pdf->Cell($largura1, $altura, 'Taxa do Curso:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['taxa'] . ',00', 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(240,255,240);
                       $pdf->Cell($largura1, $altura, utf8_decode('Prestação Efectuada:'), 0, 0, 'R');
                       $pdf->Cell($largura2, $altura,  ',00', 'B', 1, 'C',true);

//                       $pdf->ln();
//                       $pdf->SetX($setx);
//					   $pdf->SetFillColor(255,255,240);
//                       $pdf->Cell($largura1, $altura, 'Periodo:', 0, 0, 'R');
//                       $pdf->Cell($largura2, $altura, 'B', 1, 'C', true);

                       $pdf->ln();
                       $pdf->SetX($setx);
					   $pdf->SetFillColor(240,255,240);
                       $pdf->Cell($largura1, $altura, 'Contactos:', 0, 0, 'R');
                       $pdf->Cell($largura2, $altura, $rs['celular'] . ' ou ' . $rs['email'], 'B', 1, 'C', true);

                       // pulando a linha
                       $pdf->ln(14);
                       $pdf->SetX(80);
                       $pdf->Cell(50, 5, utf8_decode('Pemba, ' . date('d') . ' de ' . $classes->return_mes() . ' de ' . date('Y')), 0, 0, 'C');

                       $pdf->ln();
                       $pdf->SetX(80);
                       $pdf->Cell(50, 5, 'Secretario (a)', 0, 0, 'C');

                       $pdf->ln();
                       $pdf->SetX(81);
                       $pdf->Cell(50, 5, "", "B", 1, 'C');

                       $pdf->ln();
                       $pdf->SetX(82);
                       $pdf->Cell(50, 5, "", 0, 0, 'C');


                       if ($pdf->GetY() > 285){

                           $pdf->AddPage();
                           $pdf->SetFont('Arial','B',10);
                       }

                       $pdf->ln();
                       $pdf->SetY(263);
                       $pdf->SetFont('Arial','I',8);
                       $pdf->Cell(0, 5,utf8_decode( 'Cursos e Oportunidades:'), 0, 0, 'C');
                       $pdf->ln();
                       $pdf->Cell(0, 5,utf8_decode( '1. Engenharia Civil, 2. Engenharia Mecanica, 3.Engenharia Geologica,
 4. Engenharia Informatica, 5. Ciencias Biologicas'), 0, 0, 'C');

                       $pdf->SetY(271);
                       $pdf->Cell(0, 5, 'Software desenvolvido pelo Data Center, FE/2018', 0, 0, 'C');
                       ob_clean();
                       $pdf->Output('inscricao_'.$rs['nomeCompleto'].'.pdf', 'I');
                   }
