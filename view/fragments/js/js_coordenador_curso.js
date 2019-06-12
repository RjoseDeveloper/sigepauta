/**
 * Created by Raimundo Jose on 10/9/2017.
 */


$(document).ready(function(e) {

    $('.notificacao_pauta').hide();

    $('#notif_inc').click(function(){

        $('.publicao_pauta').hide();
        $('.notificacao_pauta').show('slow');

    });

    $('#publicar').click(function(){

        $('.publicao_pauta').fadeIn('slow');
        $('.notificacao_pauta').hide();

    });

    $('.resultados').on('click','li ', function(){

        $('.resultados li.current ').removeClass('current').css({'background':'white', 'color':'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li ').css({'background':'rgba(220,220,250,255)', 'color':'blue'});

    });

    /***
     * Evento aplicado ao ser clicado o menu lista  das disciplinas para publicacao
     */

    $('.pautas_publicacao li').click(function (){


        var s = $(this).val();
        //alert(s);

        if (s > 0){
            window.location ='../../requestCtr/Processa_publicacao_pauta.php?acao=1&disp='+s;
            localStorage.setItem("envio", s);
        }
    });

    $('.pt_inclusao li').click(function () {
        var s = $(this).val();
        if (s > 0){

            window.location ='../../requestCtr/Processa_publicacao_pauta.php?acao=2&disp='+s;
            localStorage.setItem("envio", s);
        }
    });

});