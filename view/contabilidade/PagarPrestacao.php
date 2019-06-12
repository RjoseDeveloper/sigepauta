<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 1/21/2018
 * Time: 10:45 PM
 */
require_once '../Query/Classes.php';
$db =  new mySQLConnection();
$classes= new Classes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>infossnetwork</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="shortcut icon" href="PUT YOUR FAVICON HERE">-->
    <!-- Google Web Font Embed -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../js/colorbox/colorbox.css"  rel='stylesheet' type='text/css'>
    <link href="../css/templatemo_style.css"  rel='stylesheet' type='text/css'>
    <link href="../css/css_mystyle.css"  rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="../fragments/js/js_script.js"></script>
</head>
<body>
	<h3 class="container" style="color:green;">Emissão de Facturas / Clientes <span class="valor_divida" style="color:red"></span>
	<hr>
	</h3>
	
	<form class="form-inline container">

    <div class="form-group col-xs-5">
	
		<label for="auto_aluno">Pesquisar o aluno:</label>
		<input type="search" onkeyup="do_autocomplete(this.value);" id="auto_aluno" class="form-control"><br>
		
		<ul class="list-group list_divida_frm"></ul>
	    <input type="hidden" id="id_frm" name="id_frm">
	
		<label for="taxa_curso">Taxa do Curso:</label>
		<input type="text" id ="taxa_curso" name="taxa_curso" class="form-control"/><br>
		
		<label for="taxa_paga">Taxa Paga:</label>
		<input type="text" id ="taxa_paga" name="taxa_paga" class="form-control"/>
		
		<label for="taxa_apagar">Taxa a pagar:</label>
		<input type="text" id ="taxa_apagar" name="taxa_apagar" class="form-control">
		<br><br>
		<label>&nbsp;</label>
		<button class="btn btn-warning pull-right" id="btn_pagar_taxa">Efectuar Pagamento</button>

		
	</div>
	
	<div class="control-group col-xs-6">
	
		<label for="curso_c">Seleccionar o curso:</label><br>
		<select class="form-control" data-style="btn-primary" onchange="listar_dividas(this.value)" style="width: auto" id="curso_c" name="curso_c">
			<option value="0">Selecionar um curso</option>
			<?php
			
			$resut = mysqli_query($db->openConection(),'SELECT * FROM curso');
			while ($row = mysqli_fetch_assoc($resut)){ ?>
				<option value="<?php echo $row['idcurso'] ?>"><?php echo utf8_encode($row['descricao']) ?></option>
				
			<?php }  ?>
		</select>
		
	</div>
	
</form>

<!-- container -->

<script src="../js/jquery.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js"  type="text/javascript"></script>
<script src="../js/jquery-1.11.3.js" type="text/javascript"></script>
<script src="../js/jquery-1.11.3.min.js" type="text/javascript"></script>

<script type="text/javascript">
   
   $(document).ready(function (){
	   $('.list_divida_frm').on('click','li', function(){
           $('#id_frm').val($(this).val());
		   $('#auto_aluno').val($(this).text());
		   $('.list_divida_frm').hide();

	   });
   });
   
 function  listar_dividas(item){

	   var curso = $('#curso_c').val();
       var id_frm = $('#id_frm').val();

     alert(id_frm);
		   
		   $.ajax({
				
                url: "../controller/CadastroFormandoCtr.php?acao=10",
                type:"GET",
                data: {formando: id_frm, curso:curso},
                success: function (result) {
                    alert(result)
					$('.valor_divida').html(result[0].diferenca);
				}
		  });
   }

	function do_autocomplete(item){

		$('.list_divida_frm').html("");
		if (item.length >= 3) {
			var row = "";
            $.ajax({
				
                url: "../controller/CadastroFormandoCtr.php?acao=5",
                dataType: "json",
                data: {keyword: item},
                success: function (result) {
					
                    for (var i = 0; i < result.length; i++) {
						row += '<li class="list-group-item" value="' + result[i].idformando + '";">'+result[i].fullname + '</li>';
                    }
					$('.list_divida_frm').show();
					$('.list_divida_frm').html(row);
                }
            }); // fim primeiro ajax
        }
    }
	
	
</script>

</body>
</html>

