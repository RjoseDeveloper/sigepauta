/**
 * Created by Raimundo Jose on 10/9/2017.
 */

var nr =0,vez =0, tipo, idDisp = 0, ctr=0;
var html = "";

var vetor_nota=[], vetor_nmec=[], vetor_nome=[];

var acesso = 0;
var temp = false;
var t1 = false, t2 = false;

var nome_disp="", nome_curso ="", nome_av="";

$(document).ready(function(e) {

    nome_curso = "";
    nome_av = $('select#txt_avaliacao > option:selected').html();

    if ($('select#select-curso').val()){
        $('.nav_action').html(nome_curso+'/ '+nome_disp+' '+nome_av);
    }

    /*----------------- fim Contolo de navegacao      ------------------------*/
    /*
     * Eventso buscar id, textos de disciplinas, avaliacoes e curso selecionado
     * */

    $('#disciplinas_docente').on('click','li', function(){

        var disp = $(this).val();
        var textos_li = $('.docente_disp li #descricao_curs');
        var IDs_li = $('.docente_disp li #id_curs');

        nome_curso = $(this).text(); temp = false;

        $('.get_estudante').val($(this).val());
        $('.nav_action').html(nome_curso+'/ '+nome_av);

        $.ajax({

            url:"../requestCtr/Processa_docente.php",
            type:"POST",
            data:{disp:disp,acao:11},
            success:function(dados){
                $('#txt_avaliacao').html(dados);
            }
        })
    });

    // evento atribuido ao onChange tipo de Avaliacao carregar o texto

    $("#txt_avaliacao").change(function(){

        nome_av = $('select#txt_avaliacao > option:selected').html();
        $('.nav_action').html(nome_curso+'/ '+nome_av);
        $('#txt_av').val ($(this).val());

        /*
         * Procedimentos buscar lista de estudantes matriculados na disciplina seleccionada
         *
         * */

            var c = $('#id_curso').val();
            var disp = $('.docente_disp li.current').val();
            var av = $(this).val();
            $('.resumo').html(nome_curso+'/ '+nome_av);

            if (c > 0 && disp > 0 && av > 0){


                /*--------------------------------------------------------------------------------------------
                 Faz valiadacao de docente se esta ou nao associado ao curso e disciplina seleccionada
                 */
                $.ajax({
                    url:"../requestCtr/Processa_docente.php",
                    type:"POST",
                    data:{curso:c,disp:disp,acao:9},
                    success: function(rs){
                        var result = parseInt(rs);
                        var curso = $('#descricao_curs').html();
                        if (result == 0){
                            $("#error_model").modal();
                            $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                            'O Docente não esta associado a disciplina\n'+
                            'seleccionada ao curso de '+curso+'</h6>');
                        }else{
                            $('.get_estudante').show('slow'); }
                    }// fim sucesso
                }); // fim ajax;


                /***
                 * cll list of estudnts
                 */
                $.ajax({

                    url : "../requestCtr/Processa_lista_estudante.php",
                    type:  "POST",

                    data: {disp: disp,curso:c, acao:5},
                    success : function(results){
                        $('.table_visualizar').html(results);
                        $('#md_relatorios').modal({backdrop:false}); // abrira um popup model
                        $('.get_estudante').show('slow');

                        /***
                         * Registar dados da pauta normal na sesaao
                         */
                        $.ajax({

                            url: "../requestCtr/Processa_cadastro_pauta.php",
                            type:"POST",
                            data:{disciplina:disp, avaliacao:av, curso:c, acesso:1},

                            success:function (result){
                                console.log('session already created');
                            } //fim success ajax primeiro;
                        }); //Termina primeira requisicao ajax ;
                    }
                });
            }  else{

        $("#error_model").modal();
        $('.ctr_error').html('' +
        '<h6 style="text-align: left; color:red">' +
        'O Registo de Pauta deve ter os seguites Dados:' +
        '<br>[1] - Curso' +
        '<br>[2] - Disciplina e' +
        '<br>[3] - Tipo de Avaliação </h6>\n');

        }

        var html = '';
            }); // fim avaliacao

                  // fim sucesso ajax
            /*----------------------------------------------------------------------------------

             * Insere primeiro a puata normal e depois segue a insercao da nota
             * A insercao da pauta normal eh feita por um requisicao sincrona
             * */

            $('.send_pauta').on('click', function(){

                $('.valida_nota').show();
                $('#enviar_pauta').attr('desabled', true);

                var notas = $('.remove_tr td #nota'); // vetor de notas em javascript
                var nrmec  = $('.remove_tr td #btn_nrmec'); // vetor de numeros mecanograficos
                var id_aluno = $('.remove_tr td #id_aluno'); // vetor aluno

                if (temp === false  && nrmec.length > 0 && notas.length > 0){

                    /***
                     * Registar dados da pauta normal
                     */

                    $.ajax({

                        url: "../requestCtr/Processa_cadastro_pauta.php",
                        type:"POST",
                        data:{acesso:13},
                        success:function (result){
                            console.log(result);

                        } //fim success ajax primeiro;
                    }); //Termina primeira requisicao ajax ;


                    var t = 0, nota_x = "SN";
                    for (var i =0; i< nrmec.length; i++){
                        if (notas[i].value === ""){
                            nota_x = -1;
                        }else{
                            nota_x = notas[i].value;
                        } // fim primeiro if

                        $.ajax({
                            url: "../requestCtr/Processa_cadastro_pauta.php",
                            type:"POST",
                            data:{nota: nota_x,id_aluno:id_aluno[i].value, acesso:2},
                            success: function(dados){

                                $('.valida_nota').html('<h3>Enviada com sucesso total  '+i+'#  estudante(s).</h3>')
                                    .css({'color': 'green','font-size':'17px'}).fadeOut(9000);
                                temp = true;
                            }
                        });
                    } // fim ciclo for*/
                }else{
                    $('.valida_nota').html('Caro docente, a pauta ja foi enviada').css('color','red').fadeOut(6000);
                }
            }); // fim acao
        }); // fim doc


