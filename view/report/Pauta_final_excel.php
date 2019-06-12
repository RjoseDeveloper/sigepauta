<?php

$db = openConection();

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
          die('This example should only be run from a Web Browser');

/** Include PHPExcel */
 require_once dirname(__FILE__).'../../bibliotecas/PHPExcel/Classes/PHPExcel.php';

    $dsp = $_GET['disp'];
    $idcurso = $_GET['curso'];
    $curso = "";
    $disciplina = "";
    $creditos = "";
    $data = date('d-m-Y');
    $docente ="" ;
    $ano = "";
    $scorrente= "";


    $rsAvRec= "";
    $rsAvFinal= "";
    $rsAvExame = "";
    $rsQAmissao= "";
    $rsFinalQual = "";

    /*-------------------------------------------------------------*/
     if (date('m') > 0 &&  date('m') < 7){

           $s= 'º     Semestre:  1º';
       }else{
           $s ='º     Semestre:  2º';
     }
     $scorrente = utf8_decode($s);
     $ano = get_creditos_ano($dsp, 0);
     $ano= $ano.''.$s;
/*-----------------------------------------------------------------*/
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
           ->setLastModifiedBy("Maarten Balliauw")
           ->setTitle("Office 2007 XLSX Test Document")
           ->setSubject("Office 2007 XLSX Test Document")
           ->setDescription("Test document for Office 2007 XLSX")
           ->setKeywords("office 2007 openxml php")
           ->setCategory("Test result file");

// imgem

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Paid');
$objDrawing->setDescription('Paid');
$objDrawing->setPath('../img/logo_unilurio.jpg');
$objDrawing->setCoordinates('E1');
$objDrawing->setOffsetX(50);
//$objDrawing->setRotation(0);
$objDrawing->getShadow()->setVisible(false);
$objDrawing->setHeight(70);
//$objDrawing->getShadow()->setDirection(45);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$sheet = $objPHPExcel->getActiveSheet();

  // Set page orientation
             $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getTabColor()->setRGB('197354');

