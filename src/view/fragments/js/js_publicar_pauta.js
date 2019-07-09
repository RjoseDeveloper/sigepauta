/**
 * Created by Raimundo Jose on 4/5/2018.
 */
$(document).ready(function(e) {


    $('#cl_publicar').on('click',function (){

        Javascript:history.go(-1);
    })

    $('#back').click(function(){
        Javascript:history.go(-1);
    });

    $('#sv_notificar_doc').click(function(){
        $('.notificar').html('Disciplina Selecionada : '+$('#nome_dp').val());
    });


    // esta funcao remove a pauta da lista de publicacoes

    $('#btn_publicar').on('click', function (){

        var radios = $('btn_publicar')[0];
        for (var i = 0; i< radios.length; i++){

            if (radios[i].value != 0){

                $('.av_lista ul').fadeOut('slow');

                $.ajax({

                    url:"../../requestCtr/Processa_edit_avaliacao.php",
                    type:"POST",
                    data:{acao:6, pauta:radios[i].value},
                    success: function(data){
                        location.reload(1).fadeIn(20000);
                    }
                }); // Termina a primeira requisicao ajax;*/
            }
        }
    });
});

function aceitar_inclusao(item){

    var nrmec = $('.operacao_include  #campo_nrmec');
    var notas = $('.operacao_include #campo_nota');
    var pautas = $('.operacao_include #campo_pauta_id');
    var IDs= $('.operacao_include #campo_id');
    var linhas = $('#remove_tr tr');
    $('.sucesso_include').show();

    for (var i = 0; i < pautas.length; i++){
        if (IDs[i].value == item){
            var t = i;

            $.ajax({
                url:"../../requestCtr/Processa_cadastro_pauta.php",
                data:{acesso:12,idpauta:pautas[i].value, nota:notas[i].innerText, nraluno:nrmec[i].value},
                type:"POST",
                success:function(result){
                    $('.sucesso_include').html(result).fadeOut(12000).css('fontSize','32px');
                    var mid = $('#remove_tr tr')[t];
                    $(mid).fadeOut('slow');
                    return;
                }
            })
        }
    }
}

function rejeitar_inclusao(item){

    var nrmec = $('.operacao_include  #campo_nrmec');
    var notas = $('.operacao_include #campo_nota');
    var pautas = $('.operacao_include #campo_pauta_id');
    var IDs= $('.operacao_include #campo_id');
    var fullname = $('.operacao_include #campo_fullname');

    for (var i = 0; i < pautas.length; i++){
        if (IDs[i].value == item){
            $('.notificar').html('Estudante a Notificar: '+ fullname[i].innerText);
            $('#pageM').popup('open');
        }
    }
}

function publicar(item)  {

    $.ajax({

        url:"../requestCtr/Processa_edit_avaliacao.php",
        type:"POST",
        data:{acao:3, pauta:item},
        success: function(data){

            $('.av_lista li h5').html(data).css('color','red');
            $('.av_lista ul').fadeOut('slow');
            location.reload(1).fadeIn(20000);
            //history.go(-1);
        }
    });
}