<?php
/*-------------------------
Autor: rjose
---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: index.php");
    exit;
}

/* Connect To Database*/
require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Software| Pautas";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.php");?>
</head>
<body>

<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="btn-group pull-right">

                <button type='button' class="btn btn-default" data-toggle="modal" data-backdrop="false" data-target="#myModal">
                    <span class="glyphicon glyphicon-plus" ></span> Adiccionar</button>
            </div>

            <h4><span class="glyphicon glyphicon-bookmark"></span>Avaliacao</h4>
        </div>
        <div class="panel-body">
            <?php
            include("form_avaliacao.php");
            //            include("view/configAdmin/modal/editar_avaliacao.php");

            ?>
            <form class="form-horizontal" role="form" id="datos_cotizacion">

                <div class="form-group row">
                    <label for="q" class="col-md-2 control-label">Nome:</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="q" placeholder="Nome" onkeyup='load(1);'>
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-default" onclick='load(1);'>
                            <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                        <span id="loader"></span>
                    </div>

                </div>
            </form>
            <div id="resultados"></div><!-- Carga los datos ajax -->
            <div class='outer_div'></div><!-- Carga los datos ajax -->

        </div>
    </div>

</div>
<hr>
<?php
include("../layouts/footer.php");
?>
<script type="text/javascript" src="../fragments/js/avaliacao.js"></script>


</body>
</html>
<script>

    $("#guardar_avaliacao" ).submit(function( event ) {
        $('#guardar_datos').attr("disabled", true);

        var parametros = $(this).serialize();

        //alert(parametros);

        $.ajax({
            type: "POST",
            url: "../avaliacao/nova_avaliacao.php",
            data: parametros,
            beforeSend: function(objeto){
                $("#resultados_ajax").html("Mensagem: Carregando...");
            },
            success: function(datos){
                $("#resultados_ajax").html(datos);
                $('#guardar_datos').attr("disabled", false);
                load(1);
            }
        });
        event.preventDefault();
    });




    $('#disciplina').change(function(){
        $('#associar_disciplinas').attr("disabled", true);
    })




    function get_user_id(id){
        $("#user_id_mod").val(id);
    }

    function obtener_datos(id){
        var descricao = $("#descricao"+id).val();
        var estado = $("#estado"+id).val();



        $("#tipo_av").val(id);
        $("#descricao").val(descricao);
        $("#estado").val(estado);


    }

    function enable(){

        $('#associar_disciplinas').attr("disabled", false);
    }

    function buscar_turma(item){

        $('.static_turma').html('');

        $.ajax({
            url:"../../requestCtr/Processa_docente.php",
            type:'POST',
            data:{curso:item, acao:12},
            success:function(data){
                $('.dinamic_turma').html(data)
            }
        });
    }
</script>