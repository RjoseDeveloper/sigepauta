<?php

    session_start();
    require_once('../../dbconf/getConection.php');
    require_once('../../controller/EstudanteNotaCtr.php');
    require_once('../../controller/PautaNormalCtr.php');
    require_once('../../Query/AllQuerySQL.php');
    require_once("../../controller/PautaRecorrenciaCtr.php");
    require_once '../../controller/PlanoAvaliacaoCtr.php';

    require_once '../../bibliotecas/fpdf/fpdf.php';
    require_once '../../bibliotecas/fpdf/fpdf.css';

    define('FPDF_FONTPATH', '../fpdf/font/') ;

         $acao = $_GET['acao'];
         $pdf = new FPDF('P','cm','A4');
         $pdf = new FPDF();
         $pdf->Open();

         switch ($acao) {

            case 1 || 3 || 4:

                  $contente = "";
                  $pdf->SetTextColor(232,  25, 255);
                  $contente.="eSimop-ac (Sistema ingrado movel de pautas Academicas)";
                  $contente.="Este sistema eh uma vitrina movel e virtual que permite ao estudante ter acesso aos resultados";
                  $contente.="de suas avaliacoes apartir do seu dispositivo movel (Smarphone e PC)";
                  $contente.="nas diversar disciplinas do curso no qual o estudante encontra inscrito";
                  $contente.="sendo que, recomenda- se acessar atraves do telefone celular ou Tablets para melhor performance visual";
                  $pdf->SetTextColor(2, 12, 255);
                  $pdf->AddPage();
                  $contente.="O que ha de novidade";
                  $contente.= "Mostrar pautas normais por tipo de avaliacao";
                  $contente.="Mostrar pautas de frequencia e o respectivo mapa de frequencia emitido no final de cada semestre";
                  $contente.="Mostrar pautas de exames de recorrencia mediante a taxa pag";
                  $contente.="Permite ainda armazenar no dispositivo local o resultado de cada avaliacao pesquisada";

                    //define a fonte utilizada para odocumento
                    $pdf->SetFont("Arial",'', 12);
                    //titulos de configuração do documento
                    $pdf->SetAuthor("Unilurio-fe");
                    $pdf->SetTitle("Pauta de Frequecia do primeiro semestre");
                    $pdf->SetSubject("a");
                    $pdf->Header();

                    $cabecalho = 'Unilurio-fe';
                    $pdf->Image('../img/logo_unilurio.jpg',10,8,33);
                    //exibe o cabecalho do documento
                    $pdf->MultiCell(0,5,"$cabecalho",0, 'C');
                    //distancia do titulo da margem superior
                    $pdf->Ln(6);
                    //Titulo do documento
                    $pdf->MultiCell(0,5,"Mecanica e Ondas",0,'C');
                    //distancia do texto e do titulo do documento
                    $pdf->Ln(10);

                    $pdf->cell(50,10, 'alunos',1,0,'C');
                    $pdf->cell(50,10,'provas',1,1,'C');
                    $pdf->cell(50,10, 'alunos',1,0,'C');
                    $pdf->cell(50,10,'provas',1,1,'C');
                    //texto do documento
                    //gerar o texto no documento
                    $pdf->MultiCell(0,5,"$contente",0, 'J');

                    ob_clean(); // Limpa o buffer de saída
                    //cria o arquivo pdf e exibe no navegador
                    if ($acao == 4){

                        $pdf->Output('C:\Users\Ajuda_eSimop-ac.pdf','F');
                        echo("<script>window.location ='../../index.php';</script>");

                    }if($acao == 1){
                        $pdf->Output('Ajuda_eSimop-ac.pdf','D');
                    }if ($acao == 3) {
                        $pdf->Output('Ajuda_eSimop-ac.pdf','I');
                    }
                    //$pdf->Output();
                    exit;
               break;
            case 2:
                    $pdf = new FPDF('P','cm','A4');
                    $pdf = new FPDF();
                    $pdf->Open();
                    $pdf->AddPage();
                    //define a fonte utilizada para odocumento
                    $pdf->SetFont("Arial",'', 12);
                    //titulos de configuração do documento
                    $pdf->SetAuthor("Unilurio-fe");
                    $pdf->SetTitle("Pauta de Frequecia do primeiro semestre");
                    $pdf->SetSubject("a");
                    $pdf->Header();

                    $cabecalho = 'Unilurio-fe';
                    //exibe o cabecalho do documento
                    $pdf->MultiCell(0,5,"$cabecalho",0, 'C');
                    //distancia do titulo da margem superior
                    $pdf->Ln(6);
                    //Titulo do documento
                    $pdf->MultiCell(0,5,"Mecanica e Ondas",0,'C');
                    //distancia do texto e do titulo do documento
                    $pdf->Ln(6);
                    //texto do documento
                    $texto = 'MEU NOME E RAIMUNDO NAO QUERO DIZER QUE SOU MEIO NO PHP ';

                            //gerar o texto no documento
                    $pdf->MultiCell(0,5,"$texto",0, 'J');

                    ob_clean(); // Limpa o buffer de saída
                    //cria o arquivo pdf e exibe no navegador
                    $pdf->Output('teste.pdf','I');
                    //$pdf->Output();
                    exit;
                    break;
         default:
                break;
         }





