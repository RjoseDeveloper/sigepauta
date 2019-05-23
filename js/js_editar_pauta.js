/**
 * Created by Raimundo Jose on 10/9/2017.
 */

var id_disp = 0, nome_completo, disp_nome;

$('.ul_li_items #resultados li').hover(function(){

     $('li.current ').removeClass('current').css({'background':'white', 'color':'black'});
     $(this).closest('li').addClass('current');
     $(this).closest('li ').css({'background':'#E6E8FA', 'color':'blue'});

});


/**
 *Esta funcao busca a nota do estudante o nome e seu numero mecanografico para permitir alteracao
 *  */
function set_item(item) {

    if (item !=null){
        $('#texto').val(item);
        nome_completo = item;

        $('#resultado').hide();
        //$('.nextAction').show()
        $('.n_est').text(item).css('color','#ff9933');
        $('.textoFixo').text('Editar Nota Estudante').css('color','white');
        $('#texto').text('');

        $('.myNotas').show();
        $('#btnSave').hide();

        id_disp = $('select#sdisciplina').val();
        $.ajax({

            url: 'Processa_auto_avaliacao.php',
            type: 'POST',
            data: ({disciplina:id_disp, nomeapelido:nome_completo, acao:2}),
            success:function(data){
                $('.nome_est').html(data);
                $('#btnSave').hide();
            }
        })

    }else{
        $('.myNotas').hide();
    }
}

$(document).ready(function(e) {

    /*
     * Inicializacoes de variaveis e componentes
     * */

    $('.myNotas').hide();
    $('.editar_nota').hide();
    $('#btnSave').hide();
    $('#a_nota').hide();
    $('#print_report').hide();
    $('.ctr_report_final').hide();

    /**
     * Metodos e Eventos de Pesquisa Estudante
     * */

    $('#pesquisar_est').on('click', function () {
        $('.disciplinas_doc').css('width', '75%');
    });


    $('#texto').on('keyup', function () {
        $('.n_est').text($(this).val()).css('color', 'blue');
    });

    /**
     * Evento click aaplicado no botao incluir estudante numa pauta por ausencias
     *
     * */

        //Evento aplicado ao clicar o item autocomplete estudante na edicao de nota.

    $('#resultados').on('click', 'li', function (event) {
        $('.nome_e').html("Resultado da Pesquisa &nbsp; <span class='glyphicon glyphicon-search'></span>" + $(this).text()).css({
            'color': 'blue',
            'font-size': '16px'
        });
        event.stopPropagation();

        $('.disciplinas_doc').css('width', '100%');
    });

    /***
     * Evento Caregar model include nota estudante
     */

    $('.btn_include').click(function () {
        $('#popup_editar_nota').modal({backdrop: false});
    });
    // evento aplicao no botao incluir estudante  e_nome eh uma variavel que permite mostrar o nome do estudante pesquisado ao editar nota.

    $('#btnSave_nota').click(function () {

        var un = $('#email_doc').val();
        var pn = $('#senha_doc').val();
        var dest = $('#email_doc_ass').val();
        var msg = $('#txtmotivo').val();

        var notas = parseFloat($('#nota').val());
        $.ajax({

            url: "../requestCtr/Processa_edit_avaliacao.php",
            type: "POST",
            data: {nota: notas, email_doc_ass: dest, txtmotivo: msg, user: un, senha_doc: pn, acao: 4, ctr: 2},
            success: function (result) {

                $('.sucesso').show();
                $('.sucesso').html(result)
                    .css({'color': 'red', 'font-size': '15px'}).fadeOut(12000);
            }
        });
    });
});



