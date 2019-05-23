<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">
    <title>Registar Nota</title>

    <style type="text/css">

        li{list-style: none;  padding: -2em;}
        .doc_ul_a{ cursor: pointer;}
        .form-control{margin-top: 5px;}

    </style>

</head>
<body>

<div class="container">
    <div class="jumbotron">
        <!--------   Mmostra lista de disciplina de um docente ----------------->

                <div class="col-sm-12 disciplina">

                    <form class="form-horizontal" method="post" id="guardar_disciplina" name="guardar_disciplina">
                    <input type="text" required="" name="descricao" class="form-control" value="" id="descricao" placeholder="Descrição da Disciplina"/>
                    <input type="text" required="" name="credito" class="form-control" value="" id="credito" placeholder="Creditos"/>

                        <div class="row">

                            <div class="col-md-4">
                                <select name="natureza" id="natureza" class="form-control" required="">

                                    <option value="" data-theme="a" desable="desable"> -- Regime -- </option> 
                                    <option value="Integral"> Integral </option>
                                    <option value="Modular"> Modular </option>
                                    <option value="Laboratorio"> Laboratorio </option>
                                    <option value="Pesquisa de Campo">Pesquisa de Campo</option>
                                     
                                </select>
                            </div>

                            <div class="col-md-4">

                                <select name="ano" id="ano" class="form-control" required="">
                                    <option value="" data-theme="a" desable="desable"> -- Ano Académico -- </option>

                                    <?php

                                    $rs = mysqli_query($con, 'SELECT * FROM anolectivo');
                                    while ($row = mysqli_fetch_assoc($rs)){?>
                                        <option value="<?php echo $row['idano'] ?>"> <?php echo utf8_encode($row['nivel'])?> </option>
                                    <?php } ?>
                                     
                                </select>

                            </div>

                            <div class="col-md-4">

                                <select name="curso" id="curso" class="form-control" required="">
                                    <option value="" data-theme="a" desable="desable"> -- Curso -- </option>

                                    <?php

                                    $rs = mysqli_query($con, 'SELECT * FROM curso');
                                    while ($row = mysqli_fetch_assoc($rs)){?>
                                        <option value="<?php echo $row['idcurso'] ?>"> <?php echo utf8_encode($row['descricao'])?> </option>
                                    <?php  }?>
                                     
                                </select>

                            </div>

                        </div>


                    <div class="pull-right">
                      
                    <button type="submit" class="btn btn-primary" data-theme="b" data-mini="true" data-inline="true"
                            style="font-size:12px;
                 margin-right: -.1em;background:#4682B4; border:none; padding: 10px 50px"  class="guardar_datos" id="guardar_datos">Registar Operação</button>
                        </div>
                        <br>

                    </form>
                </div> <!-- fim div class sm-7 tamanho de textos-->

</div>

<script src="header/js/js_script.js"  type="text/javascript"></script>
<script src="header/js/jquery.min.js" type="text/javascript"></script>


<!---------------------------- FIM POPUPS  E COMEC SESSAO DE PANEL------------------------------->

</body>

<script>

    $( "#guardar_disciplina" ).submit(function( event ) {
        $('#guardar_datos').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "../view/configAdmin/ajax/nova_disciplina.php",
            data: parametros,
            beforeSend: function(objeto){
                $("#resultados").html("Inserido Com sucesso...").fadeOut('120000');
            },
            success: function(datos){
                alert(datos);
                $("#resultados").html(datos);
                $('#guardar_datos').attr("disabled", false);
            }
        });
        event.preventDefault();
    });

    $( "#editar_usuario" ).submit(function( event ) {
        $('#actualizar_datos2').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "ajax/editar_professor.php",
            data: parametros,
            beforeSend: function(objeto){
                $("#resultados_ajax2").html("Mensagem: Carregando...");
            },
            success: function(datos){
                $("#resultados_ajax2").html(datos);
                $('#actualizar_datos2').attr("disabled", false);
            }
        });
        event.preventDefault();
    })


    function obtener_datos(id){
        var nombres = $("#nombres"+id).val();
        var apellidos = $("#apellidos"+id).val();
        var usuario = $("#usuario"+id).val();
        var email = $("#email"+id).val();

        $("#mod_id").val(id);
        $("#firstname2").val(nombres);
        $("#lastname2").val(apellidos);
        $("#user_name2").val(usuario);
        $("#user_email2").val(email);

    }
</script>

</html>