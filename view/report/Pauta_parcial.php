<?php

   require_once('../../Query/PublicacaoPautaSQL.php');
   require_once("../../dbconf/getConection.php");
   require_once('../../controller/EstudanteNotaCtr.php');
   require_once('../../controller/PautaNormalCtr.php');
   require_once('../../Query/EstudantesSQL.php');
   require_once('../../controller/PautaNormalCtr.php');
   require_once('../../Query/PublicacaoPautaSQL.php');
   require_once('../../Query/PautaFrequenciaSQL.php');
    require_once('../../controller/EstudanteCtr.php');


    require_once '../../bibliotecas/fpdf/fpdf.php';
    require_once '../../bibliotecas/fpdf/fpdf.css';
    define('FPDF_FONTPATH', '../../bibliotecas/fpdf/font/') ;

   echo '<meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">';
    $sql_estudante = new EstudantesSQL();
   $link = new mySQLConnection();
   $publicar_pauta = new PublicarPauta();
   $pautaFreq = new PautaFrequencia();

            //Initialize the 3 columns and the total
            $column_nr = "";
            $column_nome = "";
            $column_nota = "";
            $docente ="";
            $scorrente = "";
            $teste ="";
            $curso="";

            $t =0;

                 $ptn = $_GET['ptn'];
                 $nome_disp=$publicar_pauta->pautaNormal($ptn, 0);
                 $idDisp=$publicar_pauta->pautaNormal($ptn, 1);
                 $idcurso = $publicar_pauta->pautaNormal($ptn, 2);
                 $nomeCurso = $publicar_pauta->pautaNormal($ptn, 3);
                 $tipo = $publicar_pauta->pautaNormal($ptn, 4);

                 $var  = $sql_estudante->listar_tipo_avaliacao($idDisp, $idcurso, $ptn);
                 $teste = utf8_decode($tipo);

	             $pdf=new FPDF();
                 $pdf->AddPage();
                 $pdf->SetFont('Arial','B',10);

      $vetor = $sql_estudante->novo_modelo_relatorio($ptn,2);
      $result= mysqli_query($link->openConection(),$vetor);
      $number_of_row = mysqli_num_rows($result);
      $i=0; $coluna= 76;

      while($row = mysqli_fetch_assoc($result)){
          if ($i == 0 ){
              $dp = $row['disp'];
          }

      if ($sql_estudante->validar_busca_recorrencia($row['idaluno'], $idDisp, $idcurso, 4) < 10){
           $i++;
        if ($row["nota"] == -1){
            $rs_nota = 'SN';
        }else{
            $rs_nota = $row['nota'];
          }
                $column_nr = $column_nr.$row["nrmec"]."\n";
                $column_nome = $column_nome.$row["nomeCompleto"]."\n";
                $column_nota= $column_nota.$rs_nota."\n";
			    if ($i > 1 ){
					  $pdf->SetXY(25,$coluna);
					  $pdf->Cell(165,6,"","B",1,'C');
					  $coluna= $coluna + 6;
		        }

             }
        }

              $pdf->Image('../fragments/img/unilurio.png',30,15,25);

