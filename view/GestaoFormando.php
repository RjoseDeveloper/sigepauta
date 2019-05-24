<?php

session_start();
if (!isset($_SESSION['username'])){?>

    <script>
        window.location="../index.php";
    </script>

<?php }else{

    require_once('../functions/db.php');
    require_once('../functions/conexion.php');
    require '../QuerySql/Classes.php';
    //require '../functions/Conexao.php';
    require '../QuerySql/EstudantesSQL.php';

    $semestre = date('m') < 7 ? '1º':' 2º';
    $ano = date('Y');
    $classes = new Classes();
    $db = new mySQLConnection();
    $estudante_sql = new EstudantesSQL();
} ?>


<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type, refresh" content="text/html; charset=utf-8">
    <title>Registo Academico</title>
    <style>

        ul li {cursor: pointer}
        h5{background: none; }

        ul .lista_disciplinas{
            border-top: 1px solid #c6c6c6;
            padding: 8px;
        }

        li{list-style: none;  padding: -2em;}
        .doc_ul_a{ cursor: pointer;}

        .form-control{
            margin-top: 5px;
        }

    </style>

<?php
    include '../view/layouts/_header.html'
?>


    <style>
    /**
        my stile sheet
    */

    .jumbotron  input, select, label, textarea, a, button{
    }
    .texto{
        color:green;
    }

</style>
</head>
<body>

    <div class="container">
    <!--h4 style="color:#00516e" class="info_cadastro">Formulario de Cadastro - Formando, Cursos e Periodos</h4-->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">DADOS GERAIS</a></li>
            <li><a data-toggle="tab" href="#menu1">INSCRIÇÃO - DISCIPLINA</a></li>
            <?php
                if ($_SESSION['tipo']!="estudante"){ ?>
<!--            <li><a data-toggle="tab" href="#menu2">CONSULTAS REGULARES</a></li>-->

            <?php }?>
        </ul>




    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
                <br><br>
                <div class="container col-sm-12">
                    <?php

                    $user =$_SESSION['username'];

                    $query = "SELECT aluno.idaluno as number_row from aluno
                    INNER JOIN utilizador ON utilizador.id = aluno.idutilizador
                    WHERE utilizador.username='$user'";

                    $qs= mysqli_query($con, $query);
                    $count = mysqli_num_rows($qs);

                   if ($count == 0){  require'../QuerySql/PessoaSQL.php'; ?>

                    <form action="../controller/FormandoCtr.php?acao=2" method="post">
                    <div style=" padding: 8px 30px;border-radius: 5px" class="col-sm-6">
                        <h4 style="color:green" class="alert alert-info">Identificação</h4>

                        <?php

                        if($_SESSION['tipo']!='estudante'){ ?>

                                <label for="pesquisar">Buscar Utilizador:  &nbsp;</label>
                                <input type="search" onkeyup="pesquisar(this.value,5)" id="auto_encarregado" class="form-control" autocomplete="off">
                                <ul class="list-group list_view_encarregado"></ul>
                                    <input type="hidden" name="campo_utilizador" id="campo_utilizador" value=""/>

                                <input type="hidden" name="campo_utilizador" id="campo_utilizador" value="<?php echo $_REQUEST['acao'];?>"/>

                                <?php }else{ ?>

                            <input type="hidden" name="campo_utilizador" id="campo_utilizador" value="<?php echo $_SESSION['id'];?>"/>

                        <?php }?>

                            <label for="apelido">Apelido:</label><input type="text" id="apelido" required name="apelido" value="" class="form-control"/>
                            <label for="name">Nome:</label><input type="text" id="nome" name="nome" value="" class="form-control" required/>
                            <label for="bi_recibo">BI/Recibo/Passaporte:</label>
                        <input type="text" id="bi_recibo" name="bi_recibo" value="" class="form-control" required/>

                        <label for="estadocivil">Estado Civil:</label>
                        <select class="form-control" data-style="btn-primary" data-width="auto" id="estadocivil" name="estadocivil">
                            <option value="0" desabled="desabled">Selecionar Estado Civil</option>
                            <?php

                            $resut = mysqli_query($con,'SELECT * FROM estado_civil');
                            while ($row = mysqli_fetch_assoc($resut)){ ?>
                                <option value="<?php echo $row['idestadocivil'] ?>"><?php echo $row['descricao']?></option>

                            <?php }  ?>

                        </select>

<!--                            <label for="data_nascimento">Data de Nacimento:</label>-->
<!--                            <input type="date" id="data_nascimento" name="data_nascimento" value="" class="form-control" required/>-->
<!---->
<!--                            <label for="nivelescolar">Nivel Escolar:</label>-->
<!--                            <select class="form-control" data-style="btn-primary" data-width="auto" id="nivelescolar" name="nivelescolar">-->
<!--                                <option value="0" desabled="desabled">Selecionar nivel escolar</option>-->
<!--                                --><?php
//                                $resut = mysqli_query($con,'SELECT * FROM nivelescolar');
//                                while ($row = mysqli_fetch_assoc($resut)){ ?>
<!--                                    <option value="--><?php //echo $row['idnivel'] ?><!--">--><?php //echo utf8_encode($row['descricao']) ?><!--</option>-->
<!--                                --><?php //}  ?>
<!--                            </select>-->

                        </div> <!-- fim primeiro bloco---->

                    <div style=" padding: 8px 30px;border-radius: 5px" class="col-sm-6 pull-right">

                        <h4 style="color:green" class="alert alert-info">Endereço e Informações Medicas</h4>
                        <!------ Novo Estudante --------->

                        <div class="regista_aluno">

                            <label for="endereco">Morada:</label>

                            <select class="form-control" data-style="btn-primary" data-width="auto" id="endereco" name="endereco" required>

                                <option value="0" desabled="desabled">Selecionar o bairro</option>
                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM endereco');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idendereco'] ?>"><?php echo $row['bairro']?></option>
                                <?php }  ?>
                            </select>

                            <label for="provincia">Provincia de Nascimento: </label>

                            <select class="form-control" onchange="buscar_distrito(this.value)" data-style="btn-primary"
                                    data-width="auto" id="provincia" name="provincia">
                                <option value="0" desabled="desabled">Selecionar a Provincia</option>

                                <?php
                                $resut = mysqli_query($con,'SELECT * FROM provincia ORDER BY descricao ASC ');
                                while ($row = mysqli_fetch_assoc($resut)){ ?>
                                    <option value="<?php echo $row['idprovincia'] ?>"><?php echo $row['descricao']?></option>
                                <?php } ?>

                            </select>

                            <label for="distrito">Distrito:</label>
                            <select class="form-control first_select" data-style="btn-primary" data-width="auto" id="distrito" name="distrito">
                            </select>
                            <div class="lista_distritos"></div>

                            <h3 class="sucesso_reg_est" style="color:blue" align="right"></h3>
                            <label for="provincia">Sofre Alguma Doença?:</label>

                            <input type="text" class="form-control"  name="doenca" value="" id="doenca" placeholder="Indique o Nome da Doença"/>