for ($col = 'C'; $col != 'M'; $col++) {

     if ($col != 'D' && $col != 'H' && $col != 'E' && $col != 'I'){
          $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
     }else{
         $sheet->getStyle('D')->getAlignment()->applyFromArray(
                    array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
           $sheet->getStyle('H')->getAlignment()->applyFromArray(
                    array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

           $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
           $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
           $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
     }

}


$objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('D5', 'Universidade Lurio')
                            ->setCellValue('D6', 'Faculdade de Engenharia')
                            ->setCellValue('D7', 'Campus Universitario Bairro Eduardo Mondlane')
                            ->setCellValue('I2', 'Visto')
                            ->setCellValue('H4', '__________________________')
                            ->setCellValue('H5', "Elido Tomás da Silva")
                            ->setCellValue('H6', 'Director da FE');
                            $sheet->mergeCells('D5:G5');
                            $sheet->mergeCells('D6:G6');
                            $sheet->mergeCells('D7:G7');
                            $sheet->mergeCells('D1:G1');
                            $sheet->mergeCells('H3:I3');
                            $sheet->mergeCells('H4:I4');
                            $sheet->mergeCells('H5:I5');
                            $sheet->mergeCells('H6:I6');
                            $sheet->mergeCells('B9:E9');
                            $sheet->mergeCells('B12:E12');
                            $sheet->mergeCells('B10:E10');
                            $sheet->mergeCells('B11:E11');
                            $sheet->mergeCells('H10:I10');
                            $sheet->mergeCells('H11:I11');
                            $sheet->mergeCells('H12:I12');

$objPHPExcel->getActiveSheet(0)->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B15:I15')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B15:I15')->getFill()->getStartColor()->setARGB('193742');

$objPHPExcel->getActiveSheet()->getStyle('B15:I15')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle(15)->getFont()->setBold(true)->setSize(14);
              $objPHPExcel->getActiveSheet()->getStyle('B15:I15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


                 $objPHPExcel->getActiveSheet()->getRowDimension(15)->setRowHeight(30);
                 $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B9', 'Curso: Licenciatura em '.nome_disp_curso($idcurso, 1))
                            ->setCellValue('B10', 'Disciplina: '.nome_disp_curso($dsp, 0))
                            ->setCellValue('B11', 'Ano: '.$ano)
                            ->setCellValue('B12', 'Docente: '.buscar_docente($dsp))
                            ->setCellValue('H10', 'Creditos: '.get_creditos_ano($dsp, 1))
                            ->setCellValue('H11', 'Ano Lectivo: '.date('Y'))
                            ->setCellValue('H12', 'Data: '.$data);

                //echo date('H:i:s') , " Add some data" , EOL;
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B15', 'No.')
                            ->setCellValue('C15', 'Nome Completo')
                            ->setCellValue('D15', 'Med. Freq')
                            ->setCellValue('E15', 'Resultado. Qual')
                            ->setCellValue('F15', 'Av. Exame')
                            ->setCellValue('G15', 'Recorrencia')
                            ->setCellValue('H15', 'Av. Final')
                            ->setCellValue('I15', 'Resultado. Qual');

                $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

              $i =16;
/*-------------------------------       Comeca as consultas ------------------------------------------*/

              $result = mysqli_query(openConection(), retornarConsulta($dsp, $idcurso));

              $t=0;

              while ($row = mysqli_fetch_assoc($result)) {

                 $idAluno = $row['idEstudante'];
                 $nome = $row['nomeCompleto'];
                 $nrmec = $row['nrEstudante']; //$pautaFreq->getMecaEstudante($idAluno);

                 $mediaf =round (obterMediaFrequecia($dsp, $idAluno, $idcurso,0));  // obtem media do exame frequencia
                 $mymedia = $mediaf;

              if ($mediaf > 0){

                 if ($mediaf < 10 ){

                        $rsAvRec= "--";
                        $rsAvFinal= "--";
                        $rsAvExame = "--";
                        $rsQAmissao= "Excluido";
                        $rsFinalQual ="Reprovado";

                     }

                    if ($mediaf >= 10 && $mediaf < 16){

                         $rsQAmissao ="Admitido";
                         $rsAvExame = getNotaExame($dsp, $idAluno,$idcurso, 0); // obter nota do exame normal

                        if ($rsAvExame >= 10){

                           $rsAvRec= "--";
                           $rsAvFinal = round(($rsAvExame*0.5)+($mediaf*0.5));

                        }else{

                             $rsAvRec =getNotaExame($dsp, $idAluno,$idcurso, 1); //obtem nota do exeme de recorrencia
                             $rsAvFinal = round(($mediaf*0.75)+($rsAvRec*0.25));
                        }

                     }

                     if($mediaf >= 16){

                        $rsAvRec= "--";
                        $rsAvFinal= $mediaf;
                        $rsAvExame = "--";

                        $rsQAmissao= "Dispensado";
                    }

                    if ($rsAvExame >= 10 || $rsAvRec >= 10  || $mediaf >=16){

                           $rsFinalQual= 'Aprovado';
                    }elseif($rsAvRec < 10 ){

                           $rsAvFinal= "--";
                           $rsFinalQual= 'Reprovado';
                    }
          }else{
                        $mediaf= 'a)';
                        $rsAvRec= "--";
                        $rsAvFinal= "--";
                        $rsAvExame = "--";
                        $rsQAmissao= "--";
                        $rsFinalQual ="--";
          }
     $objPHPExcel->getActiveSheet()->getStyle('B'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$i, $nrmec)   // Campo nrmec
        ->setCellValue('C'.$i, $nome)  // campo nome
        ->setCellValue('D'.$i, $mediaf) //
        ->setCellValue('E'.$i, $rsQAmissao)
        ->setCellValue('F'.$i, $rsAvExame)
        ->setCellValue('G'.$i, $rsAvRec)
        ->setCellValue('H'.$i, $rsAvFinal)
        ->setCellValue('I'.$i, $rsFinalQual);

     $i++;
}


// adiciona comentario
/*$objPHPExcel->getActiveSheet()->getComment('D')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('D')->getText()->createTextRun('eSimop-ac');
$objPHPExcel->getActiveSheet()->getComment('D')->getText()->createTextRun('Media de Frequencia');*/



$i=$i+1;

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$i++, "Observações:")
        ->setCellValue('B'.$i++, "Med_Freq = ∑(Ti/n)* peso + ∑(MTi/n)* peso+...+ ∑(Avaliações...i/n)* peso")
        ->setCellValue('B'.$i++, "NF_Ex_Normal = MedFreq* 0.50 + av.ExameNor* 0.50")
        ->setCellValue('B'.$i++, "NF_Ex_Rec = MedFreq* 0.75 + av.ExameRec* 0.25")
        ->setCellValue('B'.$i++, "Onde, n: Qt. de Avaliações")
        ->setCellValue('B'.$i++, "a) Sem avaliaçao");
$i=$i+1;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C'.$i++, "Docente(s)")
        ->setCellValue('C'.$i--, "______________________")

        ->setCellValue('E'.$i++, "Director do Curso")
        ->setCellValue('E'.$i--, "___________________")

        ->setCellValue('H'.$i++, utf8_decode("Director Adj. Pedagógico"))
        ->setCellValue('H'.$i++, "____________________")
        ->setCellValue('H'.$i++, "Miro de Nélio Tucua");

        //->setCellValue('C'.$i++, get_nome_adj());      ->setCellValue('C'.$i++, buscar_docente($dsp))

 $objWorksheet = $objPHPExcel->getActiveSheet();

        //add the new row
        $row = $objPHPExcel->getActiveSheet()->getHighestRow();
        $objWorksheet->insertNewRowBefore($row+1,2);


// Rename worksheet
$objPHPExcel->getActiveSheet()->getStyle('I22')->getProtection()->setLocked(
PHPExcel_Style_Protection::PROTECTION_UNPROTECTED); // POSSIVEL DE SER CORRIGIDO

$objPHPExcel->getActiveSheet()->getStyle('E22')->getProtection()->setLocked(
PHPExcel_Style_Protection::PROTECTION_UNPROTECTED); // POSSIVEL DE SER CORRIGIDO

$objPHPExcel->getActiveSheet()->getStyle('C22')->getProtection()->setLocked(
PHPExcel_Style_Protection::PROTECTION_UNPROTECTED); // POSSIVEL DE SER CORRIGIDO

$objPHPExcel->getActiveSheet()->getStyle('H5')->getProtection()->setLocked(
PHPExcel_Style_Protection::PROTECTION_UNPROTECTED); // POSSIVEL DE SER CORRIGIDO
// cria seguranca na folha ou pagina

$senha = rand(10, 1000);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('e-Simop-ac_db');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(false);

$objPHPExcel->getActiveSheet()->setTitle('Pauta_final_'.nome_disp_curso($dsp, 0));

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)

