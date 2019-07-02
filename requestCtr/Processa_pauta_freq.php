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
   require_once('../Query/PautaFrequenciaSQL.php');
   require_once('../controller/EstudanteCtr.php');
   require_once('../Query/RegistoAcademicoSQL.php');

   $query = new QuerySql();
   $pautaFreq = new PautaFrequencia();
   $estudante_sql = new EstudantesSQL();
   $resgisto_academico = new RegistoAcademicoSQL();
   $db = new mySQLConnection();

   $est_aluno = "";
    $mediaG="";
    $mediaRec="";

     if (isset($_SESSION['nomeC']) && $_SESSION['tipo'] == 'estudante') {

         $idAluno = $estudante_sql->getIdEstByNameApelido($_SESSION['nomeC'], "", 1);
         $idcurso = $estudante_sql->obterIdCursoEstudante($idAluno);

     }elseif($_SESSION['tipo'] != 'estudante' && $_REQUEST['ctr'] != 'exames'){
         $idcurso = $_REQUEST['curso'];
     }else{
         $idAluno = $_REQUEST['idaluno'];
         $idcurso = $_REQUEST['curso'];
     }

    $discp = $_REQUEST['disp'];
    $acao = $_REQUEST['acao'];
    //$idcurso = $_REQUEST['curso'];
    $estado_pn=2;

       switch ($acao) {
        case 1:
                 $nomeDisp = $pautaFreq->getnomeDisp($discp);
                 $nrmec = $pautaFreq->getMecaEstudante($idAluno);
                 $mediaf = $pautaFreq->obterMediaFrequecia($discp, $idAluno, $estado_pn, $idcurso, 0);

                 if ($mediaf > 0){

                     echo ' <br><div  align="left" style="color: blue"><h4>Pautas de Exame</h4></div>';
                     echo '<table data-role="table" id="table-custom" class="table ui-body-c ui-responsive">';

                     echo '<tbody class="table_exame_freq">';
                     echo '<tr class="ui-bar-b" style="border:none" ><th>No.</th>';
                     echo '<th>Nota de <br> Frequencia</th>';
                     echo '<th>Resultado <br> Qualitativo de <br> Frequencia</th>';
                     echo '<th>Exame Normal</th>';
                     echo '<th>Recorrencia</th>';
                     echo '<th>Avaliacao <br> Final</th>';
                     echo '<th>Resultado Final<br> Qualitativo</th>';

                     echo '</tr>';

                     echo '<tr class="">';
                     echo '<td>'.$nrmec.'</td>';
                     echo '<td>'.$mediaf.'</td>';

                     if ($mediaf >= 10 && $mediaf < 16){$estado = "Admitido"; }
                     if($mediaf < 10){$estado = "Excluido";}

                     if($mediaf >= 16){

                         $estado = "Dispensado";
                         $est_aluno="Aprovado";
                         $mediaG = $mediaf;
                         echo '<td>'.$estado.'</td>';
                     }else{

                         echo '<td>'.$estado.'</td>';
                         $mediaEx = $pautaFreq->getNotaExame($discp, $idAluno, $estado_pn,$idcurso, 0); // Obtem notado exeme normal
                         echo '<td>'.$mediaEx.'</td>';

                         if ($mediaEx >= 10){
                                 $est_aluno = 'Aprovado';
                                 $mediaG = round(($mediaf*0.50)+($mediaEx*0.50), 0);
                                 echo '<td style="color: red">---</td>';

                         }elseif($mediaEx < 10 ){$est_aluno = 'Recorrência';}

                     if ($mediaEx < 10 ) {
                         $mediaRec = $pautaFreq->getNotaExame($discp, $idAluno, $estado_pn, $idcurso, 1); //obtem nota do exeme de recorrencia

                         if ($_SESSION['tipo'] == 'racademico'){
                             // analisar se estudante possui recorrencia, caso seja activar para e remover o botao mostrar apenas a nota
                             echo '<td style="color:red"><button value="10" id="ex_rec" class="form-control btn btn-warning">
                                    <span class="glyphicon glyphicon-chevron-up"></span></button></td>';
                         }else{
                             echo '<td style="color:red">' . $mediaRec . '</td>';
                         }

                     }
                         if ($mediaRec >= 10 || $mediaEx >= 10 ){
                             $est_aluno = 'Aprovado';
                             $mediaG = round(($mediaf)+($mediaRec), 0);
                         }else{ $est_aluno = 'Reprovado';}
                     }

                         echo '<td style="color: red">'.$mediaG.'</td>';
                         echo '<td style="color: blue">'.$est_aluno.'</td>';
                         echo '</tr>';

                }else{
                     echo '<h4 style="color:red; text-align:center; margin-top: -1em">Nenhuma avaliação publicada</h4>';
                }

              echo '</tbody></table><br>';
        break;

        case 2:

            $frm =""; $formula="";

            /***
             * Estado 2 avaliacao ja foi realizada
             * Estado 1 avaliacao nao foi realizadas
             */

            if ($estudante_sql->obterQtdAvaliacaoPub($discp,2,$idcurso,0) == $estudante_sql->obterQtdAvaliacaoPub($discp,2,$idcurso,0) ) {

                echo '<br> <div  align="left" style="color: blue"><h4>Mapa de Frequencia</h4></div>';
                echo '<table data-role="table" id="table-custom" class="table ui-body-c ui-responsive">';
                echo '<thead>';

                    $query = $pautaFreq->ordenacaoTestes($discp,"",$estado_pn,$idcurso, 2); // ordena segundo deacordo com a pauta normal
                    $result = mysqli_query($db->openConection(), $query);

                    echo '<tr style="color:#0000CC;">  ';
                    echo '<th>No.</th>';
                    echo '<th>Nome Completo</th>';

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<th>'.$row['descricaoteste'].'</th>';
                    }

                    echo '<th>Nota de <br> Frequencia</th>';
                    echo '<th>Res.Qual de <br> Frequencia</th>';
                    echo '<th>Nota de <br> Exame</th></tr></thead>';

                    $sql = $resgisto_academico->obter_idalunos_pauta($discp,$idcurso);
                    $rs = mysqli_query($db->openConection(), $sql);

                    while($linha = mysqli_fetch_assoc($rs)){

                        echo '<tbody><tr>';
                        echo '<td>'.$linha['nrEstudante'].'</td>';
                        echo '<td style="text-align: left">'.$linha['nomeCompleto'].'</td>';
                        echo '<input type="hidden" value="'.$linha['idaluno'].'" id="comp_nrmec"/>';

                        $media = $pautaFreq->obterMediaFrequecia($discp, $linha['idaluno'], $estado_pn,  $idcurso, 0);
                        $query_x = $pautaFreq->ordenacaoTestes($discp, $linha['idaluno'],$estado_pn, $idcurso, 0);
                        $resultado = mysqli_query($db->openConection(), $query_x);

                        while ($row_x = mysqli_fetch_assoc($resultado)) {

                            if ($row_x['nota'] != -1 && $row_x['nota'] != null){
                                echo '<td>'.$row_x['nota'].'</td>';
                            }else{
                                echo '<td style="color: red">SN</td>';
                            }
                        }
                        echo '<td>'.$media.'</td>';
                        if ($media >= 10 && $media< 16 ){
                            $estado = "Admitido";
                        }
                        if($media >=16){
                            $estado = "Dispensado";
                        }
                        if($media < 10){
                            $estado = "Excluido";
                        }
                        echo '<td>'.$estado.'</td>';
                        echo '<td><button onclick="gerir_frequencia_disp(this.value,'.$idcurso.','.$discp.')"
                                class="btn btn-primary" value="'.$linha['idaluno'].'">
                                <span class="glyphicon glyphicon-eye"></span>Ver</button></td>';
                        $formula ='MediaFreq = '.$frm;
                        echo '</tr>';
                    }
                echo '</tbody></table>';

                echo '<div style="color: green; font-size: 13px" align="center">'.$formula.' </div>';

                }


            break;
            case 3:
                     $query = $pautaFreq->disciplina_docente_curso();
                     $result = mysqli_query($db->openConection(),$query);

                    echo' <select name="pdisciplina" class="drop" id="pdisciplina" style="width:33.5em;margin-top: -1em"  data-theme="c" data-native-menu="true">
                    <option value="" data-placeholder="false" disabled selected >Seleccionar Disciplina</option>';

                   while ($row= mysqli_fetch_assoc($result)){
                        echo '<option value="'.$row['idDisciplina'].'"
                        onClick="set_item_curso(this.value)" data-theme="b">'.$row['descricao'].'</option>';
                   }
                    echo'</select>';
	    break;

        default:

              break;
    }


?>