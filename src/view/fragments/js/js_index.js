/**
 * Created by rjose on 7/20/2016.
 */

var acess = 0, vez =0;

$(document).ready(function() {

    $('.go_offline').click(function () {
        window.location = "offlineApp/Docente_offline.html";
    });

    $('.menu_opcao li').hover(function () {

        if ($(this).val() > 0){
            $('.menu_opcao li.current').removeClass('current').css({'background':'white', 'color':'black'});
            $(this).closest('li').addClass('current');
            $(this).closest('li ').css({'background':'#E6E8FA', 'color':'blue'});
            ///console.log(''+$(this).val());*/
        }
    });


    $('#name').on('change', function () {

        if ($('#name').val() == " ") {
            $('#ac_name').text("* Obrigatorio").css('color', 'red').fadeOut(1000);
        }
    });

    $('#pass').on('change', function () {
        if ($('#pass').val() == "") {
            $('#ac_pass').text("* Obrigatorio").css('color', 'red').fadeOut(1000);
        }
    });

    $('#btnlogin').on('click', function () {
        if ($('#name').val() == " ") {
            $('#ac_name').text("* Obrigatorio").css('color', 'red').fadeOut(5000);
        }

        if ($('#pass').val() == "") {
            $('#ac_pass').text("* Obrigatorio").css('color', 'red').fadeOut(5000);
        }
        if ($('#name').val() == "" && $('#name').val() == "") {
            $('#myresultlogin').text("* Todos campos obrigatorios").css('color', 'red').fadeOut(1000);
        }
    });

    $('#confirmar_rec').click(function () {

        var nome = $('#rec_nome').val();
        var el = $('#rec_email').val();

        $.ajax({

            url: "/requestCtr/Processa_docente.php",
            type: "POST",

            data: {email: el, fullname: nome, acao: 1},
            success: function (result) {

                $('#popupLogin').popup('close');
                var texto = jQuery.parseJSON(result);
                jAlert(texto, 'Confirmação', function (r) {

                    if (r) {
                        $('.menu_opcao').hide();
                        $('.login_ctr').show();
                    }
                });
            }
        });

    });
});

/***
 * Funcoes devem estar fora do arquivo document ready
 */


function obter_pdf(item) {
    window.location = "relatorios/Manual_utilizador.php?acao=1";
}

/* Codigo js para o primeiro login---------------------------*/

function login_offline(){

    var un = $('#username').val();
    var pw = $('#password').val();
    $("#result").show();

    if (un != ""){

        var db = prepareDatabase();
        db.transaction(function(t){

            var query = 'SELECT COUNT(*) AS conta FROM ctr_acesso WHERE ctr_acesso.user = ? AND ctr_acesso.pass = ?';
            t.executeSql(query, [un, pw], function (t, rs) {
                if (rs.rows.item(0).conta > 0){
                    $('#login_offline').hide();
                    $('#ctr_login_doc').show('slow');
                    get_vl ++;
                }else{
                    $("#result").html("Talvez nome ou senha esteja errado").css({'color':'red','font-size':'13px','margin-top':'-1em'})
                        .fadeOut(9000);
                }
            }, function(t, e) {
                jAlert('insercao do estudante: ' + e.message);
            });
        });

    }else{
        $("#result").html("Deve preencher em todos campos de texto").css({'color':'red','fontSize':'13px', 'margin-top':'-1em'});
    }
}

/*
 * Teste par o segundo Login popup----------------------------*/
function login_online(){

    //alert('kkkk');

    var un = $('#name').val();
    var pw = $('#pass').val();
    $(".result_login").show()

    if (un != ""){

        $.ajax({

            url: "requestCtr/Processa_autenticacao.php",
            type : "POST",
            data: {username:un,password:pw, acao: 2},
            success: function(result){
                $(".result_login").html(result)
                    .css({'font-size':'18px','color':'red'});
            }
        });

    }else{

        $('#name').css({'border':'2px solid blue '});
        $(".result_login").html("Deve prencher todos os campos vazios")
            .css({'font-size':'14px','color':'red','font-weight':'bold'});
    }
};