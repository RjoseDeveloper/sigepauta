/**
 * Created by Raimundo Jose on 8/31/2017.
 */
var  disciplinas = [], vetor_datas = [];

$(document).ready(function() {

    /***
     * Codigo e initializacoes passadas
     */
    var qtd, dp, tipo;
    var ctr = 0, vez = 0;
    var global = [];
    var valor = 0, soma = 0;
    var i = 0, k = 0, s = 0, t = 0;
    var p1 = 0, p2 = 0, p3 = 0;

    //$('.pl_registar').hide();

    $('.mybotton').hide();
    $('#pesq_doc').hide();
    $('.all_plano').hide();
    $('#myform').hide();

    $('.hide_btn').hide();
    $('.sucess').hide();
    $('.with_botton').hide();
    $('.myvar').hide();
    $('#rs_docente').hide();
    $('#adpter_disp').hide();
    $('.disp_doc_pesq').hide();
    $('#vz_all_plano').hide();
    $('.hide_div').hide();
    $('#resultados').hide();
    $('#notificar_doc').hide();
    var d = new Date();
    //alert(d.getUTCMonth()+1)

    var semestre = d.getUTCMonth()+1 < 7 ? '1':' 2';
    //mostrar_plano_avaliacao("", semestre,new Date().getFullYear());

    /*
     * Adiciona o titulo ao model-header
     * */
    $('.docente_disp_plano li').click(function () {

        $('#autocomplete-input').val($(this).text()).css({'color': 'green', 'fontWeight': 'bold'});
        $('.docente_disp_plano').hide();
        $('.modal-title').html("Realizar Plano de Avaliação de " + $(this).text() + "");
    });

    $('.resultados').on('click', 'li', function () {
        $('.resultados li.current ').removeClass('current').css({'background': 'white', 'color': 'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li ').css({'background': 'rgba(220,220,250,255)', 'color': 'blue'});
    });

    $('#btn_reg_plano').click(function () {
        $(this).hide();
        $('#assoc_doc').show();
    });

    /****
     * docente disciplina
     * */

    $('.docente_disp').on('click', 'li', function () {
        $('.docente_disp li.current').removeClass('current').css({'background': 'white', 'color': 'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li').css({'background': 'rgba(235,240,250,255)', 'color': 'blue'});
        $('#disp_selected').val($(this).val());

    });

    $('#rs_docente_disciplinas').on('click','li', function(){

        $('li.current ').removeClass('current').css({'background':'white', 'color':'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li').css({'background':'#E6E8FA', 'color':'blue'});

    });

    $('#resultados').on('click', 'li', function () {

        $('#resultados li.current').removeClass('current').css({'background': 'white', 'color': 'black'});
        $(this).closest('li').addClass('current');
        $(this).closest('li').css({'background': 'rgba(235,240,250,255)', 'color': 'blue'});
    });


    /* Coloca os valores no vetor de dados
     * */

    $('.proximo').click(function () {

        var radios = $('input:checked');
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value != 0 && radios[i].checked == true) {

                $.ajax({
                    url: "../requestCtr/Processa_edit_avaliacao.php",
                    type: "POST",
                    data: {acao: 3, pauta: radios[i].value},
                    success: function (data) {
                        $('.myp').html(data).css('color', 'blue').fadeOut('slow');
                        location.reload(1).fadeIn(12000);
                    }
                }); // Termina a primeira requisicao ajax;
            }
            if (radios[i].value == 0) {
                vetor.push(radios[i].value);
            }
        }
    });

    /**
     * Metodo para criar campos datas
     */

    $('.btn_criar_cdatas').click(function () {

        var qtd = $('.qtd_avaliacao').val();
        var xhtml = "";

        for (var i =0; i < qtd; i++){

            xhtml+='<div class="form-group">';
            xhtml+='<div class="input-group date form_date col-md-14 datas_av" data-date=""';
            xhtml+='data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">';

            xhtml+='<input class="form-control" id="datas_avaliacao" size="16" type="date" placeholder="aaaa-mm-dd" value="">';
            xhtml+='<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>';
            xhtml+='<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
            xhtml+='</div>';

            xhtml+='<input type="hidden" id="dtp_input2" value="" />';
            xhtml+='</div>';
        }

        $('.data_dinamics').html('<br>'+xhtml);

    });

    /***
     * Evento Click no botao mosgtrar plano
     */

    $('.btn_novo_pl').click(function(){
        $('.pl_registar').show('slow');
    });

    $('#rs_docente').on('click','li', function(){

        var docente = $(this).val();
        $('#rs_docente').hide();
        $('#search_doc').val($(this).text()).css('color','blue');

        /***
         * Trecho de codigo permite buscar disciplinas do docente assosciado a mesma.
         */
        $('#btn_buscar_disciplias').click(function(){
            //var s = $('#a_semestre').val();
            var a = $('#ano_academico').val();
            $.ajax({

                url:"../requestCtr/Processa_plano_avaliacao.php",
                type:"POST",
                data:{acesso:13, docente_id:docente, ano:a},
                success:function(data){

                    $('#rs_docente_disciplinas').show();
                    $('#rs_docente_disciplinas').html(data);
                    /***
                     * Caso encontrar as disciplinas  entao pode se chamar a funcao que carrega o plano de avaliacao
                     */
                    $('#rs_docente_disciplinas li').click(function(){
                        mostrar_plano_avaliacao($(this).val(),s,a,1); // chama a funcao e passa como parametro disp, semestre e ano.
                       mostrar_dados_palno($(this).val(),s,a,1);
                    });
                }
            });

        });
    });

}); //fim documento ready==============================================================================================

/****
 *========================================================== Inicio Funcoes  ======================================================
 */

/***
 * Funcao Registar plano de avaliacao
 */

  function registar_plano(){

    var qtd_av = $('.qtd_avaliacao').val();
    var disp = $('#disciplinapl').val();
    var peso = $('.peso_avaliacao').val();
    var tipo = $('#tipo_av').val();
    var datas_list = $('div #datas_avaliacao');
    var semestre = $('#a_semestre').val();
    var curso = $('#curso_ins').val();
    var ano = $('#ano_academico').val();

    var descricao = $('select#tipo_av > option:selected').html();
    var d = new Date();
    //$('.sv_plano').attr("disabled", true);

    var url='../requestCtr/Processa_plano_avaliacao.php';

    if (disp > 0){
        $.ajax({
            url:url,
            type:"POST",
            data:{
                acesso:1,
                disp:disp,
                peso:peso,
                qtd_av:qtd_av,
                tipo_av:tipo
            },
            success:function(data){
                //$('.lb_avaliacao').html(data);
                var t = 0;
                for (var i =0; i<datas_list.length; i++) {
                    //alert(datas_list[i].value)
                        ++t;
                    regitar_datas_av(datas_list[i].value, descricao+'-'+t);
                }

                mostrar_plano_avaliacao(disp,semestre, d.getFullYear(),1);
                mostrar_dados_palno(disp,semestre,d.getFullYear(),1);
            }
        });
    }else{alert('Seleccionar a disciplina');}
}

/*
 * Funcoes salvar plano e de registo de datas
 *
 * */

function regitar_datas_av(arraydata, descricao){

        //var url='../requestCtr/Processa_plano_avaliacao.php';
        $.ajax({
            url:"../requestCtr/Processa_plano_avaliacao.php",
            type:"POST",
            data:{acesso:2, data_av:arraydata, descricao:descricao},
            success:function(data){
                $('.lb_avaliacao').html(data).css({'color':'blue','font-family':'serif','font-size':'20px'});
            }
        });
}

// mostra disciplina do docente pesquisado
function put_doce_item(item) {

    $('#rs_docente').hide();
    $('#assoc_peso').hide();
    $('#btn_reg_plano').hide();
    $('#notificar_doc').show();

    var campo = $('#rs_docente li');
    for (var i = 0; i< campo.length; i++ ){
        var nodo = campo[i];
        var n_docente = nodo.innerText;

        $('#search_doc').val(n_docente.text()).css('color','blue');
        $('.mostrar_doc').html('Disciplina associadas ao Docente '+nodo.innerText);
    }
    if (item != null){

        var row = "";
        $('#resultados').html('<li data-theme="a"><div class="ui-loader"> <span class="ui-icon ui-icon-loading"></span></div></li>');
        $('#resultados').listview("refresh");

        $.ajax({
            url: 'Processa_docente.php',
            type:  "POST",
            dataType:"json",
            data: {nome:item, acao:7,ctr:0},
            success : function(result){
                row += '<li data-theme="b" class="ui-bar-b">Selecionar Disciplina</li>';

                for (var i=0;  i < result.length; i++){
                    row += '<li value="'+result[i].id+'"onclick="buscar_disp(this.value)" data-theme="a"><a href="#">'+result[i].descricao+'</a></li>';
                }

                $('#resultados').show('slow');
                $('#resultados').html(row);
                $('#resultados').listview( "refresh" );
                $('#resultados').trigger( "updatelayout");
            }
        }); // fim primeiro ajax
    }else{$('#resultados').hide();}
}

/*
 *
 * Metodo autocomplete do docente
 * */
function pl_avaliacao_doc_nome(item) {

    $('#rs_docente').html("");

    if (item.length >= 3) {
        $('#rs_docente').show();
            $.ajax({
                url:"../requestCtr/Processa_plano_avaliacao.php",
                type:"POST",
                data: {texto:item,acesso:8},
                success : function(result){
                    $('#rs_docente').html(result);
                }
            }); // fim primeiro ajax
    }
}

/***
 * Busca disciplinas docente e mostra o plano onclick (function)
 * @param item (Item  eh id da disciplina seleccionada
 */

    function buscar_disp(item) {

    $('#disciplinapl').val(item);

        $('.btn_show_plano').click(function(){
            var semestre = $('#a_semestre').val();
            var ano = $('#ano_academico').val();
            $('.pl_registar').hide();

            mostrar_plano_avaliacao(item,semestre,ano,1);
            mostrar_dados_palno(item,semestre,ano,1);
            //$('#disciplinapl').val(item);

    }); // Fim acao mostrar plano

    //registar_plano(); // so eh executada quando o for clciada

    // funcao notificar docente

    $('#notificar_doc').click(function(){

        $('.dados_notificacao').show();
        $.ajax({
            url:"../requestCtr/Processa_plano_avaliacao.php",
            type:"POST",
            data:{disp:item, acesso:10},
            success:function (result){
                $('.dados_notificacao').html(result);
            }
        })
    });
    // acao do botao enviar email
    $('#send_email').click(function(){
        send_email(item); // metodo enviar email implementado no arquivo javascript
    })
}

/**
* Funcao intermediaria e chamada para mostrar plano em qualquer sessao das paginas
* @param disp
* @param semestre
* @param ano
*/

function show_plano_estudante(disp,semestre,ano,ctr){

    mostrar_plano_avaliacao(disp,semestre,ano,ctr);
    mostrar_dados_palno(disp,semestre,ano,ctr);
}

function mostrar_plano_avaliacao(disp,semestre,ano,ctr){

    $('#iddisciplina').val(disp);
    $.ajax({
        url:"../requestCtr/Processa_plano_avaliacao.php",
        type:"POST",
        data:{disp:disp, ano:ano, semestre:semestre, acesso:7,ctr:ctr},
        success:function (data){

            $('.visualizar_pl').fadeIn('slow');
            $('#table_pl').html(data);
        }
    });
}

function mostrar_dados_palno(disp,semestre,ano,ctr){

    $.ajax({

        url:"../requestCtr/Processa_plano_avaliacao.php",
        type:"POST",
        data:{disp:disp, ano:ano, semestre:semestre, acesso:14,ctr:ctr},
        success:function (data){
            //alert(data);
            $('#tbl_dados').html(data);
        }
    });

}

function edit_plano(item){

    var tipo_av = $('#tipo_av').val();

    $.ajax({
        url:"../requestCtr/Processa_edit_plano.php",
        type:"POST",
        data:{idplano:item,avaliacao:tipo_av, acao:3},
        success:function (data){
            $('.rs_editar_avaliacao').html(data);
        }
    });
}
