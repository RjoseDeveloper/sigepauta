<?php
session_start();

require_once '../Query/EstudantesSQL.php';
require_once '../dbconf/getConection.php';

$estudante_sql = new EstudantesSQL();
$db = new mySQLConnection();
$semestre = date('m') < 7 ? '1º':' 2º';
$ano = date('Y');

$semis = date('m') < 7 ? '1':' 2';

if (!isset($_SESSION['username'])){?>

    <script xmlns="http://www.w3.org/1999/html">
        window.location="../index.php";
    </script>

<?php }?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pautas Online</title>
        <meta name="keywords" content="" />
		<meta name="description" content="" />
<!--
-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap core CSS -->

        <?php require '../view/layouts/_header.html' ?>

        <script src="fragments/js/js_function.js" type="text/javascript"></script>
        <script src="fragments/js/js_estudante.js" type="text/javascript"></script>
        <script src="fragments/js/js_plano_avaliacao.js" type="text/javascript"></script>
        <script src="fragments/js/js_registo_academico.js" type="text/javascript"></script>


        <style>

            #templatemo-nav-bar{
                margin-bottom: 1em;
                margin-top: -1em;
            }
             ul li{cursor: pointer;color:white}
             ul li:hover{ background:#ccc; color:white}
        </style>

    </head>
    <body>

        <div class="templatemo-top-bar" id="templatemo-top" style="margin-top: -1.5em;">
            <div class="container">
                <div class="subheader" >

            <div class="navbar navbar-default" role="navigation" style="background: none;">
                <div class="container">

                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>

                        </button>
                    </div>

                    <div class="menu-logo" style="">
                        <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="/">
                        <img src="fragments/img/lurio-logo.png" alt="Unilurio Fe" title="" style="height: 5rem;">
                    </a>
                </span>
                            <span class="navbar-caption-wrap">
                                <a class="navbar-caption text-danger display-5" href="#">
                                    SIGEPAUTAS</a>
                            </span>

                        </div>
                    </div><br>

                    <?php if ($_SESSION['tipo'] == 'docente') {?>
<!--                        <span style="margin-left: -1em;font-size:18px;cursor:pointer;">SISTEMA DE PAUTAS / DOCENTE</span>-->

                    <div class="navbar-collapse collapse" id="templatemo-nav-bar">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="/" target="frm_content">HOME</a></li>
                            <li ><a href="pauta/pautas.php" target="frm_content">REGISTO DE PAUTA</a></li>
<!--                            <li value=""><a href="configAdmin/pauta.php" target="frm_content">Gestão de Pautas</a></li>-->
<!--                            <li value="avfrq"><a href="../view/Plano_avaliacao.php" target="frm_content">Plano de Avaliação</a></li>-->
                            <li value="plano_av"><a href="report/Form_reports.php?acao=10" target="frm_content">RELATORIOS DE PAUTAS</a></li>
                            <li><a href="plano_avaliacao/Plano_avaliacao.php" target="frm_content">PLANO DE AVALIAÇÃO</a></li>
                            <li><a href="classes/logout.php"><span class="glyphicon glyphicon-log-out"></span> SAIR</a></li>

                        </ul>
                    </div> <!--/.nav-collapse docente -->




                    <?php } elseif ($_SESSION['tipo'] == 'estudante'){?>

<!--                    <span style="margin-left: -1em;font-size:18px;cursor:pointer;">SISTEMA DE PAUTAS /ESTUDANTE</span>-->

                    <div class="navbar-collapse collapse" id="templatemo-nav-bar">
                    <ul class="nav navbar-nav navbar-right" style="margin-bottom: 2px">
                        <li class="active"><a href="../../www/index.php" target="frm_content">HOME</a></li>
                        <li ><a href="aluno/Estudante_pauta.php" target="frm_content">PAUTAS PUBLICADAS</a></li>
                        <li><a  href="aluno/Aluno.php" target="frm_content" >INSCRIÇÃO ESTUDANTE</a></li>
                        <li value="plano_av"><a href="plano_avaliacao/Plano_docente.php" target="frm_content" >PLANO DE AVALIAÇÃO</a></li>
                        <li><a href="aluno/Estudante_pauta.php" target="frm_content">NOTIFICAÇÕES</a></li>
<!--                        <li class="active"><a href="Estudante_pauta.php" target="frm_content">Preencricao</a></li>-->
                        <li><a href="classes/logout.php"><span class="glyphicon glyphicon-log-out"></span> SAIR</a></li>

                    </ul>
                    </div><!--/.nav-collapse Estudante-->

                <?php } elseif ($_SESSION['tipo'] == 'dir_adjunto_pedag' || $_SESSION['tipo'] == 'coordenador' || $_SESSION['tipo'] == 'director'){?>

<!--                <span style="font-size:16px;cursor:pointer;margin-left: -1em">SISTEMA DE PAUTAS /DIRECTOR ADJUNTO PEDAGOGICO</span>-->
                    <div class="navbar-collapse collapse" id="templatemo-nav-bar">

                    <ul class="nav navbar-nav navbar-right" style="margin-top: 5px">
                        <li class="active"><a href="/" target="frm_content">HOME</a></li>
                        <li ><a href="pedagogico/Direcao.php" target="frm_content">PUBLICAÇÃO DE PAUTAS</a></li>
                        <li value=""><a href="pauta/pautas.php" target="frm_content">PAUTAS DOCENTE</a></li>
                        <li value="plano_av"><a href="report/Form_reports.php?acao=10" target="frm_content">RELATORIOS DE PAUTAS</a></li>

                        <li class="dropdown" id="">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false" >
                                <i class=""></i> <?php echo 'GESTÃO PEDAGOGICA';?> <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li><a href="plano_avaliacao/Plano_avaliacao.php" target="frm_content" >PLANO DE AVALIAÇÃO</a></li>
                                <li><a href="avaliacao/avaliacao.php" target="frm_content">MENU AVALIAÇÃO</a></li>
                                <li><a href="actividade/activity_session.php" target="frm_content">CALENDARIO DE ACTIVIDADES</a></li>
                                <li><a href="professor/professor.php" target="frm_content" >GERIR DOCENTES <i class="pull-right glyphicon glyphicon-people"></i></a></li>
                                <li id="manageStudentNav"><a href="curso/cursos.php" target="frm_content">CURSOS E TURMAS <i class="pull-right glyphicon glyphicon-eye"></i></a></li>
                                <li id="manageStudentNav"><a href="disciplina/disciplinas.php" target="frm_content">MENU DISCIPLINAS <i class="pull-right glyphicon glyphicon-send"></i></a></li>
                                <li><a id="users"  href="utilizador/usuarios.php" target="frm_content" >UTILIZADORES DO SISTEMA <i class="pull-right glyphicon glyphicon-users"></i></a></li>
                                <li><a href="instituicao/perfil.php" target="frm_content">PERFIL INSTITUIÇÃO</a></li>
                            </ul>
                        </li>

                        <li><a href="classes/logout.php"><span class="glyphicon glyphicon-log-out"></span> SAIR</a></li>

                    </ul>

                        <div class=""></div>

                        <?php } elseif ($_SESSION['tipo'] == 'racademico'){ ?>
                    </div> <!--/.container-fluid coordenador-->

<!--                    <span style="font-size:18px;cursor:pointer;margin-left: -1em">SISTEMA DE PAUTAS /REGISTO ACADEMICO</span>-->

                    <div class="navbar-collapse collapse" id="templatemo-nav-bar">
                        <ul class="nav navbar-nav navbar-right" style="margin-top: 5px">
                            <li class="active"><a href="../view/registo_academico/Gestao_Academica.php" target="frm_content">HOME</a></li>
                            <li ><a href="registo_academico/Registo_Academico.php" target="frm_content">ADMINISTRAR PAUTAS</a></li>

                            <li class="dropdown" id="">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false" >
                                    <i class=""></i> <?php echo 'GESTÃO ACADEMICA';?> <span class="caret"></span></a>

                                <ul class="dropdown-menu">

                                    <li id="addStudentNav"><a href="aluno/alunos_all.php?acao=master" target="frm_content">GERIR ESTUDANTES  <i class="pull-right glyphicon glyphicon-user"></i></a></li>
                                    <li><a  href="exames/exame_extraordinario.php" target="frm_content" >PEDIDOS DE EXAMES</a></li>
                                    <li><a  href="aluno/inscricao_matricula.php" target="frm_content">MATRICULAS E INSCRICOES</a></li>


                                </ul>
                            </li>


                            <li class="dropdown" id="">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false" >
                                    <i class=""></i> <?php echo 'GESTÃO PEDAGOGICA';?> <span class="caret"></span></a>

                                <ul class="dropdown-menu">

                                    <li><a href="professor/professor.php"target="frm_content" >GERIR DOCENTES <i class="pull-right glyphicon glyphicon-people"></i></a></li>
                                    <li id="manageStudentNav"><a href="curso/cursos.php" target="frm_content">CURSOS E TURMAS <i class="pull-right glyphicon glyphicon-eye"></i></a></li>
                                    <li id="manageStudentNav"><a href="disciplina/disciplinas.php" target="frm_content">GERIR DISCIPLINAS <i class="pull-right glyphicon glyphicon-send"></i></a></li>
                                    <li id="manageStudentNav"><a href="integracao/integracao.php" target="frm_content">INTEGRAÇÃO DE DADOS 1</a></li>
                                    <li value=""><a href="pauta/pautas.php" target="frm_content">PAUTAS DOCENTE</a></li>
                                    <li><a href="plano_avaliacao/Plano_avaliacao.php" target="frm_content">PLANO DE AVALIAÇÃO</a></li>

                                </ul>

                            </li>

                            

<!--                            <li class="dropdown" id="">-->
<!--                                <a  href="#" class="dropdown-toggle" data-toggle="dropdown"-->
<!--                                    role="button" aria-haspopup="true" aria-expanded="false">-->
<!--                                    <i class=""></i>--><?php //echo 'Contabilidade'; ?><!--<span class="caret"></span></a>-->
<!---->
<!--                                <ul class="dropdown-menu">-->
<!---->
<!--                                    <li><a href="configAdmin/payments_session.php" target="frm_content">Criar Sessões de Pagamento</a></li>-->
<!--                                    <li><a href="configAdmin/facturas.php" target="frm_content">Gerir Pagamentos Alunos</a></li>-->
<!--                                    <li><a href="configAdmin/despesas.php" target="frm_content">Gerir Despesas e Orçamentos</a></li>-->
<!--                                    <li><a href="../reports/barGraphic.php" target="frm_content">Relatórios Financeiros</a></li>-->
<!---->
<!--                                    <span class=""></span>-->
<!--                                </ul>-->
<!--                            </li>-->

                            <li><a id="users"  href="utilizador/usuarios.php" target="frm_content" >UTILIZADORES  <i class="pull-right glyphicon glyphicon-users"></i></a></li>

                            <li><a href="classes/logout.php"><span class="glyphicon glyphicon-log-out"></span> SAIR</a></li>
                        </ul>
                        <?php } ?>
                    </div> <!--/.container-fluid coordenador-->
                </div> <!--/.navbar contaniner -->
                </div>  <!--/.navbar bar default -->
                </div>  <!--/.sub header -->
                </div>  <!--/. contaniner 1 main -->
            </div>  <!--/. tamplate top bar -->

        <div class="container" style="color: #008000;font-weight: bold"><span class="glyphicon glyphicon-user"></span><?php echo " ". utf8_decode($_SESSION['username']) ?> / <span><?php echo strtoupper( $_SESSION['tipo']);?></span></div>
        <div class="templatemo-service">
            <div class="containergf">
                <?php

                if ($_SESSION['tipo'] == 'docente'){
                    $page_init = 'pauta/pautas.php';

                } elseif ($_SESSION['tipo'] == 'estudante'){
                    $page_init = 'aluno/Aluno.php';

                }elseif ($_SESSION['tipo'] == 'coordenador' || $_SESSION['tipo'] == 'dir_adjunto_pedag' || $_SESSION['tipo'] == 'director'){
                    $page_init = 'pedagogico/Direcao.php';
                }
                elseif ($_SESSION['tipo'] == 'racademico'){
                    $page_init = 'registo_academico/Gestao_Academica.php';
                }
                ?>
                <iframe src="<?php echo $page_init ?>" width="100%" height="1000" name="frm_content" frameborder="0"></iframe>
            </div>
        </div>

        <!--- Pesquisar Planos de outros Docentes das Disciplinas -->
        <!-- container -->

        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="md_relatorios" role="dialog">

                <div class="modal-dialog modal-sm">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header alert alert-warning" style="padding:25px 40px; text-align: left">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4><span class="glyphicon glyphicon-search"></span>&nbsp;Pesquisar planos de avaliação</h4>
                        </div>

                        <div class="modal-body" style="padding:20px 30px;">
                           <?php if ($_SESSION['tipo'] == 'estudante') {?>
                               <div class="alert alert-success"> Disciplinas associadas ao Estudante - <?php echo utf8_encode($_SESSION['nomeC']) ?> </div>
                               <label>Seleccionar:</label>
                               <ul class="list-group ul_li_item" id="rs_docente_disciplinas">

                                   <?php
                                   $idAluno= $estudante_sql->getIdEstudante($_SESSION['username'], 1);
                                   //echo $idAluno;
                                   $vetor =  $estudante_sql->estudanteDisciplina($idAluno, "", 0,$semestre,$ano);
                                   foreach($vetor as $row){
                                       if ($row!=null){?>

                                           <li style="color: #0000CC" class="list-group-item" value="<?php echo $row['idDisciplina']?>"
                                               onclick="mostrar_plano_avaliacao(this.value,<?php echo $semis?>,<?php echo $ano?>,0)">
                                               <?php echo $row['descricao']?>  <span class="glyphicon glyphicon-chevron-right pull-right"></span></li>
                                       <?php } }?>
                               </ul>
                               <?php }else {?>

                            <div class="pesquisar_planos" >

                                <div class="row">

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="search_doc" onkeyup="pl_avaliacao_doc_nome(this.value)"
                                               placeholder="Buscar docente ... nome" id="search_doc" value=""/>
                                        <ul class="list-group ul_li_item" id="rs_docente" style="color: #0000CC"></ul>

                                    </div>

                                    <div class="col-md-6">

                                            <select class="form-control" id="ano_academico" style="width: 200px">
                                                <option selected>-- ANO --</option>

                                                <?php for ($i  = date('Y'); $i> 2010; $i--){ ?>
                                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php } ?>
                                                <option>...</option>
                                            </select>
                                    </div>
                                </div>
                                <br>

                                <div class="">
                                    <button class="btn btn-default" id="btn_buscar_disciplias">Listar Disciplinas</button>

                                </div>

                            </div>

                               <span class="mostrar_doc"></span>

                            <ul class="list-group ul_li_item" id="rs_docente_disciplinas"></ul>

                            <?php } ?>


                            <div class="visualizar_pl">
                                <label>Detalhes do Plano</label>
                                <table  id="table-custom-2" data-mode="color"
                                        class="table table-responsive">
                                     
                                    <thead>
                                          <tr class="ui-bar-b"  id="div-bar"
                                              style="background: #D8D8D8;border: none; color: #151515; font-size: 12px">
                                        <th>ID</th> 
                                        <th >Disciplina</th>
                                                <th >Tipo de Avaliação</th>
                                                <th >Peso</th>
                                        <th>Operações</th>
                                              </tr>
                                    </thead>
                                        <tbody id="tbl_dados" style="font-size: 11px;"> </tbody>
                                      </table>

                        </div> <!---- Table show plano-->


                            <div class="visualizar_pl">

                                <label>Datas de Avaliação</label>
                                <table  id="table-custom-2" data-mode="color"
                                        class="table table-responsive">
                                     
                                    <thead>
                                          <tr class="ui-bar-b"  id="div-bar"
                                              style="background: #D8D8D8;border: none; color: #151515; font-size: 12px">
                                        <th>ID</th>
                                        <th>Tipo de Avaliação</th>
                                        <th>Data de Realização</th>
                                         <th>Status</th>
                                        <th>Operações</th>
                                              </tr>
                                    </thead>
                                        <tbody id="table_pl" style="font-size: 11px;"> </tbody>
                                      </table>

                            </div> <!---- Table show plano-->

                            </div>

                        <div class="modal-footer">
                            <?php
                            if ($_SESSION['tipo'] == 'docente' || $_SESSION['tipo'] == 'coordenador') {?>

                                <a href="plano_avaliacao/Plano_avaliacao.php" target="frm_content" class="btn btn-primary">Novo Plano</a>
                            <?php }else {?>
                                <!--a href="#" class="btn btn-primary mb-2">Comentar</a-->
                            <?php }?>
                        </div>

            </div>
        </div>

            </div> <!-- container--->
         </div>

            <!---------------------------------------------------------------------------------------------->



    </body>
  </html>

  <script type="text/javascript">

    $('#rs_docente_disciplinas li').click(function(){
        $('li.current ').removeClass('current').css({'background':'white', 'color':'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li ').css({'background':'#E6E8FA', 'color':'blue'});
    });

  </script>

