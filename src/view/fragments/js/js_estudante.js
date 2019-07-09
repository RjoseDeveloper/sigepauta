
/*
 * Metodo autocomplete do docente
 * */

$(document).ready(function(){

    $('#users-contain').hide();
    $('.myresult').hide();
    $('.table_plano').hide();
    $('.full_table').hide();
    $('.div_plano').hide();

    /// evento click sobre o item select box ano e carrega o texto actual
    $('#select_ano_list li a').on('click', function(){

        $('.active_ano').html('Ano activo_'+$(this).html()).css('color','red');
        $('txt_ano_activo').val($(this).html());

    });

    $("#home").click(function(){

        $('.contente_freq').hide();
        $('.main_div').slideDown('slow');
    });

    /***
     * Metodos para a classe formando
     */


    $('.list_view_frm').on('click','li', function(){
        $('#auto_aluno').val($(this).text());
        $('.list_view_frm').hide();
    });

    $('.list_view_encarregado').on('click','li', function(){
        $('#auto_encarregado').val($(this).text());
        $('.list_view_encarregado').hide();
    });

});


function pesquisar(item, ctr){
    // var inp = $("#auto_aluno");

    $.ajax({
        url: '../../controller/FormandoCtr.php',
        data: {acao: 10, q:item, ctr:ctr},

        success: function (data) {

            if(ctr == 1){
                $('.list_view_frm').show();
                $('.list_view_frm').html(data);
            }else{
                $('.list_view_encarregado').show();
                $('.list_view_encarregado').html(data);
            }
            //autocomplete("auto_aluno",data);
        }
    });
}
function obter_estudante_nota(item, ctr){
    if (ctr === 1){
        $('#campo_frm').val(item);
    }else{
        $('#campo_utilizador').val(item);
    }
}



/**
 * Funcao permite buscar avaliaceos de frequecia apos o clique no botao pauta de frequencia.
 * @param item
 */

function buscar_avaliacao_freq(item){

        $('.contente_freq').html("");

            $.ajax({
                url:"../../requestCtr/Processa_pauta_freq.php",
                type:"POST",
                data:{acao:2, disp:item},
                success:function (result){
                    $('.'+item).html(result).show('slow');
                    $('.pp'+item).hide();
                }
            });
}

/***
 * Funcao permite buscar avaliacao de frequencia apartir do botao Pautas de Exame
 * @param item
 */

 function buscar_avaliacao_exame(item){
    $.ajax({
        url: "../../requestCtr/Processa_pauta_freq.php",
        type: "POST",
        data: ({acao: 1, ctr: 4, disp: item}),
        success: function (result) {
            $('.'+item).html(result).show('slow');
            $('.pp'+item).hide();
        }
    });
}


// autocomplete para a funcao pesuqisar tipo de avaliacao

function do_autocomplete_disp (item, temp){

    var row = "";
    if (item.length > 0) {

        $.ajax({
            url: '../../requestCtr/Processa_nota.php',
            type: 'POST',
            dataType: "json",
            data: ({disp: item, acao: 2}),
            success: function (result) {

                if (temp == 1){

                    $('#resultado').show('slow');
                    $('#resultado').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                    $('#resultado').listview("refresh");

                    for (var i = 0; i < result.length; i++) {
                        row += '<li value="' + result[i].id + '" class="ui-bar-a" ' +
                        'onClick="mostrar_plano(this.value);" data-theme="a">' + result[i].descricao + '</li>';
                    }

                    $('#resultado').show();
                    $('#resultado').html(row);
                    $('#resultado').listview("refresh");
                    $('#resultado').trigger("updatelayout");

                 }else{

                    $('#rs_plano_av').show('slow');
                    $('#rs_plano_av').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                    $('#rs_plano_av').listview("refresh");

                    for (var i = 0; i < result.length; i++) {
                        row += '<li value="' + result[i].id + '" class="ui-bar-a" ' +
                        'onClick="get_item(this.value);" data-theme="a">' + result[i].descricao + '</li>';
                    }

                    $('#rs_plano_av').show();
                    $('#rs_plano_av').html(row);
                    $('#rs_plano_av').listview("refresh");
                    $('#rs_plano_av').trigger("updatelayout");
                }
            }
        }); // fim primeiro ajax

    }else{
        $('#resultado').hide();
        $('#rs_plano_av').hide();
    }
}

$("#txt_avaliacao").keyup(function(){

    if ($(this).val().length > 0){

        $('#ul_av_exames').show();
		do_autocomplete_disp($(this).val());
		
    }
})

$('#ul_av_exames').on('click','li', function (){
    $('.modal-title').html('Exame da disciplina de_ '+$(this).text());
    $('#select_freq').hide();
    $('#txt_avaliacao').val("");
    $('#ul_av_exames').hide();
});


$('#resultado').on('click','li', function (){
    $('.modal_avaliacao').html('Detalhes do Plano de Avaliação - '+ $(this).text());
    $('#resultado').hide();

});

/*
 * funcao busca plano de avaliacao por disiplina
 * */


function mostrar_plano(item){

    $.ajax({

        url:"../../requestCtr/Processa_cadastro_pauta.php",
        type:"POST",
        data:{disp:item, acesso:7, ctr:1},

        success: function (res){

            $('#table_plano_m').html(res);
            $('#rs_plano_av').hide();
            $('#resultado').hide();
            $('#rs_plano_av').hide();

        }
    });

    $.ajax({

        url:"../../requestCtr/Processa_cadastro_pauta.php",
        type:"POST",
        data:{disp:item, acesso:9},
        success: function (res){
            $('.div_plano').show('slow');
            $('#table_plano1').html(res);
            $('#rs_plano_av').hide();
        }
    });
}



function buscar_av_publicada(item){

    $('.descricao').html("");
    $('.descricao').hide();

    var row ="";

    if (item !=null){

        $.ajax({

            url: '../../requestCtr/Processa_nota.php',
            type:  "POST",
            data: {disp:item, acao:9},
            success : function(result){

                row+='<li><h3 align="center" style="margin-bottom: -.8em">'+$('#save_nome_disp').val()+'</h3></li>';
                row+=result;
                $('#res_tipo_av').show('slow');
                $('#res_tipo_av').html(row);
            }
        }); // fim primeiro ajax

    }else{$('#res_tipo_av').hide();}
}


function get_item_disp(item) {
    /*
     funcoes mostrar avaliacao de disciplina
     * */

    if (item != null) {

        $.ajax({

            url: "../../requestCtr/Processa_nota.php",
            type: "POST",
            data: {disp: item, acao: 1},
            success: function (result) {

                $('.myresult').show('slow');
                $('.mycontente').html(result);
            }
        });
    }
}