/**
 * Metodos de valiadacao de tipos das quantidades de avaliaca a registar nas disciplinas
 * */
function validarQtdAvaliacao (nr,idDisp) {

    $.ajax({
        url:"../requestCtr/Processa_nota.php",
        type:"POST",
        data:{disp:idDisp, acao:7},
        success: function(result){

            if (result < 3){

                $("#error_model").modal();
                $('.ctr_sms').html("Caro Docente ...");
                $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                'Registe no  minimo 3 tipos de avaliações na disciplina seleccionadao</h6>');

            }else{

                $("#error_model").modal();
                $('.ctr_sms').html("Caro Docente ...");
                $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                'Avaliação de Exame Normal ou de Recorencia deve ser feita<br> uma vez por semestre,'+
                'certifique se que ainda nao teve registado</h6>');
            }
        } // fim sucesso ajax
    });
}

// controla insercao de registos

function validar_nota(item){

    if (item < 0 || item > 20){

        alert('Inserir nota no intervalo de [0 a 20]','Caro Docente!');
        return;
    }
}


$(document).ready(function() {

    $('select#getAvaliacao').on('change', function (event){
        tipoavaliacao = $(this).val();
        $.ajax({

            url:"../requestCtr/Processa_edit_avaliacao.php",
            data:({idNota:tipoavaliacao, acao:1}),
            type:"POST",
            success: function(result){

                $('#btnSave').show();
                $('#a_nota').show();
                $('#a_nota').val(result);

            },

            error: function(){
                alert ('Nao foi possivel registar!','Atenção');
            }
        })
        //return false;
    })

    /*--------------------Busca estdante na insersaco de notas ------------------------*/

    $('#pesquisar_estkkkkk').keyup(function() {

        var min_length = 3;
        var keyword = $(this).val();
        $('#resultado').html("");

        var disp = $('.docente_disp li.current').val();
        var c =  $('select#select-curso').val();

        var disp = sessionStorage.getItem('disp');

        if (keyword.length >= min_length) {

            $('#resultado').html('<li data-theme="b"><div class="ui-loader"><span class="ui-icon ui-icon-loading"></span></div></li>');
            $('#resultado').listview("refresh");

            var row = "";
            $.ajax({

                url : "../requestCtr/Processa_lista_estudante.php",
                type:  "POST",
                dataType:"json",

                data: {keyword:keyword,curso:c, acao:4, disp:disp, ctr:1},
                success : function(result){

                    if (result.length > 0){

                        for (var i=0;  i < result.length ; i++){
                            row += '<li value="'+result[i].nrmec+'" onClick="put_est_item(this.value);"' +
                            ' data-theme="b"><a>'+result[i].nome +' '+result[i].apelido + '</a></li>';
                        }
                    }else{
                        row +='Nao foi encontrado';
                    }

                    $('#resultado').show();
                    $('#resultado').html(row);
                    $('#resultado').listview( "refresh" );
                    $('#resultado').trigger( "updatelayout");

                }
            })
        }
    });

});

