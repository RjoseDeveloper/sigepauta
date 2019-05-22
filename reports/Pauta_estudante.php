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
require_once('../controller/EstudanteCtr.php');


require_once '../libs/fpdf/fpdf.php';
require_once '../libs/fpdf/fpdf.css';
define('FPDF_FONTPATH', '../libs/fpdf/font/') ;

//define('FPDF_FONTPATH', '../fpdf/font/') ;

$ctr_est = new EstudantesSQL();
$link = new mySQLConnection();
$myvar = new PublicarPauta();
$pautaFreq = new PautaFrequencia();
$query_ctr = new QuerySql();

$idAluno=$ctr_est->getIdEstudante($_SESSION['username'],0);
$idc = $ctr_est->obterIdCursoEstudante($idAluno);

$semestre = date('m') < 7 ? '1º':' 2º';
$ano = date('Y');

//Initialize the 3 columns and the total
$column_tipo = "";
$column_nota = "";
$column_real = "";

$t =0;

if ($_GET['radio'] == 1){

    $disp = $_GET['disp']; // obtemos o nome da disciplina
    $ptn = get_creditos_ano($disp, 2); // obtemos o id da disciplina

    $nome_disp=$myvar->pautaNormal($ptn, 0);
    $idDisp=$myvar->pautaNormal($ptn, 1);
    $idcurso = $idc; //$myvar->pautaNormal($ptn, 2);
    $nomeCurso = $myvar->pautaNormal($ptn, 3);
    $tipo = $myvar->pautaNormal($ptn, 4);

    $pdf=new FPDF();

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    $pdf->Image('../img/unilurio.png',92,15,20);

    $pdf->setXY(0,0);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetTextColor(255,255,255);

    $pdf->SetFont('arial','I',12);
    $pdf->cell(0,12,'Unilurio,Faculdade de Engenharia(DEI)',1,$idc,'L',true);
    $pdf->SetTextColor('');

    /*----------------------------------------------------*/
    if (date('m') > 0 &&  date('m') < 7){

        $s= '1º Semestre ';
    }else{
        $s =' 2º Semestre ';
    }


    $s= $s.' / '.date('Y');
    $scorrente = utf8_decode($s);

    $pdf->SetXY(0,40);
    //$pdf->SetFillColor(14,128,23);
    $pdf->SetFont('arial','i',18);
    $pdf->SetTextColor(2,64,128);
    $pdf->SetFillColor('');


    $var = utf8_decode("Relatório das Avaliações - ");

    $pdf->Cell(0,10,$var.' '.$_SESSION['nomeC'],0,0,'C');
    $pdf->ln();
    $pdf->Cell(0,10,$scorrente,0,1,'C');

    $pdf->SetTextColor('');
    $pdf->SetFont('arial','I',13);
    $posX = 20;
    $posY = 40;

    $tipo=30;
    $nota=80;
    $data=130;

    $disciplinas = $ctr_est->estudanteDisciplina($idAluno, "", 0, $semestre, $ano);

    foreach ($disciplinas as $row) {

        if ($row!= null && $ctr_est->obterQtdAvaliacaoPub($row['idDisciplina'],2,$idcurso, 0) > 0 ){

            $pdf->SetFillColor(2,23,23);
            $pdf->SetFont('Arial','',12);

            $pdf->SetXY($tipo,$posY-8.3);
            $pdf->Cell(50,8,''.$row['descricao'],1,1,'L');

            $pdf->SetTextColor(255,  255, 255);
            $pdf->SetXY($tipo,$posY);
            $pdf->Cell(50,10, utf8_decode('Tipo de Avaliação'),1,0,'C',1);

            $pdf->SetXY($nota,$posY);
            $cl ="Classificação";
            $pdf->Cell(60,10,utf8_decode($cl),1,0,'C',1);

            $pdf->SetXY($data,$posY);
            $pdf->Cell(50,10,utf8_decode('Data de Realização'),1,0,'C',1);

            //$idcurso = $query_ctr->obterCursoEstudante($_SESSION['username']);

            $query=$ctr_est->getpautaDate($row['idDisciplina'], $idAluno, 2, $idcurso);
            $validarRec = $ctr_est->estudanteRec($idAluno, 1);
            $pdf->SetTextColor(0,0,0);

            $db = new mySQLConnection();
            $result = mysqli_query($db->openConection(), $query);

            $t = 0; $t1=0; $t2=0; $t3=0;
            $number_of_row = mysqli_num_rows($result);

            $i=0;
            $validar_rec= $ctr_est->validar_busca_recorrencia($idAluno, $row['idDisciplina'], $idcurso, 5);

            if ($number_of_row > 0){
                while($rs = mysqli_fetch_assoc($result)){

                    if ($pdf->GetY() > 250){

                        $pdf->AddPage();
                        $pdf->SetFont('Arial','B',10);
                    }

                    if ($rs['tipo'] == 1){
                        $k = ++$t1;
                    }
                    if ($rs['tipo'] == 2){
                        $k = ++$t2;
                    }
                    if ($rs['tipo'] == 3){
                        $k = ++$t3;
                    }

                    $pdf->SetFont('Arial','',12);
                    $pdf->SetXY($posX+10.2,$posY+10);

                    if ($rs['tipo'] <= 3){

                        $pdf->Cell(50,8,$rs['descricao'].'-'.$k,1,'C');
                    }else{
                        $pdf->Cell(50,8,$rs['descricao'],1,'C');
                    }

                    $pdf->SetXY($posX+60.3,$posY+10);

                    $id = $idDisp = $ctr_est->returnTipo($rs['idNota'], 1);
                    if (($rs['tipo'] == 5) && ($ctr_est->validarRecorrencia($idAluno, $id)  == 1)){
                        $pdf->MultiCell(50,8,$rs['nota'],1,'C');
                    }else{
                        $pdf->MultiCell(50,8,$rs['nota'],1,'C');
                    }

                    $pdf->SetXY($posX+110.2,$posY+10);
                    $pdf->MultiCell(49.7,8,$rs['dataReg'],1,'C');
                    $posY=$posY+8;
                }

            }
        }

        $posY=$posY+30;

    }
    ob_clean();
    $pdf->Output("Pauta_".$_SESSION['nomeC']."/Ano-".date('Y')."/Resultados.pdf","D");

}elseif ($_GET['radio']== "on"){


    $pdf=new FPDF();

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    $pdf->Image('../img/unilurio.png',92,15,20);

    $pdf->setXY(0,0);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetTextColor(255,255,255);

    $pdf->SetFont('arial','I',12);
    $pdf->cell(0,12,'eSimop-ac',1,$idcurso,'L',true);
    $pdf->SetTextColor('');

    $pdf->setXY(80,80);
    $pdf->Cell(50,10,utf8_decode('Sem implementação'),0,0,'C');

    ob_clean();
    $pdf->Output('Pauta Final.pdf','I');

}

?>


<?php

function get_creditos_ano($disp, $ctr) {

    if($ctr == 0){
        $teste = "SELECT anolectivo as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
    }
    if ($ctr == 1){
        $teste = "SELECT creditos as valor FROM disciplina WHERE disciplina.idDisciplina = '$disp'";
    }

    if ($ctr == 2){
        $teste = "SELECT idDisciplina as valor FROM disciplina WHERE disciplina.descricao = '$disp'";

    }

    $link = new mySQLConnection();
    $result= mysqli_query($link->openConection(), $teste);

    if ($row = mysqli_fetch_assoc($result)){

        return ($row['valor']);
    }


}


function obterIdCursoEstudante($e){

    $query ="SELECT DISTINCT estudante_disciplina.idcurso FROM estudante_disciplina
                              WHERE estudante_disciplina.idestudante = '$e'";

    $db = new mySQLConnection();

    $result = mysqli_query($db->openConection(), $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['idCurso'];
    }
}

?>