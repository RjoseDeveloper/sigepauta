<?php

   require_once('../dbconf/getConection.php');
   require_once('../controller/EstudanteNotaCtr.php');
   require_once('../Query/AllQuerySQL.php');
   require_once('../Query/EstudantesSQL.php');
   require_once('../Query/RegistoAcademicoSQL.php');
    require_once('../controller/CursoCtr.php');
    require_once('../controller/DisciplinaCtr.php');
    require_once('../controller/DocenteCtr.php');
require_once('../controller/EstudanteCtr.php');

   $query = new QuerySql();
   $ra_sql = new RegistoAcademicoSQL();
   $curso_ctr = new CursoController();

    $docente_ctr = new DocenteController();
    $estudante_ctr = new EstudanteController();

   $db = new mySQLConnection();
   $estado = 2;
   $acao = $_POST['acao'];

         switch ($acao) {
             case 1:
                    $idDocx = $query->getDoc_id($_POST['director']);
                    $curso_ctr->insert($idDocx,$_POST['descricao'],$_POST['facul'],$_POST['codigo']);

                    break;

             case 2:
                       $var = "%".$_POST['texto']."%";
                       $comando = "".$query->getNome_from_ra($var);
                       echo "".$comando;
                  break;

          case 4:
                   $idDoc = $query->getDoc_id_user($_POST['email']);
                   $docente_ctr->insert_docente($_POST['fullname'],$idDoc, $_POST['grau']);
          break;

          case 5:
                    $disciplina_ctr->insert($_POST['nivel'], $_POST['creditos'],
                    $_POST['descricao'],$_POST['codigo']);
                    break;
          case 6:
              // unsed method
                    $texto = "%".$_POST['texto']."%";
                    $q= "SELECT docente.idDocente, utilizador.nomeCompleto
                    FROM docente INNER JOIN utilizador ON utilizador.id = docente.idUtilizador
                     WHERE utilizador.nomeCompleto LIKE '$texto'";

                    $db = new mySQLConnection();
                    $result = mysqli_query($db->openConection(), $q);
                    while ($row= mysqli_fetch_assoc($result)) {
                        echo '<li onClick="alert(this.value)" class="list-group-item" value="'.$row['idDocente'].'">'.$row['nomeCompleto']. '
                        <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';
                    }
                    break;
          case 7:
                    $docente_ctr->associar_doc_disp($_POST['curso'],$_POST['disp'],$_POST['doc']);
          break;

          case 8:
                    $idutil = $query->getDoc_id_user($_POST['email']);
                    $estudante_ctr->insert($idutil,$_POST['nrmec']);
                    break;
          case 9:
                    $texto = "%".$_REQUEST['texto']."%";
                    $curso = $_POST['curso'];
                    $disp ='';
                    session_start();

                    if ($_SESSION['tipo'] == 'racademico'){
                        $disp = $_POST['disp'];
                        echo '<ul data-role="listview" class="ul_aluno_curso" data-inset="true" data-mini="true" data-inline="true">';
                    }

                    $q = $ra_sql->query_filter_aluno($curso,$texto);
                    $result = mysqli_query($db->openConection(), $q);
                    while ($row= mysqli_fetch_assoc($result)) {

                        echo '<li onclick="buscar_pauta_freq('.$disp.')" value="'.$row['nrEstudante'].'" class="list-group-item" >';
                        echo $row['nomeCompleto'];
                        echo '<span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';
                    }
              if ($_SESSION['tipo'] == 'racademico'){
                  echo '</ul>';
              }
                    break;
          case 10:
                     $estudante_ctr->associar_estudante_disp($_POST['curso'], $_POST['disp'], $_POST['estudante']);
          break;

          case 11:

                $aluno = $_POST['nomec'];
                $idAluno =  $estudante_sql->getIdEstByNameApelido($aluno,1);
                $_SESSION['aluno'] = $idAluno;
                $q = $ctr_est->estudanteRec($idAluno,1);
                $result = mysqli_query($db->openConection(), $q);
                $t=0;
                while ($row= mysqli_fetch_assoc($result)) {
                        $vetor_x[] = Array('codigo'=>$row['codigo'],
                                        'descricao'=>$row['descricao'],
                                        'nota'=>$row['nota'],
                                        'idnota'=>$row['idNota'],
                                        'idDisp'=>$row['idDisciplina']) ;
                 }
                 echo json_encode($vector_x);
             $db->closeDatabase();
             break;

             case 12:

                 $string = $registo_academico->controlar_recorrencias($_POST['idcurso']);
                 $rs = mysqli_query($db->openConection(), $string);
                 while ($row= mysqli_fetch_assoc($rs)) {

                     echo '<tr style="font-size: 13px; color: #00516e;font-weight: bold" class="info">';
                     echo '<td>'.$row['nrEstudante'].'</td>';
                     echo '<td>'.$row['nomeCompleto'].'</td>';
                     echo '<td>'.$row['descricao'].'</td>';
                     echo '<td>'.$row['ano'].'⁰ Ano</td>';
                     echo '<td style="text-align: right"><button style="padding: 4px 15px" id="btn_assoc"
                      value="'.$row['idExameRec'].'" class="btn btn-warning btn-sm" data-mini="true"
                      onclick="obter_valor_recorrencia(this.value)">Autorizar</button></td>';
                     echo '</tr>';
                 }
                $db->closeDatabase();
                 break;

             case 13:
                    $rs = mysqli_query($db->openConection(),$ra_sql->obter_registos_disp_curso($_POST['curso']));
                    while ($row= mysqli_fetch_assoc($rs)){
                        echo '<li value="'.$row['idDisciplina'].'" onclick="buscar_pauta_freq(this.value)" class="lista_disciplinas">';
                        echo $row['descricao'];
                        echo '<span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';
                    }
                 break;
            default:
                echo 'Nenhum parametro foi enviado';
	}