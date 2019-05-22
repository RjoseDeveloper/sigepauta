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
   require_once ('../QuerySql/RegistoAcademicoSQL.php');

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

     }elseif($_SESSION['tipo'] == 'racademico' && $_REQUEST['ctr'] != 'exames'){
         $idcurso = $_REQUEST['curso'];
     }else{
         $idAluno = $_REQUEST['idaluno'];
         $idcurso = $_REQUEST['curso'];
     }

    $discp = $_REQUEST['disp'];
    $acao = $_REQUEST['acao'];
    $estado_pn=2;

       switch ($acao) {
        case 1:
                 $nomeDisp = $pautaFreq->getnomeDisp($discp);
                 $nrmec = $pautaFreq->getMecaEstudante($idAluno);
                 $mediaf = $pautaFreq->obterMediaFrequecia($discp, $idAluno, $estado_pn, $idcurso, 0);

                 if ($mediaf > 0){

                     echo '<div ><br>';
                     echo ' <div  align="left" style="color: blue; margin-top:-1em"><h4>Pautas de Exame</h4></div>';
                     echo '<table class="table ui-body-d ui-shadow table-stripe ui-responsive" >';

                     echo '<tbody class="table_exame_freq">';
                     echo '<tr class="ui-bar-b table_frequencia" style="border:none" ><th>No.</th>';
                     echo '<th>Nota de <br> Frequencia</th>';
                     echo '<th>Resultado <br> Qualitativo de <br> Frequencia</th>';
                     echo '<th>Exame Normal</th>';
                     echo '<th>Recorrencia</th>';
                     echo '<th>Avaliacao <br> Final</th>';
                     echo '<th>Resultado Final<br> Qualitativo</th>';

                     echo '</tr>';

                     echo '<tr class="tbl_freq">';
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

              echo '</tbody></table></div><br>';
        break;

        case 2:

            $frm =""; $formula="";
            if ($ctr_est->obterQtdAvaliacaoPub($discp,$estado_pn,$idcurso, 0) >= 1) {

//                echo '<div  align="left" style="color: blue; margin-top:-4em"><h4>Mapa de Frequencia</h4></div>';

                echo '<div><table data-role="table" id="table-custom"
                                           class="table ui-body-c ui-responsive">';
                echo '<thead class="table_exame_freq">';

                if (($_SESSION['tipo'] != 'racademico')) {

                    $media = $pautaFreq->obterMediaFrequecia($discp, $idAluno, $estado_pn,$idcurso, 0);
                    $query = $pautaFreq->ordenacaoTestes($discp, $idAluno, $estado_pn,$idcurso,0);
                    $result = mysqli_query($db->openConection(), $query);

                    if (mysqli_num_rows($result) > 0){
                        echo '<tr class="table_frequencia" style="border: none; font-size: 12px; background-color: #fff">';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<th>'.$row['descricao'].'</th>';
                        }

                        $peso = $pautaFreq->returnPesoAvaliacao($discp,$row['tipo']);
                        $frm = $frm.'Media('.$row['descricao'].') *'.$peso/100;
                        $frm = $frm.'+';

                        /// Aplicar algoritmo de ordenacao para agrupar notas, calcular a media e nota de frequencia.

                        echo '<th>Media de <br> Frequencia</th>';
                        echo '<th>Resultado <br>Qualitativo de <br> Frequencia</th>';
                        echo '</tr></thead><tbody>';

                    echo '<tr class="tbl_freq">';

                $q_sql = $pautaFreq->ordenacaoTestes($discp, $idAluno, $estado_pn,$idcurso,0);
                $re_r = mysqli_query($db->openConection(), $q_sql);

                    while ($row = mysqli_fetch_assoc($re_r)) {

                        if ($row['nota'] != -1 || $idAluno > 0){
                            echo '<td>'.$row['nota'].'</td>';
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
                    $formula ='MediaFreq = '.$frm;
                    echo '</tr>';

                    }else{
                        echo'Impossivel Calcular a nota de frequencia';
                    }

                } else {

                    $query = $pautaFreq->ordenacaoTestes($discp,"",$estado_pn,$idcurso, 2); // ordena segundo deacordo com a pauta normal
                    $result = mysqli_query($db->openConection(), $query);

                    echo '<tr class="table_frequencia table-responsive" style="color:#0000CC; background:none; border-top: 2px solid #ccc">  ';
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
                        echo '<td>'.$linha['nomeCompleto'].'</td>';
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
                                <span class="glyphicon glyphicon-search"></span></button></td>';
                        $formula ='MediaFreq = '.$frm;
                        echo '</tr>';
                    }

                }

                echo '</tbody></table>';
                echo '<div style="color: green; font-size: 13px" align="center">'.$formula.' </div></div>';
                echo '<!--button class=" btn btn-warning" style="margin-top:-1em;" >
                        <span class="glyphicon glyphicon-print"></span>&nbsp; Imprimir</button-->';
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