function obter_estudante_lista(){

    var c = $('select#select-curso').val();
    var disp = $('.docente_disp li.current').val();
    var av = $('select#txt_avaliacao').val();
    if (c > 0 && disp > 0 && av > 0){

        $('.resumo').html(nome_curso+'/ '+nome_disp+'/ '+nome_av);

        var html = '';
        $.ajax({

            url : "../requestCtr/Processa_lista_estudante.php",
            type:  "POST",
            //dataType : "json",
            data: {disp: disp,curso:c, acao:5},

            success : function(result){
                $('.table_visualizar').html(result);
                $('#md_relatorios').modal({backdrop: false}); // abre um popup model
            }
        });

    }else{

        $("#error_model").modal();
        $('.ctr_error').html('' +
        '<h6 style="text-align: left; color:red">' +
        'O Registo de Pauta deve Conter os seguites Dados:' +
        '<br>[1] - Curso' +
        '<br>[2] - Disciplina e' +
        '<br>[3] - Tipo de Avaliação </h6>\n');

    }

    /*--------------------------------------------------------------------------------------------
     Faz valiadacao de docente se esta ou nao associado ao curso e disciplina seleccionada
     * */

    $.ajax({

        url:"../requestCtr/Processa_docente.php",
        type:"POST",
        data:{curso:c,disp:disp,acao:9},
        success: function(rs){
            var result = parseInt(rs);

            var curso = $('#select-curso > option:selected').html();
            if (result == 0){

                $("#error_model").modal();
                $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                'O Docente não esta associado a disciplina\n'+
                'seleccionada ao curso de '+curso+'</h6>');

            }else{

                $('.get_estudante').show('slow');
            }

        }// fim sucesso
    }); // fim ajax;

    $.ajax({

        url:"../requestCtr/Processa_nota.php",
        type:"POST",

        data:{tipo:av, disp:disp,curso:c, acao:6},

        success: function(dados){

            if (av >= 4){

                $.ajax({

                    url:"../requestCtr/Processa_nota.php",
                    type :"POST",
                    data:{tipo:av,disp:disp, acao:8, ctr:1},
                    success: function (rs){

                        var result = parseInt(rs);
                        if (av == 4 ){
                            if (result == 1){

                                $("#error_model").modal();
                                $('.ctr_sms').html("Caro Docente ...");
                                $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                                'O Exame Normal ja foi registado e não deve ser Repetido</h6>');

                            }else{validarQtdAvaliacao(nr, item);}
                        }

                        if (tp == 5){if (result == 1){

                            $("#error_model").modal();
                            $('.ctr_sms').html("Caro Docente ...");
                            $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                            'O Exame de Recorrencia ja foi registado e não deve ser Repetido</h6>');

                        }else{

                            $.ajax({
                                url:"../requestCtr/Processa_nota.php",
                                type :"POST",
                                data:{tipo:av, disp:disp, acao:8, ctr:2},
                                success: function (rs){

                                    $('.nome_e').html(rs);
                                    var rt = parseInt(rs);

                                    if (rt == 0 && result == 1){

                                        $("#error_model").modal();

                                        $('.ctr_sms').html("Caro Docente ...");
                                        $('.ctr_error').html('<h6 style="text-align: left; color:red">' +
                                        'Deve registar primeiro a Avaliação do Exame Normal</h6>');

                                    }else{

                                        $('.get_estudante').show('slow');
                                        $('.cl_back').hide();
                                    }
                                }// end sucess function
                            })}}
                    } //end sucess
                })

            }
        }  // fim sucesso ajax

    }); // fim requisicao a
}