<!--                            <label for="notas">Orientações Medicas *:</label>-->
<!--                            <textarea class="form-control" id="notas" name="notas"></textarea>-->
<!---->
<!--                            <label for="notas">Possui Alergia*:</label>-->
<!--                            <input type="text" class="form-control"  name="alergia" value="" id="alergia" placeholder="Registar o tipo de alergia a Alimentos"/>-->

                            <br>
                            <div class="pull-right">
                            <button class="btn btn-primary" id="salvar_est">Registar Operação</button>

                            </div>

                        </div>
                    </div>

                    </form>

                    <?php }else{?>

                    <h4>INFORMAÇÕES DE ESTUDANTE</h4><hr>
                    <?php include 'configAdmin/ajax/buscar_aluno.php';?>

                    <h4> DADOS DE INSCRIÇÃO</h4>
                       <select name="ano_academico" id="ano_academico" class="selectpicker" data-style="btn-primary" data-width="auto">

                           <option selected="selected">Seleccionar Ano</option>
                           <?php
                           for($i = $estudante_sql->obter_ano_ingresso($_SESSION['username']); $i< date('Y'); $i++){ ?>
                               <option value=""> <?php echo $i ?> </option>
                           <?php } ?>
                           <option value="">...</option>
                       </select>

                       <select id="select_semestre" class="selectpicker" data-style="btn-primary" data-width="auto">
                           <option value="" disabled="disabled" >Seleccionar Semestre</option>

                           <option  value="1">SEMESTRE 1</option>
                           <option  value="2">SEMESTRE 2</option>

                       </select>

                    <?php include 'configAdmin/ajax/disciplina_aluno.php'; }?>

            </div>
        </div> <!-- fim menu home-->

        <div id="menu1" class="tab-pane fade">
            <br>

            <div class="container col-sm-12">

                <form class="form-horizontal" method="post" id="guardar_inscricao" name="guardar_inscricao">

                    <div class="col-xs-12 msg_sucesso" style="background: #fff; padding: 8px;
                     color: #0000CC; font-size: 18px;"> ADICIONAR DISCIPLINAS DO SEMESTRE </div>

                    <div class="col-xs-6 pull-left">

                    <?php
                        if ($_SESSION['tipo'] != 'estudante'){
                    ?>

                    <label for="user">Seleccionar Aluno:</label>

                    <select class="form-control" data-style="btn-primary"
                            data-width="auto" id="user" name="user" required="">
                        <?php
                        $resut = mysqli_query($con,'SELECT * FROM utilizador INNER JOIN previlegio
                                                    on previlegio.idprevilegio = utilizador.idprevilegio
                                                    AND previlegio.tipo="estudante"');
                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                            <option value="<?php echo $row['id'] ?>">
                                <?php echo utf8_encode($row['nomeCompleto']) ?></option>
                        <?php }  ?>
                    </select>

                    <?php }else{?>

                    <input name="user" id="user" value="<?php echo $_SESSION['id'] ?>" type="hidden"/>
                    <?php }?>

                    <label for="curso">Curso:</label>

                    <select class="form-control" data-style="btn-primary" onchange="lista_turmas(this.value)"
                            data-width="auto" id="curso" name="curso" required="">
                        <option value="0">--Seleccionar Curso--</option>
                        <?php
                        $resut = mysqli_query($con,"select * from curso");

                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                            <option value="<?php echo $row['idcurso'] ?>">
                                <?php echo utf8_encode($row['descricao']) ?></option>
                        <?php }  ?>

                    </select>

                        <div class="list_turma"> </div>

                </div>

                <div class="col-xs-6 pull-right">

                    <label for="turno">Turno:</label>
                    <select class="form-control"  data-style="btn-primary"
                            data-width="auto" id="turno" name="turno" required="">
                        <?php
                        $resut = mysqli_query($con,'SELECT * FROM turno');
                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                            <option value="<?php echo $row['idturno'] ?>">
                                <?php echo utf8_encode($row['descricao']) ?></option>
                        <?php }  ?>
                    </select>

                    <label for="regime">Regime:</label>
                    <select class="form-control"  data-style="btn-primary"
                            data-width="auto" id="regime" name="regime" required="">
                        <?php
                        $resut = mysqli_query($con,'SELECT * FROM regime');
                        while ($row = mysqli_fetch_assoc($resut)){ ?>
                            <option value="<?php echo $row['idregime'] ?>">
                                <?php echo utf8_encode($row['descricao']) ?></option>
                        <?php }  ?>
                    </select>

                    <br>

                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" id="btn_inscricaov">
                            <span class="glyphicon glyphicon-chevron-right" title="Cadastrar"> Registar Operação</button>