$var = 'Pauta_Final_'.nome_disp_curso($dsp, 0).'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$var.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;

/*
 * ------------------------------------- BACKUP ---------------------
 * $objPHPExcel->getActiveSheet()->getCell('B8')->getValue(); GETVAL FROMA CELL;
 * $objPHPExcel->getActiveSheet()->getCell('B8')->getCalculatedValue();
 * // Set cell B8
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, 'Some value');
 *
 * $objPHPExcel->getActiveSheet()->getCell('A1')->setValueExplicit('25', PHPExcel_Cell_DataType::TYPE_NUMERIC);
 *
 * $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
 *
 *
 *
 * */

 ?>

<?php


function openConection(){

          $connection = "";
          $db = "pautas_fe";
          $user="root";
          $url="localhost";
          $pass="dblinkx";
          $port="3306";

$connection = mysqli_connect($url,$user,$pass,$db) or die(mysqli_error());
return ($connection);
}

function nome_disp_curso($id, $ctr){

    if ($ctr == 0){
         $query = "select descricao from disciplina where idDisciplina='$id'";
    }else{

         $query = "select descricao from curso where idcurso= '$id'";
    }
    $result = mysqli_query(openConection(), $query);

    if ($row = mysqli_fetch_assoc($result)){
        return ($row['descricao']);
     }
}

function get_creditos_ano($disp, $ctr) {

          if($ctr == 0){
               $teste = "SELECT YEAR(data_registo) as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
          }else{
               $teste = "SELECT creditos as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
          }

          $result= mysqli_query(openConection(), $teste);

          if ($row = mysqli_fetch_assoc($result)){

                return ($row['valor']);
          }
}

function buscar_docente($dip){

    $q = "SELECT utilizador.nomeCompleto, utilizador.idSexo, grau_academico.descricao FROM docente
INNER JOIN utilizador ON utilizador.id= docente.idUtilizador
 INNER JOIN grau_academico ON grau_academico.idGrau = docente.idGrauAcademico
 INNER JOIN docentedisciplina ON docente.idDocente = docentedisciplina.idDocente
 INNER JOIN curso ON curso.idCurso = docentedisciplina.idCurso
            WHERE docentedisciplina.idDisciplina= '$dip'";

    $rs = mysqli_query(openConection(), $q);
    $t=0; $sexo="";
    if ($row= mysqli_fetch_assoc($rs)) {

          if ($row['idSexo'] == 1 && $row['descricao']!='Msc.' && $row['descricao']!="Ph.D"){
               $sexo='º';

          }elseif($row['idSexo'] != 1 ){
               $sexo='ª';
          }

          return ($row['descricao'].''.$sexo.'.  '.$row['nomeCompleto']);
    }
}

function get_Director_Curso($idcurso){
          $q ='SELECT CONCAT_WS(" º, ",grau_academico.descricao,utilizador.nomeCompleto) as coor_curso FROM docente
INNER JOIN curso ON curso.coordenador = docente.idDocente
INNER JOIN utilizador ON utilizador.id = docente.idUtilizador
INNER JOIN grau_academico ON grau_academico.idGrau= docente.idGrauAcademico WHERE curso.idCurso ='.$idcurso;

 $rs = mysqli_query(openConection(), $q);

    if ($row= mysqli_fetch_assoc($rs)) {
         return ($row['coor_curso']);
    }
}

