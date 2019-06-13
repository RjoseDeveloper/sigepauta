$(document).ready(function(){
    load(1);
});


function load(page){
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'../exames/lista_candidactos_exame.php?action=ajax&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loader').html('<img src="../fragments/img/ajax-loader.gif"> Carregando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}

function enable_desable_status(id) {
    var q= $("#q").val();
    $.ajax({
        type: "GET",
        url:'../exames/actualizar_status_exame.php?action=ajax&id='+id+'&q='+q,
        data: "id="+id,"q":q,
        beforeSend: function(objeto){
            $("#resultados").html("Mensagem: Carregando...");
        },
        success: function(datos){
            $("#resultados").html(datos);
            load(1);
        }
    });
}

//
// function eliminar (id) {
//     var q= $("#q").val();
//
//     if (confirm("Realmente desejas eliminar esta avaliacao")){
//         $.ajax({
//             type: "GET",
//             url: "./ajax/buscar_avaliacao.php",
//             data: "id="+id,"q":q,
//             beforeSend: function(objeto){
//                 $("#resultados").html("Mensagem: Carregando...");
//             },
//             success: function(datos){
//                 $("#resultados").html(datos);
//                 load(1);
//             }
//         });
//     }
// }
//
//
//
//
//