<!--                        <a href="#" class="btn btn-success" id="btn_print" onclick="imprimir_ficha()">-->
<!--                            <span class="glyphicon glyphicon-print" title="Imprimir"></span></a>-->
                    </div>
                </div>
                </form>

            </div>
        </div> <!-- fim menu 1--->

        <div id="menu2" class="tab-pane fade">
            <div class="container">
                <br><br>
                <form class="form-inline"></form>
                <form class="form-inline">
                <div class="form-group">
                    <label for="curso_ins">Seleccionar o Curso:</label> <br>

                    <select class="form-control col-lg-2"  onchange="buscar_periodos(this.value,1);"
                            data-style="btn-primary" data-width="auto" id="curso_id" name="curso_id">
                        <?php
                        $t =0;
                        $resut = mysqli_query($con,'SELECT * FROM curso');
                        while ($row = mysqli_fetch_assoc($resut)){
                            if ($t==0){
                                echo '<option value="'. $row['idcurso'].'">-- Selecionar um curso --</option>';
                                $t++;
                            }
                            ?>
                            <option value="<?php echo $row['idcurso'] ?>"><?php echo utf8_encode($row['descricao']) ?></option>
                        <?php }  ?>
                    </select>
                </div>

                <input type="hidden" value="" id="c_curso" name="c_curso"/>

                <div class="form-group select_pesquisa">
                    <label for="periodo">Buscar/ Turma:</label><br>
                    <select class="form-control"  data-style="btn-primary" data-width="auto"
                            id="periodo_pesq" name="periodo_pesq" onchange="table_frm_periodos(this.value)">
                        <option value="0">Selecionar o Periodo:</option>

                        <?php

                        $resut = mysqli_query($con,'SELECT * FROM disciplina WHERE turma.idcurso=1');
                        while ($row = mysqli_fetch_assoc($resut)){
                            ?>
                            <option value="<?php echo $row['idturma'] ?>"><?php echo utf8_encode($row['descricao']).''; ?></option>
                        <?php }  ?>

                    </select>
                </div>
                    <div class="form-group  periodos_pesquisa"></div>
            </form>

            <br><br>
                <div class="table-responsive tbl_alunos"> </div>
            </div>
            </div>
        </div><!--- fim menu 2--->

        <?php
        include("configAdmin/modal/form_clientes.php");
        include("configAdmin/modal/form_encarregado.php");
        include("configAdmin/modal/list_encarregado.php");

        ?>

        </div> <!--- fim tabs contant -->

     </body>
