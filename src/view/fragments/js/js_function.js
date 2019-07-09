
var contador = 0, contador2 = 0;
var texto;

/*
* Metodos executados assim que as paginas estivere carregadas
*
* **/

$(document).ready(function(){
    $('.ul_li_item li').click(function(){

        $('li.current ').removeClass('current').css({'background':'white', 'color':'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li ').css({'background':'#E6E8FA', 'color':'blue'});
        disp_nome = $(this).text();

    });
})


function enviar_email(item) {

    $.ajax({
        url:"../../requestCtr/Processa_docente.php",
        type:"POST",
        data:{disp:item, acao:4},
        success:function (result){
            $('.visualizar_pl').hide();
            $('.enviare').html(result);
            $('.enviare').show('slow');
        }
    });
}

function send_email(dp){

    var e = $('#txtarea').val();
    var msg = $ ('#txtemail').val();
    var sh = $('#txtsenha').val();
    var btval = $('#send_email').val();
    $('#res_sucess').show();

    $.ajax({
        url:"../../requestCtr/Processa_docente.php",
        type:"POST",
        data:{disp:dp, txtarea:msg,txtemail:e, senha:sh, acao:5},
        success:function(result){

            if (btval == 1){
                $('#res_sucess').html(result).fadeOut(9000);
            }else{
                $('#resultados').html(result).fadeOut(9000);
            }
        }
    });
}


var vez = 0, tipoavaliacao, nt;

$('select#getAvaliacao').click(function (event){
    tipoavaliacao = $(this).val();
});


/**
 *Esta funcao envia o ID da nota para o php de edicao especificado no parametro;
 *  */
function  getItem(item){

    $.ajax({
        url:"../../requestCtr/Processa_edit_avaliacao.php",
        data:({idNota:item, acao:1}),
        type:"POST",
        success: function(result){
            if (result >= 0 && result <= 20){

                $('#nota').val(result);
                $('.editar_nota').show('slow');

            }else{
                alert ('O estudante ainda nao efectou o pagamento da taxa de exame de recorrencia desta forma o sistema nao permite alteracao');
                return;
            }
        },
        error: function(){
            alert ('Nao foi possivel registar!');
        }
    });
/*
* Evento permite editar nota estudante
* */

    $('#btnSave').click(function (){

        nt = $('#a_nota').val();
        $.ajax({

            url:"../../requestCtr/Processa_edit_avaliacao.php",
            type:"POST",
            data: {nota:nt, id:item, acao:4},
            success: function(data){

                $('.sucesso').html(data)
                    .css({'font-size':'20','color':'red','font-family':'serif','font-weight':'bold', 'margin-bottom':'1em'})
                alert("Aleteracao efectuada com sucesso");
                $('.myNotas').hide();
                $('.nextAction').show();
                $('.formularioP').hide();
            }
        });
    });
}

/* --------------- Funcoes pesquisar docente ---------------------------------*/

/*

 * metodos pesquisar estudante e comeca pelo metodo autocompletar docente;
 * */

function do_autocomplete(item, t){

    $('#resultados').html("");
    var min_length = 3;
    if (item.length >= 3) {

        var row = "";
        if (t == 1){ // Pesquisa docente

            $('#resultados').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
            $('#resultados').listview("refresh");

            $.ajax({

                url:"../../requestCtr/Processa_registo_academico.php",
                type:"POST",
                dataType:"json",

                data: {texto:item,acao:6},
                success : function(result){

                    for (var i=0;  i < result.length; i++){
                        row += '<li value="'+result[i].id+'" onClick="put_doce_item(this.value, 2);">'
                        +'<a href="#">'+result[i].fullname+'</a></li>';
                    }
                    $('#resultados').show();
                    $('#resultados').html(row);
                    $('#resultados').listview( "refresh" );
                    $('#resultados').trigger( "updatelayout");
                }
            }); // fim primeiro ajax
        }else{ // fim if de busca docente

            var c =  $('.get_curso li.current').val();
            if (t == 2 && c > 0){

                $('#resultados_e').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                $('#resultados_e').listview("refresh");

                $.ajax({

                    url:"../../requestCtr/Processa_registo_academico.php",
                    type:"POST",
                    dataType:"json",

                    data: {texto:item,curso:c, acao:9},
                    success : function(result){

                        for (var i=0;  i < result.length; i++){
                            row += '<li value="'+result[i].id+'" onClick="put_doce_item(this.value, 2);">' +
                            '<a href="#gerir_recorencia" data-position-to="window" data-rel="popup" data-transition="pop">'+result[i].fullname+'</a></li>';
                        }

                        $('#resultados_e').show();
                        $('#resultados_e').html(row);
                        $('#resultados_e').listview( "refresh" );
                        $('#resultados_e').trigger( "updatelayout");
                        ///set_item_estd(item);
                    }

                }); // fim segundo ajax
            }else{ // fim if

                var cr = $('.select_curso li.current').val();

                if (t == 3 && cr > 0){
                    $('#resultado').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
                    $('#resultado').listview("refresh");

                    $.ajax({
                        url:"../../requestCtr/Processa_registo_academico.php",
                        type:"POST",
                        dataType:"json",
                        data: {texto:keyword, curso:cr, acao:9},
                        success : function(result){

                            for (var i=0;  i < result.length; i++){
                                row += '<li value="'+result[i].id+'" onClick="put_doce_item(this.value, 2);" data-theme="a"><a>'+result[i].fullname+'</a></li>';
                            }

                            $('#resultado').show();
                            $('#resultado').html(row);
                            $('#resultado').listview( "refresh" );
                            $('#resultado').trigger( "updatelayout");
                        }
                    }); // fim success

                }else{alert('Seleccionar o curso Primeiro','Atencao', function(r){if(r)return;})} // fim primeiro if
            }
        }  // fim else
    }// fim primeiro if
} // fim funcao

/*
 *
 *
 * */

$('select#get_tipo_aval').change(function(){

    var item = $(this).val();
    $('#idpauta').val($(this).val());

    var matriz = $(this);

    for(var i =0; i< matriz.length; i++){
        for(var j=0; j< matriz[i].length; j++){
            var sub_matriz = matriz[i];

            if (sub_matriz[j].value == item){
                texto = sub_matriz[j].innerText;
            }
        }
    }

    $.ajax({

        url:"../../requestCtr/Processa_docente.php",
        type:"POST",
        data:{ptn:item, acao:6},
        success:function (rs){
            var x = parseInt(rs);
            if (x == 2){ // a pauta ja foi publicada

                $('#print_report').show('slow');
                $('.ctr_report_final').hide();
                $('#print_report').click(function() {
                    window.location ="../relatorios/Pauta_parcial.php?ptn="+item;
                });

            }else{
                alert("Avaliação seleccionada ainda nao foi publicada!","Atenção");
            }
            var av = $('select#get_tipo_aval > option:selected').html();
            $('.text_include').html('Incluir/Excluir Estudante no '+texto+' da  Disciplina de '+ disp_nome).css('color','blue');
            $('#btn_include').show();
        }
    });
});


/****
 * Metodo que permite destruir sessao on click na menu sair
 */

function destroy_user_session(){
    
    $.ajax({
        url:"../../requestCtr/Processa_autenticacao.php",
        type:"POST",
        data:{acao:3, ctr:0},
        success:function(){;}
    });
}