//require '../view/fragments';

              $pdf->setXY(25,40);
              $pdf->Cell(50,5,'Universidade Lurio - FE',0,0,'L');

              /*----------------------------------------------------*/

              if (date('m') > 0 &&  date('m') < 7){
                     $s= '1º Semestre';
                 }else{
                     $s =' 2º Semestre';
             }
             $scorrente = utf8_decode($s);

             /*-------------------------------------------*/

              $pdf->SetFont('Arial','',10);
              $anolectivo = date('Y');

              $pdf->setXY(65,25);

              $pdf->Cell(50,5,'Pauta '.$teste,0,0,'C');

              $pdf->setXY(65,30);
              $pdf->Cell(50,5,$scorrente,0,0,'C');

              $pdf->setXY(65,35);
              $pdf->Cell(50,5,'Ano Lectivo de '.$anolectivo,0,0,'C');

              $pdf->setXY(130,20);
              $pdf->Cell(50,5,'Visto',0,0,'C');

              //$pdf->setXY(140,25);
              //$pdf->Cell(50,5,'',0,1,'C');
              $pdf->setXY(130,30);
              $pdf->Line(130, 32, 180,32);

              $pdf->setXY(130,35);
              $pdf->Cell(50,5,$publicar_pauta->get_nome_dir_adj("Director Adj. Pedagogico"),0,0,'C');

              $pdf->setXY(130,40);
              $pdf->Cell(50,5,'Director Adj. Pedagogico',0,0,'C');

              $pdf->SetFont('Arial','B',12);
              $pdf->setXY(25,50);
              $pdf->Cell(50,5,'Curso: ',0,0,'L');

              $pdf->setXY(25,55);
              $pdf->Cell(50,5,'Disciplina: ',0,0,'L');

              $pdf->setXY(25,60);
              $pdf->Cell(50,5,'Data: ',0,0,'L');

              $pdf->SetFont('Arial','',12);
              $pdf->setXY(50,50);
              $pdf->Cell(50,5,$nomeCurso,0,0,'L');

              $pdf->setXY(50,55);
              $pdf->Cell(50,5,$nome_disp,0,0,'L');

              $data = date('Y-m-d');
              $pdf->setXY(50,60);
              $pdf->Cell(50,5,$data,0,0,'L');

              $pdf->SetFillColor(2,23,23);
	    $pdf->SetTextColor(255,  255, 255);
                    //Bold Font for Field Name
              $pdf->SetFont('Arial','B',12);

              $pdf->SetXY(25,70);
              $pdf->Cell(40,6,'Nr.Mec',1,0,'L',1);

              $pdf->SetXY(60,70);
              $pdf->Cell(100,6,'Nome Completo',1,0,'C',1);

              $pdf->SetX(150,70);
              $cl ="Classificação";
              $pdf->Cell(40,6,utf8_decode($cl),1,0,'C',1);
              $pdf->Ln();

              ///Impressao de multiplas linha

                //$pdf->SetFillColor(240,240,240);

              $pdf->SetFont('Arial','',12);
              $pdf->SetTextColor('', '', '');
              $pdf->SetXY(25,76);
              $pdf->MultiCell(35,6,$column_nr,1,'C');


              $pdf->SetXY(60,76);
              $pdf->MultiCell(90,6,$column_nome,1,'L');


              $pdf->SetXY(150,76);
              $pdf->MultiCell(40,6,$column_nota,1,'C');
                $pdf->Ln();

$pdf->MultiCell(0,6,utf8_decode("Observações - SN (Sem nota)"),0,'C');

              $pdf->SetFont('Arial','I',8);
              // Page number
              $pdf->SetY(255);
              $pdf->Cell(0,5,'Docente/s da Disciplina',0,0,'C');
              $pdf->setXY(60,230);

              $pdf->SetXY(60,260);
              $pdf->Cell(85,5,"","B",1,'C');

              $db = new mySQLConnection();
              $dados= $sql_estudante->buscarDadosDisciplina($idDisp,$idcurso);
              $result = mysqli_query($db->openConection(), $dados);

              $tt=0; $sexo=""; $doc= "";

              while($row = mysqli_fetch_assoc($result)){
                   $tt++;

              if ($row['sexo'] == 'M'){
                $sexo= utf8_decode('º');}else{$sexo=utf8_decode('ª');}

                $doc.=utf8_encode($row['grauAcademico'].''.$sexo.'.  '.$row['nomeCompleto'].' ');

                if ($tt >= 1 && $row['sexo']!=null){
                   $doc.="  , ";
                }
              }

              $docente = utf8_decode($doc);
              $pdf->Cell(0,10,$docente,0,0,'C');

              ob_clean();
              $pdf->Output($nome_disp.' - '.$tipo.'.pdf',$_GET['acao']);
?>