</html>

<script type="text/javascript" src="../js/js_estudante.js"></script>

<script type="text/javascript">

    $(document).ready(function(){

        var curso = $('select#curso_id').val();

        load_table_matricula(curso,0,0,8,3,0);
        $( "#guardar_inscricao" ).submit(function( event ) {
            // $('#btn_inscricaov').attr("disabled", true);
            var parametros = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "../controller/FormandoCtr.php?acao=4",
                data: parametros,
                beforeSend: function(objeto){
                    $(".msg_sucesso").html("Mensagem: Carregando...");
                },
                success: function(datos){
                    $(".msg_sucesso").html(datos);
                    //$('#btn_inscricaov').attr("disabled", false);
                }
            });
            event.preventDefault();
        })

        $('.active_btn').click(function(){
            $('#btn_inscricaov').attr("disabled", false);
        });
    });

    function desable_exame_especial(aluno, inscricao){
        //alert(inscricao);
        $cont=2;
        $.ajax({
            type: "POST",
            url: "../controller/FormandoCtr.php?acao=15&idaluno=" +aluno + '&idinsc='+inscricao + '&controlo='+ $cont,
            data: "idaluno"+aluno,"idinsc":inscricao, "controlo":$cont,
            beforeSend: function(objeto){
                $(".msg_sucesso").html("Mensagem: Carregando...");
            },
            success: function(datos){
                $(".msg_sucesso").html(datos);
            }
        });
        event.preventDefault();
    }


    function enable_inscricao(){

                $('#guardar_inscricao').show();
                $('.tbl_disciplina').hide();

    }

        function get_item_val(item){
            $('#campo_frm').val(item);
        }


        function listar_Encarregado(id){

            $(this).css('background','red');

            $.ajax({
                url:"../controller/FormandoCtr.php",
                data:{id:id, acao:14},
                success:function(data){
                    $('.list_encarregado').html(data)
                }
            });

        }

        function obtener_datos(id){

            var nombre_cliente = $("#nombre_cliente"+id).val();
            var telefono_cliente = $("#telefono_cliente"+id).val();
            var email_cliente = $("#email_cliente"+id).val();
            var direccion_cliente = $("#direccion_cliente"+id).val();
            var status_cliente = $("#status_cliente"+id).val();

            $("#mod_nombre").val(nombre_cliente);
            $("#mod_telefono").val(telefono_cliente);
            $("#mod_email").val(email_cliente);
            $("#mod_direccion").val(direccion_cliente);
            $("#mod_estado").val(status_cliente);
            $("#mod_id").val(id);

        }

        function eliminar (id)
        {

            var q= $("#q").val();
            if (confirm("Realmente desejas eliminar este aluno")){
                $.ajax({
                    type: "GET",
                    url: "./ajax/buscar_clientes.php",
                    data: "id="+id,"q":q,
                    beforeSend: function(objeto){
                        $("#resultados").html("Mensagem: Carregando...");
                    },
                    success: function(datos){
                        $("#resultados").html(datos);
                        load(1);
                    }
                });
            }
        }


        function desable_exame_especial(aluno, disp){
            alert(disp+" "+aluno)

        }

        function enable_exame_especial(aluno, inscricao){
            //alert(inscricao);
            $cont=1;
            $.ajax({
                type: "POST",
                url: '../controller/FormandoCtr.php?acao=15&idaluno=' +aluno + '&idinsc='+inscricao + '&controlo=' + $cont,
                data: "idaluno"+aluno,"idinsc":inscricao, "controlo":$cont,
                beforeSend: function(objeto){
                    $(".msg_sucesso").html("Mensagem: Carregando...");
                },
                success: function(datos){
                    $(".msg_sucesso").html(datos);
                }
            });
            event.preventDefault();
        }

</script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        