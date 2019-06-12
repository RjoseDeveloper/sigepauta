/**
 * Created by Raimundo Jose on 6/19/2018.
 */

$(document).ready(function(){

    $('#btn_guardar_actividade').click(function(){

        var di = $('#datainicio').val();
        var df = $('#datafim').val();
        var ida = $('#actividade').val();

        $.ajax({
            url: "../../requestCtr/Processa_gestao_pautas.php",
            type: "POST",
            data: {data_ini: di, data_fim: df, idactividade: ida, acao: 1},
            success: function (result) {
                $('.sms_report').html(result);
            }
        });
    });

    $('#actividade').on('change', function(){
        var xhtml="";
        $('.data_dinamics').html("");


        xhtml+='<label for="nv_avaliacao">Inserir a descrição:</label><div class="form-group">';
        xhtml+='<div class="input-group col-md-14">';
        xhtml+='<input class="form-control nv_avaliacao" type="text" value="">';

        if (this.value == 'avaliacao'){
            xhtml+='<span class="input-group-addon btn_nova_av "><span id="btn_guardar_av" onclick="salvar_avaliacao(0)">Guardar</span></span></div></div>';
        }else{
            xhtml+='<span class="input-group-addon btn_nova_av "><span id="btn_guardar_atv" onclick="salvar_avaliacao(1)">Guardar</span></span></div></div>';
        }
        $('.data_dinamics').html('<br>'+xhtml);
    })
});

/***
 * Evento Registar nova avaliacao
 */

function salvar_avaliacao(ctr){

    var x = $('.nv_avaliacao').val();
    $('.sms_report').html('');
    $.ajax({
        url:"../../requestCtr/Processa_plano_avaliacao.php",
        type:"POST",
        data:{acesso:11,avaliacao:x, ctr:ctr},
        success:function(data) {

            $('.sms_report').html(data).css('color','blue');
        }
    });
}
