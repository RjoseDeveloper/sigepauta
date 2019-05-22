<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 1/14/2018
 * Time: 11:59 PM
 */

require_once '../QuerySql/Classes.php';
require_once '../QuerySql/PessoaSQL.php';
require_once('../functions/db.php');
require_once('../functions/conexion.php');
require_once '../functions/getRowId.php';


$classes = new Classes();
$p = new PessoaSQL();
$param = $_REQUEST['acao'];
$messages ="";

?>

    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.css" type="text/css"
          xmlns="http://www.w3.org/1999/html"/>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css" type="text/css"/>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../libs/jQuery/js/jquery-1.11.3.js"></script>
    <script src="../_assets/js/jquery-1.8.3.min.js"></script>

    <script type="text/javascript" src="../libs/bootstrap/js/bootstrap.min.js"></script>

<?php

switch($param) {
    case 1:


        $idprovincia = $_GET['prov'];
        $rs = mysqli_query($con, $classes->find_distritos($idprovincia));
        echo '<select class="form-control" data-style="btn-primary" data-width="auto" name="distrito" id="distrito">';
        echo '<option>Seleccionar o distrito</option>';
        while ($row = mysqli_fetch_assoc($rs)) {
            echo '<option value="' . $row['iddistrito'] . '">' . $row['descricao'] . '</option>';
        }
        echo '</select>';
        break;


    case 2:

        $nome = $_REQUEST['nome'];
        $apelido = $_REQUEST['apelido'];
        $estado_civil = $_REQUEST['estadocivil'];
        $utilitizador = $_REQUEST['campo_utilizador'];
        $iddistrito = $_REQUEST['distrito'];
        $bi_recibo = $_REQUEST['bi_recibo'];
        $nivelescolar = $_REQUEST['nivelescolar'];
        $idendereco = $_REQUEST['endereco'];
        $data = $_REQUEST['data_nascimento'];
        $doenca = $_REQUEST['doenca'];
        $alergia = $_REQUEST['alergia'];
        $notas = $_REQUEST['notas'];
        $date_added = date("Y-m-d");
        $num_mec = date("Y") + rand(1000, 2000);

        // check if user or email address already exists
        $sql = "SELECT * FROM aluno WHERE idutilizador = '" . $utilitizador . "'";
        $query_check_user_name = mysqli_query($con, $sql);
        $query_check_user = mysqli_num_rows($query_check_user_name);
        if ($query_check_user == 1) {
            $messages = "O aluno ja foi registado.";
        } else {
            // write new user's data into database
            $sql = "INSERT INTO aluno (nome, apelido, bi_recibo, idnivelescolar,
                                        iddistrito, idendereco, idestadocivil, docenca_freq,
                                         alergia, notas, data_nascimento, nr_mec,
                                         idutilizador, data_ingresso)
                            VALUES('" . $nome . "','" . $apelido . "','" . $bi_recibo . "','" . $nivelescolar . "'
                                    ,'" . $iddistrito . "','" . $idendereco . "','" . $estado_civil . "'
                                    ,'" . $doenca . "','" . $alergia . "','" . $notas . "','" . $data . "'
                                    ,'" . $num_mec . "','" . $utilitizador . "','" . $date_added . "')";

            $query_new_user_insert = mysqli_query($con, $sql);
            // if user has been added successfully
            if ($query_new_user_insert) {
                $messages = "Aluno registado com sucesso.";
            } else {
                $messages = "Lamentamos houve problemas com os dados fornecidos";
            }
        }

        ?>

        <?php
        if ($_SESSION['tipo'] != 'estudante') {
            ?>

        session_start();


            <div class="container alert alert-success"> <?php echo "<strong>" . $messages . "<strong>" ?>
                <a href="../view/configAdmin/clientes.php" class="pull-right"> &times;</a>
            </div>

            if ($_SESSION['tipo'] != 'estudante'){?>


        <?php } else { ?>

            <div class="container alert alert-success"> <?php echo "<strong>" . $messages . "<strong>" ?>
                <a href="../view/Estudante_pauta.php" class="pull-right"> &times;</a>
            </div>

                <div class="container alert alert-success"> <?php echo "<strong>".$messages."<strong>" ?>
                    <a href="../view/GestaoFormando.php" class="pull-right"> &times;</a>
                </div>


        <?php } ?>

        <?php
        break;

    case 3:
        $rs = mysqli_query($con, $classes->find_formaando_list());
        while ($row = mysqli_fetch_assoc($rs)) {
            $vector[] = array('idformando' => $row['idformando'],
                'bi_recibo' => $row['bi_recibo'],
                'fullname' => $row['fullname']);
        }
        echo json_encode($vector);
        break;
    case 4:

        $curso = $_REQUEST['curso'];
        $iduser = $_REQUEST['user'];
        $disciplina = $_REQUEST['disciplina'];
        $turno = $_REQUEST['turno'];
        $regime = $_REQUEST['regime'];
        $turma = $_REQUEST['turma'];
        $date_added = date("Y-m-d");

        $query = "INSERT INTO inscricao(idturma, iddisciplina,idutilizador,
                                          data_registo, idregime,idturno)
                              VALUES ('" . $turma . "','" . $disciplina . "','" . $iduser . "',
                              '" . $date_added . "','" . $regime . "','" . $turno . "')";
        $inserted = mysqli_query($con, $query);

        $alert = "";
        if ($inserted) {
            $alert .= 'Operação Efectuada com sucesso';
        } else
            $alert .= 'Erro ao Tentar guardar o registo';
        ?>

        <div class="container alert alert-success"> <?php echo $alert ?>
            <a href="../view/GestaoFormando.php#menu1" class="pull-right active_btn"> &times;</a>
        </div>

        <?php
        break;

    case 5:

        $keyword = '%' . $_REQUEST['keyword'] . '%';
        $data = mysqli_query($con, $classes->find_formando_by($keyword));

        while ($row = mysqli_fetch_assoc($data)) {
            $vector[] = array('idformando' => $row['idformando'],
                'bi_recibo' => $row['bi_recibo'],
                'fullname' => $row['fullname']);
        }
        echo json_encode($vector);
        break;
    case 6:

        $curso_id = $_REQUEST['curso_ins'];
        $rs = mysqli_query($con, $classes->find_periodos_curso($curso_id));
        echo '<select class="form-control" data-style="btn-primary" onchange="guardar_id_periodo(this.value)" data-width="auto" name="periodo" id="periodo">';
        echo '<option>Seleccionar o Periodo ...</option>';
        while ($row = mysqli_fetch_assoc($rs)) {
            echo '<option value="' . $row['idperiodo'] . '">' . $row['descricao'] . '</option>';
        }
        echo '</select>';
        break;

    case 7:
        $curso = $_REQUEST['iduser'];
        $formador = $_REQUEST['formador'];
        $taxa = $_REQUEST['taxa'];

        $sql = 'INSERT INTO `curso`(`descricao`, `taxa`, `formador`) VALUES (?,?,?)';
        $stmt = mysqli_prepare($con, $sql);
        $result = mysqli_stmt_bind_param($stmt, 'sss', $curso, $taxa, $formador);

        if (mysqli_stmt_execute($stmt))
            echo 'Curso registado com sucesso !';
        else
            echo error_log('Problemas ao cadastrar curso:');
        break;


    Case 8: // processe lista de formandos por ordem do periodo ou mes de inscricao

        $curso_id = $_REQUEST['curso'];
        $ctr = $_REQUEST['ctr'];
        $turma = $_REQUEST['turma'];
        $disp = $_REQUEST['disciplina'];
        $aluno = $_REQUEST['aluno'];

        $res = mysqli_query($con, $classes->find_frm_periodos_or_mes($curso_id, $turma, $disp, $aluno, $ctr)); ?>

        <table class="table tbl_cursos">
            <thead>
            <tr class="info_cadastro">
                <th>id inscricao</th>
                <th>nr_mec</th>
                <th>Nome Completo</th>
                <th>Turma</th>
                <th>Disciplina</th>
                <th>Regime</th>
                <th>Turno</th>
                <th>Data de Registo</th>
                <th>Operações</th>
            </tr>
            </thead>
            <tbody>

            <?php
            while ($linhas = mysqli_fetch_assoc($res)) {
                ?>

                <tr>
                    <td> <?php echo $linhas['idinscricao'] ?></td>
                    <td> <?php echo $linhas['nr_mec'] ?></td>
                    <td> <?php echo $linhas['nomeCompleto'] ?></td>
                    <td> <?php echo utf8_encode($linhas['turma']) ?> </td>
                    <td><?php echo $linhas['disciplina'] ?></td>
                    <td><?php echo $linhas['regime'] ?></td>
                    <td> <?php echo $linhas['turno'] ?></td>
                    <td><?php echo utf8_encode($linhas['data_registo']) ?></td>

                    <td>
                        <button class='btn btn-warning btn-sm' title="Desabilitar Exame Especial"
                                value="<?php echo $linhas['idinscricao'] ?>"
                                onclick="desable_exame_especial(<?php echo $linhas['idaluno'] ?>, this.value)">
                            <span class='glyphicon glyphicon-off'></span></button>

                        &nbsp;<button class='btn btn-info btn-sm' value="<?php echo $linhas['idinscricao'] ?>"
                                      onclick="enable_exame_especial(<?php echo $linhas['idaluno'] ?>, this.value)">
                            <span class='glyphicon glyphicon-check' title="Activar Exame Especial"></span></button>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>

        <?php
        break;

    case 9:

        $curso_id = $_REQUEST['idcurso'];

        $stmt = mysqli_query($con, "select disciplina.idcurso, disciplina.idDisciplina, disciplina.descricao from disciplina");

        echo '<label for="periodo">Indicar disciplina:</label><br>';
        echo '<select class="form-control" required="" onchange="table_frm_disciplina(this.value)"  name="disciplina" id="disciplina">';

        while ($rw = mysqli_fetch_assoc($stmt)) {
            if ($rw['idcurso'] == $curso_id){
                echo '<option value="' . $rw['idDisciplina'] . '">' . utf8_encode($rw['descricao']) . '</option>';
            }

        }
        echo '</select>';

        $rs = mysqli_query($con, $classes->find_periodos_curso($curso_id));
        echo '<label for="periodo">Buscar turma:</label><br>';
        echo '<select required="" class="form-control" data-style="btn-primary"
 onchange="table_frm_periodos(this.value)" data-width="auto" name="turma" id="turma">';


        while ($row = mysqli_fetch_assoc($rs)) {
            echo '<option value="' . $row['idturma'] . '">' . utf8_encode($row['descricao']) . '</option>';
        }
        echo '</select>';


        if ($_REQUEST['ctr'] != 0) {

            echo '</div>&nbsp;&nbsp;';
            echo '<div class="form-group"><label for="periodo">Buscar/ Estudante:</label><br>';
            $rs = mysqli_query($con, $classes->find_estudante($curso_id));
            echo '<select class="form-control" data-style="btn-primary" onchange="table_frm_estudante(this.value)" data-width="auto" name="estudante" id="estudante">';
            echo '<option value="selected">Seleccionar Estudante</option>';

            while ($row = mysqli_fetch_assoc($rs)) {
                echo '<option value="' . $row['id'] . '">' . utf8_encode($row['fullname']) . '</option>';
            }
            echo '</select></div>';
        }

        break;

    case 10:

        $query = $_REQUEST['q'];
        $ctr = $_REQUEST['ctr'];

        $dados = mysqli_query($con, $classes->find_users($query, $ctr));
        while ($row = mysqli_fetch_assoc($dados)) {

            echo '<li style="width:100%; font-size:12px" class="list-group-item" value="' . $row['id'] . '"
                onClick="obter_estudante_nota(this.value' . ',' . $ctr . ');">' . $row['fullname'] . '
                  <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>';
        }

        break;

    case 11:
        $iduser = $_REQUEST['iduser'];
        $sql = "SELECT * FROM utilizador WHERE iduser = '$iduser'";
        $dados = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($dados)) {
            $vector[] = array('fullname' => $row['fullname'],
                'user' => $row['username'],
                'pass' => $row['password'],
                'prev' => $row['descricao']);

        }
        echo json_encode($vector);
        break;

    case 12:


        break;

    case 13:

        $idformador = $_REQUEST['idfrm'];
        $sql = "SELECT * FROM formando WHERE idformando = '$idformador'";
        $dados = mysqli_query($con, $sql);

        while ($row[] = mysqli_fetch_assoc($dados)) {
            ;
        }
        echo json_encode($row);
        break;


    case 14:
        ?>

        <table class="table">
        <thead class="info">


        <?php

        $id = $_REQUEST['id'];
        $res = mysqli_query($con, $p->list_emcarregado($id));

        if ($linhas = mysqli_fetch_assoc($res)) { ?>


            <tr>
                <th>Nr. Documento</th>
                <td><?php echo $linhas['nrdocumento'] ?></td>
            </tr>

            <tr>
                <th>Nome Completo</th>
                <td><?php echo $linhas['nomeCompleto'] ?></td>
            </tr>

            <tr>
                <th>Local de Trabalho</th>
                <td><?php echo $linhas['lcwork'] ?></td>
            </tr>

            <tr>
                <th>Contacto</th>
                <td><?php echo $linhas['contacto'] ?></td>
            </tr>

            <tr>
                <th>Nivel Escolar</th>
                <td><?php echo $linhas['nivel_escolar'] ?></td>
            </tr>

            <tr>
                <th>Grau de Parentesco</th>
                <td><?php echo $linhas['parentesco'] ?></td>
            </tr>

            <tr>
                <th>Acções</th>
                <td><a href="#" class="btn btn-warning" title="Editar Encarregado">
                        <i class="glyphicon glyphicon-edit"></i></a></td>
            </tr>

            </tbody> </table>'

        <?php }

        break;

    case 15:


        {
            $acao = (isset($_REQUEST['acao']) && $_REQUEST['acao'] != NULL) ? $_REQUEST['acao'] : '';
            //$aluno = (isset($_REQUEST['idaluno']) && $_REQUEST['idaluno'] != NULL) ? $_REQUEST['idaluno'] : '';
            $id_inscricao = (isset($_REQUEST['idinsc']) && $_REQUEST['idinsc'] != NULL) ? $_REQUEST['idinsc'] : '';
            $controlo=(isset($_REQUEST['controlo']) && $_REQUEST['controlo'] != NULL) ? $_REQUEST['controlo'] : '';

            //echo $id_inscricao;

            if ($controlo == 1) {
                mysqli_query($con, "UPDATE inscricao set status_exame='HABILITADO' 
                WHERE idinscricao='$id_inscricao'");
            }else{
                mysqli_query($con, "UPDATE inscricao set status_exame='NAO HABILITADO'
                WHERE idinscricao='$id_inscricao'");
            }
        }
        break;

    default:
        echo 'OPCAO INVALIDA';
}

?>