function retornarConsulta($disp,$cr){

   return ("
                    SELECT estudante.nrEstudante,
                    utilizador.nomeCompleto,
                    estudante_disciplina.dataReg,
                    estudante.idEstudante,
                    curso.descricao
                    FROM
                    estudante INNER JOIN estudante_disciplina ON estudante_disciplina.idestudante = estudante.idEstudante
                    INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                    INNER JOIN disciplina ON disciplina.idDisciplina = estudante_disciplina.iddisciplina
                    INNER JOIN utilizador ON utilizador.id = estudante.idUtilizador
                    WHERE estudante_disciplina.iddisciplina = '$disp'
AND estudante_disciplina.idcurso='$cr'");
}

function get_nome_dir_adj($tipo_user){

    $query='SELECT CONCAT_WS(" ,",utilizador.nomeCompleto,grau_academico.descricao) as grau, utilizador.id FROM docente INNER JOIN

        grau_academico ON grau_academico.idGrau = docente.idGrauAcademico
         INNER JOIN utilizador ON utilizador.id = docente.idUtilizador
         INNER JOIN previlegio ON previlegio.idprevilegio = utilizador.idprevilegio
         WHERE previlegio.descricao='.$tipo_user;

         $result = mysqli_query(openConection(), $query);
        if ($row = mysqli_fetch_assoc($result)){return ($row['grau']);}
}

function obterMediaFrequecia($disciplina, $aluno,$curso,$ctr){

           $query = "SELECT DISTINCT AVG(estudante_nota.nota) as media, disciplina.idDisciplina,
                        tipoavaliacao.descricao, tipoavaliacao.idTipoAvaliacao as tipo from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                        INNER JOIN estudante_disciplina ON estudante_disciplina.iddisciplina = disciplina.idDisciplina

                        INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                        INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disciplina' AND estudante_nota.idEstudante = '$aluno'
                        AND pautanormal.estado= 2 AND pautanormal.idcurso= '$curso'";

            if ($ctr == 0){
                $query.="AND tipoavaliacao.idTipoAvaliacao < 4
                            GROUP BY tipoavaliacao.descricao;";
            }else{
                $query.="AND tipoavaliacao.idTipoAvaliacao >= 4
                            GROUP BY tipoavaliacao.descricao;";
            }
             $result = mysqli_query(openConection(), $query);

             if (mysqli_num_rows($result) > 0){
                 $soma =0;

                 while ($row = mysqli_fetch_assoc($result)) {

                     $ppeso = returnPesoAvaliacao($disciplina, $row['tipo'])/100;

                     $soma = $soma+ ($row['media']*$ppeso);
                 }
                return (round($soma));
            }else{
                return 'Sem Notas Completas';
            }

       }
function returnPesoAvaliacao($disp, $avaliacao)
        {
                $query =" SELECT planoavaliacao.peso FROM planoavaliacao
                      WHERE planoavaliacao.idDisciplina = '$disp' AND planoavaliacao.idTipoAvaliacao = '$avaliacao'";

             $result = mysqli_query(openConection(), $query);
             if ($row = mysqli_fetch_assoc($result)) {
                return ($row['peso']);
             }
        }
function getNotaExame($disciplina, $aluno,$curso, $ctr)
        {

                $query = "SELECT DISTINCT  estudante_nota.nota,tipoavaliacao.descricao from estudante_nota

                        INNER JOIN pautanormal on pautanormal.idPautaNormal = estudante_nota.idPautaNormal
                        INNER JOIN disciplina ON disciplina.idDisciplina = pautanormal.idDisciplina
                        INNER JOIN estudante_disciplina ON estudante_disciplina.iddisciplina = disciplina.idDisciplina

                        INNER JOIN curso ON curso.idCurso = estudante_disciplina.idcurso
                        INNER JOIN tipoavaliacao ON tipoavaliacao.idTipoAvaliacao = pautanormal.idTipoAvaliacao

                        WHERE disciplina.idDisciplina = '$disciplina' AND estudante_nota.idEstudante = '$aluno'
                        AND pautanormal.estado= 2 AND pautanormal.idcurso= '$curso'";

               if ($ctr == 0){

                   $query.= "AND tipoavaliacao.idTipoAvaliacao = 4";

               }else{
                   $query.="AND tipoavaliacao.idTipoAvaliacao = 5";

               }

                $result = mysqli_query(openConection(), $query);

                 if ($row = mysqli_fetch_assoc($result)) {
                     return ($row['nota']);
                  }

             }
?>
