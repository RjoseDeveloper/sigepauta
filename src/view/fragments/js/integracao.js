function loadInscricoes(page){

    var q= $("#q").val();

    $("#loaderi").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoInscricao.php?action=ajax&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loaderi').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loaderi').html('');
        }
    })
}

function loadCursos(page){
    var q= $("#q").val();

    $("#loaderc").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoCursos.php?action=ajax&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loaderc').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loaderc').html('');
        }
    })
}

function loadDisciplinas(page){

    var q= $("#q").val();

    $("#loaderd").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoDisciplina.php?action=ajax&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loaderd').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loaderd').html('');
        }
    })
}


function loadAlunos(page){

    var q= $("#q").val();

    $("#loadere").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoEstudante.php?action=ajax&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loadere').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loadere').html('');
        }
    })
}

function botaoInscricoes(page){

    var q= $("#q").val();

    $("#loaderi").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoInscricao.php?action=aja&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loaderi').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loaderi').html('');
        }
    })
}

function botaoCursos(page){
    var q= $("#q").val();

    $("#loaderc").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoCursos.php?action=aja&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loaderc').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loaderc').html('');
        }
    })
}

function botaoAlunos(page){

    var q= $("#q").val();

    $("#loadere").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoEstudante.php?action=aja&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loadere').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loadere').html('');
        }
    })
}

function botaoDisciplinas(page){

    var q= $("#q").val();

    $("#loaderd").fadeIn('slow');
    $.ajax({
        url:'../integracao/integracaoDisciplina.php?action=aja&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loaderd').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loaderd').html('');
        }
    })
}