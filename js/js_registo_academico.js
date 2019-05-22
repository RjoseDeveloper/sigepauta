/**
 * Created by rjose on 7/31/2016.
 */

$(document).ready(function() {

    /**
     * Componentes de incializacao
     */

    $(".assoc_docente").hide();
    $(".assoc_aluno").hide();
    $(".texto").html("Registar Novo Docente")
    $(".texto_e").html("Registar Novo Estudante")
    $('#rs_pesq_est').hide();
    $('.list_pauta_rec').hide();

    /*
     * Metodo onclick aplicado na linha da tabela de controlo das recorrencias
     * */

    $('.tr_all_rec tr').click(function(){
        alert("cliked me ....")
    });

    ///---------------------------------------

    $('.new_doc_ctr').click(function(){
        $('.assoc_docente').hide();
        $('.regista_docente').show("slow")
        $(".texto").html("Registar Novo Docente");

    });

    $(".assoc_doc_ctr").click(function(){
        $('.assoc_docente').show("slow");
        $('.regista_docente').hide()
        $(".texto").html("Associar Docente as disciplinas");
    });
    // Controladores do aluno

    $('.new_est_ctr').click(function(){
        $('.assoc_aluno').hide();
        $('.regista_aluno').show("slow")
        $(".texto_e").html("Registar Novo Estudante");
    });

    $(".assoc_est_ctr").click(function(){
        $('.assoc_aluno').show("slow");
        $('.regista_aluno').hide()
        $(".texto_e").html("Associar estudante as disciplinas");
    });
    /*-----------------------------------------------------*/

    $('.select_curso li').click(function() {

        $('.select_curso li.current').removeClass('current').css({'background':'white', 'color':'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li').css({'background':'rgba(230,235,255,255)', 'color':'blue'});
    });

    /*
     * Click no botao registar docente
     * */

    $('#salvar_doc').click(function() {

        var un = $('#txtemail_d').val();
        var pn = $('#txtsenha_d').val();
        var nomec = $('#txtnome_d').val();

        var desc= $('#select_categoria >  option:selected').html();
        var grau = $('select#select_grau').val();
        var sexo = $('#select-sexo').val();
        $('.sucesso_doc').show();

        $.ajax({

            url:"../requestCtr/Processa_registo_academico.php",
            data:{acao:3, ctg:desc, sexo:sexo, email:un,pass:pn},
            type:"POST",
            success:function(result){
                //$('.sucesso_doc').html(result); //.fadeOut(6000);

                $.ajax({

                    url:"../requestCtr/Processa_registo_academico.php",
                    data:{acao:4, fullname:nomec, email:un, grau:grau},
                    type:"POST",
                    success:function (result){
                        $('.sucesso_doc').html(result).fadeOut(6000);

                    }
                }) /// fim segunda requisicao ajax depois do sucesso da primeira;
            }
        }) // fim primeira requisicao ajax;*/
    });

    $('#assoc_docente').click(function(){

        $('.texto').html('Associar Docente a disciplina');
        $('.assoc_docente').show('slow');
        $('.regista_docente').hide();
        $('#salvar_assoc_doc').show();
        $('#salvar_doc').hide();

    });

    /*------------------------------Fim eventos da sessao docente --------------------------*

     * Eventos aplicado no campo de texto permite buscar o id de um docente registado atraves do email inserido
     * */

    $('#txt_dir').keyup(function() {

        var t = $(this).val();

        $('.mensagem').html($(this).val());

        if (t.length > 4){

            $.ajax({
                url:"../requestCtr/Processa_registo_academico.php",
                type:"POST",
                data:{texto:t, acao:2},
                success:function(result){
                    $('.mensagem').html(result).css('color','green');
                }
            });
        }
    });

    /***
     * Evento click no botao permite registra um novo curso
     * */

    $('.sv_curso').click(function() {

        var des = $('#txt_desc').val();
        var cgo = $('#txt_cod').val();
        var dir=  $('#txt_dir').val();
        var facul = $('#select_facul').val();
        $('.mensagem').show();

        //alert($('#txt_desc').val()+", "+$('#txt_cod').val()+', '+$('#txt_dir').val()+', '+$('#select_facul').val())

        $.ajax({

            url:"../requestCtr/Processa_registo_academico.php",
            type:"POST",
            data:{acao:1, descricao:des,codigo:cgo,facul:facul, director:dir},
            success:function(result){

                $('.mensagem').html(result).css('color', 'blue'); //.fadeOut(9000);
                $('.mensagem').show();
                $('#txt_desc').val("");
                $('#txt_cod').val("");
                $('#txt_dir').val("");
            }
        });
    });

    /**
     * Evento click no botao salvar disciplina
     * */

    $('.sv_disp').click(function() {

        var cred = $('#txt_cred').val();
        var codg = $('#txt_codigo').val();
        var desc=  $('#txt_desc_d').val();
        var nivel = $('#select_nivel').val();

        $('.mensagem_d').show();

        $.ajax({
            url:"../requestCtr/Processa_registo_academico.php",
            type:"POST",
            data:{acao:5, descricao:desc,codigo:codg,nivel:nivel, creditos:cred},
            success:function(result){

                $('.mensagem_d').html(result).css('color', 'blue'); //fadeOut(9000);
                $('#txt_desc_d').val("");
                $('#txt_codigo').val("");
                $('.mensagem_d').show();
            }
        });
    });

    /*
     * Metodos Salvar e associar estudante a disciplina
     * */

    $('#salvar_est').click(function (){

        var un = $('#txtemail').val();
        var pn = $('#txtsenha').val();
        var nomec = $('#txtnome').val();
        var desc= "Estudante";
        var sexo = $('#select_sexo').val();
        $('.sucesso_reg_est').show();

        $.ajax({
            url:"../requestCtr/Processa_registo_academico.php",
            data:{acao:3, prev:1,sexo:sexo,email:un,pass:pn, nomec:nomec},
            type:"POST",
            success:function(result){

                $.ajax({
                    url:"../requstCtr/Processa_registo_academico.php",
                    data:{acao:8, nrmec:pn, email:un},
                    type:"POST",
                    success:function (result){

                        $('.sucesso_reg_est').html(result).fadeOut(9000);
                        $('.sucesso_reg_est').show();
                        $('#txtemail').val("");
                        $('#txtsenha').val("");
                        $('#txtnome').val("");
                    }
                }) // fim segunda requisicao ajax depois do sucesso da primeira;
            }
        }) // fim primeira requisicao ajax;*/

    });

});

function buscar_disciplina(item){

    $.ajax({
        url:'../requestCtr/Processa_registo_academico.php',
        data:{acao:13, curso:item},
        type:'POST',
            success:function(data){
            $('.lista_disciplinas').html(data);
    }
    });
    localStorage.setItem('curso_id',item);
}

function buscar_pauta_freq(item){

    //alert(localStorage.getItem('curso_id'));

    $.ajax({

        url:"../requestCtr/Processa_pauta_freq.php",
        type:"POST",
        data:{acao:2, disp:item, curso:localStorage.getItem('curso_id'), ctr:1},
        success:function (result){
             $('.pautas_freq').html(result).fadeIn('slow');
        }
    });

    $('#filter_aluno').keyup(function(){

        var texto = $(this).val();

        if (texto.length >= 2){

            $.ajax({

                url:'../requestCtr/Processa_registo_academico.php',
                type:'POST',
                data:{acao:9, curso:localStorage.getItem('curso_id'),disp: item, texto:texto},
                success:function(data){
                    $('.lista_estudantes').show();
                    $('.lista_estudantes').html(data);
                }
            });
        }
    });
}


$("#rs_pesq_est li").click(function () {

    $('#campo_oculto').val($(this).val());
    $('#rs_pesq_est').hide("slow");
    $('#autocomplete-input').val($(this).text()).css({'color':'blue'});

});
/*Associar estudante as disciplinas do curso

 * */

$('#btn_assoc_est').click(function() {

    var vetor = $('select#filter-menu')[0];
    var curso = $('select#select_curso').val();
    var idaluno = $('#campo_oculto').val();

    for (var i=0 ;i < vetor.length; i++){

        if(vetor[i].value!="" && vetor[i].selected == true){
            $.ajax({

                url:"../requestCtr/Processa_registo_academico.php",
                type:"POST",
                data: {disp:vetor[i].value, curso:curso, estudante:idaluno, acao:10},
                success:function(result){
                    $('.sucesso_assoc_est').html(result).css('color','blue').fadeOut(6000);
                }
            });
        }
    }
});

//// ---------------------- fim metodos estudante -----------------------

function filter_estudante(item){
    var c = $('select#select_curso').val();

    if (c > 0 && item.length > 2) {

        $('#resultado').show();
        $('#resultado').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
        $('#resultado').listview("refresh");

        $.ajax({

            url: "../requestCtr/Processa_registo_academico.php",
            type: "POST",
            dataType: "json",

            data: {texto: item, curso: c, acao: 9},

            success: function (result) {

                for (var i = 0; i < result.length; i++) {

                    row += '<li value="' + result[i].id + '" onClick="put_doce_item(this.value, 3);"' +
                    ' data-theme="a"><a>' + result[i].fullname + '</a></li>';
                }

                $('#resultado').show();
                $('#resultado').html(row);
                $('#resultado').listview("refresh");
                $('#resultado').trigger("updatelayout");
            }
        }); // fim success
    }
}

function do_autocomplete(item, t) {

    if (item.length >= 3) {

        var row = "";
        if (t == 1) { // Pesquisa docente

            $('#resultados').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
            $('#resultados').listview("refresh");

            $.ajax({

                url: "../requestCtr/Processa_registo_academico.php",
                type: "POST",
                dataType: "json",

                data: {texto: item, acao: 6},
                success: function (result) {
                    for (var i = 0; i < result.length; i++) {
                        row += '<li value="' + result[i].id + '" onClick="put_doce_item(this.value, 1);">'
                        + '<a href="#">' + result[i].fullname + '</a></li>';
                    }
                    $('#resultados').show();
                    $('#resultados').html(row);
                    $('#resultados').listview("refresh");
                    $('#resultados').trigger("updatelayout");
                }
            }); // fim primeiro aja
        } // fim else
    } // fim funcao
}

/*

 * Metodos autocomplete estudante e docente
 * */
/*
 Carrega o id do docente corrente na lista;
 * */

function put_doce_item(item, t) {
    if (t == 1){

        $('#resultados').on('click','li', function(){
            $('#pesquisar_doc').val($(this).text()).css('color','blue');
        });
        $('.sucesso_assoc').show();
        $('#resultados').hide();

    }else{

        if (t == 2){
            $('#resultados_e').on('click','li', function(){
                $('#pesquisar_est').val($(this).text()).css('color','blue');
                set_item_estd($(this).text()); /// chama a funcao
            });
            $('#resultado').on('click','li', function(){
                $('#pesquisar_e').val($(this).text()).css('color','blue');
            });
            $('#resultados_e').hide();
            $('#resultado').hide();
        }
    }

    // associa docente a disciplinas
    var curso = $('.select_curso li.current').val();

    if (curso > 0 && item > 0 &&  t == 1){
        var vetor = $('select#filter-menu-doc')[0];

        $('.sucesso_assoc').show();
        $('#salvar_assoc_doc').click(function() {

            for (var i=0 ; i < vetor.length; i++){
                if(vetor[i].value!="" && vetor[i].selected == true){

                    $.ajax({

                        url:"../requestCtr/Processa_registo_academico.php",
                        type:"POST",
                        data: {disp:vetor[i].value, curso:curso, doc:item, acao:7},
                        success:function(result){
                            $('.sucesso_assoc').html(result).css('color','blue').fadeOut(6000);
                        }
                    });
                }
            }
            $('#resultados').hide();
        });
    }
} /// fim funcao

function set_item_estd(item) {
    var html ="";

    $('.titulo2').html("");
    $('.titulo2').html("Estudante Sujeito ao Pagamento: "+item);

    $.ajax({

        url: "../requestCtr/Processa_auto_avaliacao.php",
        type: "POST",
        dataType:"json",
        data: {nomec:item, acao:4},
        success:function(result) {
            if (result.length > 0) {

                for (var i = 0; i < result.length; i++) {

                    html += '<tr class="remove_tr"><td class="codigo">' + result[i].codigo + '</td>';
                    html += '<td>&nbsp;</td>';
                    html += '<td>' + result[i].descricao + '</td>';
                    html += '<td> <div style="text-align: center">' +
                    '<button data-theme="b" id="btn_assoc"' +
                    'style="font-size:12px; border:none" ' +
                    'value="' + result[i].idnota + '" class="ui-bar ui-bar-b"' +
                    'onclick="obter_valor(this.value)">Associar</button></div></td></tr>';
                }
                $('#table_rec').html(html);

            } else {

                $('#table_rec').html("Nao possui taxas a pagar");
                $('.titulo2').html(' Nao possui taxas a pagar!');
            }
        }
    });

}

/*-------------------------------------------------------------------------------------------------------------*/

function obter_valor_recorrencia(item) {

    $.ajax({
        url:"../requestCtr/Processa_auto_avaliacao.php",
        type:"POST",
        data:{acao:5, disp:item},
        success: function(result){
            //$('#tr_all_rec tr').removeClass('current');
            //$('#tr_all_rec tr.current').parent().parent().remove();
            //$('#tr_all_rec').remove('tr').fadeOut('slow');
        }
    });
}

function gerir_frequencia_disp(aluno, curso,disp ){
    var ctr ="exames";
    $.ajax({
            url: "../requestCtr/Processa_pauta_freq.php",
            type: "POST",
            data: {acao: 1, disp: disp, curso:curso, idaluno:aluno, ctr:ctr },
            success: function (result) {

                $('.res_exames_1').html(result);
                $('.showText').hide();
            }
        });

}