//    $('.btn_edit_nota').click(function () {
//
//
//
//    /*
//     * Metodo buscar estudante inclusao notas;
//     *
//     * */
//
//    $('#text_estudante').keyup(function(){
//
//        var row="";
//        var keyword = $(this).val();
//        var c = $('#curso_hide').val();
//
//        if (keyword.length >= 3){
//
//            $('#resultados_e').show();
//
//            $.ajax({
//
//                url:"../requestCtr/Processa_registo_academico.php",
//                type:"POST",
//                data: {texto:keyword, curso:c, acao:9},
//                success : function(result){
//                    $('#resultados_e').html(result);
//                }
//            });
//        }else{$('#resultados_e').hide();}
//    });
//
//    /***
//     * Mettodo que permite fazer inclusao de nota de u estudante ausente na avaliacao
//     */
//    $('#resultados_e').on('click','li',function(){
//
//        $('#text_estudante').val($(this).text()).css('color','blue');
//        $('#resultados_e').hide();
//        $('.sucess_include').show();
//
//        var nrmec = $(this).val();
//        var item = $('#idptn').val();
//
//        $('#btn_salvar').click(function(){
//
//
//
//            var motivo = $('#txtmotivo').val();
//            var nota = $('#text_nota').val();
//
//            alert(nota+'  M: \n'+motivo+' \nnrmec: '+nrmec+' Pauta: '+item);
//
//            $.ajax({
//                url:"../requestCtr/Processa_auto_avaliacao.php",
//                data:{ptn:item,nota:nota,nrc:nrmec, cmt:motivo,av:texto, acao:8},
//                type:"POST",
//                success: function (result) {
//                    alert(result)
//                    $('.sucess_include').html(result).fadeOut(1000);
//                }
//            })
//        });
//    })
//});

    /*
     * Evento aplicado na linha dos items das disciplinas associados ao docente
     * */

    function load_id_docente(item) {

        var c = $('select#select_curso').val();
        $('#pesquisar_est').keyup(function () {
            var keyword = $(this).val();
            $('#resultados').html("");
            if (keyword.length >= 1) {

                $('.editar_nota').hide();
                sessionStorage.setItem('disp', item);

                $.ajax({
                    url: "../requestCtr/Processa_lista_estudante.php",
                    type: "POST",
                    data: {keyword: keyword, curso: c, acao: 4, disp: item},
                    success: function (result) {
                        $('#resultados').show('slow');
                        $('#resultados').html(result);
                    }
                })
            }
        });
    }

    /*-----------Busca dados de estudante nome e numero mecnografico ---------------
     *
     * Evento aplicado no campo de texto pesquisa estudante
     * */
    function obter_estudante_nota(item) {

        $('#pesquisar_est').val(item);
        $('#resultados').hide();
        var html = "", i;
        var c = sessionStorage.getItem('disp');

        $.ajax({

            url: "../requestCtr/Processa_lista_avaliacao.php",
            type: "POST",

            data: {nrmec: item, disciplina: c, acao: 1, ctr: 1},
            success: function (result) {
                $('.sucesso').show();
                $('.mostrar_avaliacao').show('slow');
                $('.mostrar_avaliacao').html(result);
            }
        });
    }

    function get_list_avaliacao() {

        var c = $('#curso_hide').val();
        var disp = sessionStorage.getItem("disp");
        $.ajax({

            url: "../requestCtr/Processa_edit_avaliacao.php",
            type: "POST",
            data: {curso: c, disciplina: disp, acao: 1, ctr: 2},

            success: function (result) {

                alert(result);

                $('.sucesso').show();
                $('.mostrar_avaliacao').html(result);
                $('.sucesso').html('Seleccionar tipo de avaliação').css('color', 'green').hide(12000);
            }
        })
    }


    /**Metodos e Eventos para Relatorios
     * */

    $('.ul_li_item').on('click', 'li', function () {

        $('.disciplinas_doc  li.current').removeClass('current').css({'color': 'red'});
        $(this).closest('li').addClass('current').css({'color': 'blue'});

        disp_nome = $(this).text();
        $('.emitir_rel').html('Relatorios para a Disciplina de ' + $(this).text()).css('color', 'blue');
    });

    $('select#sdisciplina').on('click', function () {
        id_disp = $(this).val();
    });


    function mostrar_relatorio(item) {

        //alert(item);

        var c = $('select#select_curso').val();
        //alert(c);

        $.ajax({
            url: "../requestCtr/Processa_lista_Avaliacao.php",
            type: "POST",
            data: {acao: 2, disp: item, curso: c},
            success: function (result) {

                $('.list_pautas').show('slow');
                $('.list_pautas').html(result);
            }
        })

        $('.btn_pauta_freq').click(function () {


            $.ajax({

                url: "../requestCtr/Processa_lista_avaliacao.php",
                type: "POST",
                data: {curso: c, disciplina: item, acao: 1, ctr: 2},
                success: function (result) {

                    $('.sucesso').show();
                    $('.mostrar_avaliacao').html(result);
                    //$('.sucesso').html('Seleccionar tipo de avaliação').css('color', 'green').hide(12000);
                }
            })
        });

        $('.btn_pauta_final').click(function () {
            window.location = "../reports/Pauta_final_excel.php?disp=" + item + "&curso=" + c;
        });

        $('.btn_relatorio_semestral').click(function () {

            $('.resumo').html('Relatorio Semestral  ' + disp_nome);
            $('#relatorio_f').modal();


            $('#btn_print_rsemestral').click(function () {

                var campo = $('.disciplinas_doc li.current');

                sessionStorage.setItem('ndisp', disp_nome);

                var nomed = $('#txtnomedisp').val();
                var nd = nomed.toUpperCase();
                var c = $('#curso_hide').val();
                var dsf = $('#txtdesafios').val();
                var ctrg = $('#txtconstrg').val();
                var av = $('#txtdetalhes').val();
                var cpl = $('#txtmetaplano').val();

                $.ajax({

                    url: "../reports/Relatorio_semestral.php",
                    data: {
                        nomedisp: nd,
                        av: av,
                        curso: c,
                        disp: item,
                        cplano: cpl,
                        constrag: ctrg,
                        desafios: dsf,
                        ctr: 1
                    },
                    success: function (rs) {
                        window.location = '../reports/Relatorio_semestral.php?ctr=2';
                    }
                });
            });
        });

    }

    function print_lista_pauta(item, valor) {
        var acao ="";

        if (valor == 'pdf') {acao = 'I'}

        if (valor == 'html') {acao = 'I';}

        window.location = '../reports/Relatorio_pautaFreq.php?ptn=' + item + '&acao=' + acao;
    }

