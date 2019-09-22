<!--
	Author: W3layouts
	Author URL: http://w3layouts.com
	License: Creative Commons Attribution 3.0 Unported
	License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE html>
<html>

<head>
	<title>SIGE - PAUTAS</title>

	<!--/tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Conceit Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--//tags -->
	<link href="bibliotecas/layout_home/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="bibliotecas/layout_home/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="bibliotecas/layout_home/css/prettyPhoto.css" rel="stylesheet" type="text/css" />
	<link href="bibliotecas/layout_home/css/font-awesome.css" rel="stylesheet">
	<!-- //for bootstrap working -->
	<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,300,300i,400,400i,500,500i,600,600i,700,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,600,600i,700" rel="stylesheet">
	<script src="bibliotecas/jQuery/js/jquery-1.7.1.min.js"></script>
	 
</head>

<body>


<?php
    include 'view/utilizador/form_usuarios.php';
?>

	<div class="top_header" id="home">
		<!-- Fixed navbar -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="nav_top_fx_w3ls_agileinfo">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed"
                            data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					    aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
					<div class="logo-w3layouts-agileits">
						<h1> <a class="navbar-brand" href="#">

                                <i class="fa fa-folder-open" aria-hidden="true"></i>

						SIGPAUTA <span class="desc">Consultas e Publicação de Pautas Academicas</span></a></h1>
					</div>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<div class="nav_right_top">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a  href="#" data-toggle="modal"
                                                   data-target="#_modalogin" data-backdrop="false">ENTRAR</a></li>

						</ul>
						<ul class="nav navbar-nav">
							<li><a class="request" href="#">HOME</a></li>
<!--							<li><a href="#">Sobre o Sistema</a></li>-->
				
							<li><a href="#" class="request" >SIGPAUTA</a></li>
						
						</ul>
					</div>
				</div>
				<!--/.nav-collapse -->
			</div>
		</nav>
	</div>
	<!-- banner -->
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1" class=""></li>
			<li data-target="#myCarousel" data-slide-to="2" class=""></li>
			<!--li data-target="#myCarousel" data-slide-to="3" class=""></li-->
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<div class="container">
					<div class="carousel-caption">
						<h3>SIGPAUTA</h3>
						<p>Sistema Intergrado de Gestão de Pautas</p>
						
					</div>
				</div>
			</div>
			<div class="item item2">
				<div class="container">
					<div class="carousel-caption">
						<h3>VANTAGENS</h3>
						<p>Reduzir o custo administrativo da instituição e<br> garantir acesso à tempo real de informações extrategicas para a tomada de decisão</p>
						
					</div>
				</div>
			</div>
			<div class="item item3">
				<div class="container">
					<div class="carousel-caption">
						<h3>COMO ACEDER ?</h3>
						<p>Para o Estudante, deve estar Matricluado e Inscrito nas Disciplinas Curriculares através do eSIRA.</p>
						
					</div>
				</div>
			</div>
			
		</div>
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="fa fa-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="fa fa-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		<!-- The Modal -->
	</div>
	<!--//banner -->

	<!-- /newsletter-->
	<div class="newsletter_w3ls_agileits">
		<div class="col-sm-6 newsleft">
			<h3>O que é SIG-PAUTA (Sistema Integrado de Gestão de Pautas)</h3>
		</div>
		<div class="col-sm-6 newsright" style="text-align:justify">
		
		O <strong>SIGPAUTA</strong> é um sistema interativo concebido para auxiliar as tarefas inerentes
		as consultas e publicação de resultados academicos, com objectivo de organizar todas as áreas, 
		aspectos e determinantes para que o processo de ensino e aprendizagem ocorra de maneira eficiente.
		
		</div>
        <div class="clearfix"></div>
	</div>
	<!-- //newsletter-->

	<!-- footer -->
	<div class="footer">

        <p class="pull-left">
            <img src="view/fragments/img/lurio-logo.png" width="150" height="150"/>
        </p>
		<div class="footer_inner_info_w3ls_agileits" style="margin-top: -5em">


	
			<p class="copy-right">INSTITUICAO PROPONENTE<br>
                Departamento de Desenvolvimento de Sistema<br>
                 Desenvolvido pelo Data Center &copy 2018 | Website <a href="#">datacente.org</a></p>
		</div>
	</div>
	
	<div class="modal fade" id="_modalogin" tabindex="-1" role="dialog"
       aria-labelledby="mediumModalLabel" aria-hidden="true" data-backdrop="static">

      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h3 class="modal-title" id="modal_credits">AUTENTICAÇÃO</h3>
              </div>
              <div>
                  <div class="modal-body" style="padding: 30px 50px">
                      <div class="result_login alert alert-success">
                          <span class="badge badge-pill badge-success">SIG-PAUTA</span>

                      </div>
                      <hr>

                      <div class="userlogin">
                          <div style="">
                              <label for="name" class="control-label mb-1">Username</label>
                              <input class="form-control" autocomplete="off" name="name" id="name"
                                     value="" data-clear-btn="true" placeholder="Endereço electronico" type="text"><br>
                              <label for="pass" class="control-label mb-1"> Password</label>
                              <input class="form-control" autocomplete="off" name="pass" id="pass" value="" data-clear-btn="true"  placeholder="Palavra passe" type="password">
                          </div>
                          <p style="color:indianred">Não possui conta? <span><a href="#" onclick="open_modal()" data-role="dialog" data-backdrop="false" data-target="#myModal">Registar -se</a></span></p>

                      </div>

                      <div class="modal-footer" style="">
<!--                          <button type="reset" class="btn btn-warning" data-dismiss="modal">Cancelar</button>-->
                          <button type="button" id="btnlogin" onClick="login_online();"  class="btn btn-primary">ENTRAR</button>
                      </div>
                  </div>

              </div>
          </div>
      </div>
  </div>

	</div>
	<!-- //footer -->

	<script type="text/javascript" src="bibliotecas/layout_home/js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="bibliotecas/layout_home/js/bootstrap.js"></script>
	 <script type="text/javascript" src="view/fragments/js/js_function.js"> </script>
  <script type="text/javascript" src="view/fragments/js/js_index.js"></script>

  
	<script>
		$('ul.dropdown-menu li').hover(function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});
	</script>

	<!-- js -->
	<!-- Smooth-Scrolling-JavaScript -->
	<script type="text/javascript" src="bibliotecas/layout_home/js/easing.js"></script>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll, .navbar li a, .footer li a").click(function (event) {
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<!-- //Smooth-Scrolling-JavaScript -->
	<script type="text/javascript">
		function open_modal(){
        $('#_modalogin').modal('hide');
        $('#myModal').modal();

    }

    function callback_login(){
        $('#_modalogin').modal('show');
        $('#myModal').modal('hide');
    }

    $( "#guardar_usuario" ).submit(function( event ) {
        $('#guardar_datos').attr("disabled", true);

        var parametros = $(this).serialize();
        //alert(parametros)
        $.ajax({
            type: "POST",
            url: "view/configAdmin/ajax/nuevo_usuario.php",
            data: parametros,
            beforeSend: function(objeto){
                $("#resultados_ajax").html("Mensagem: Carregando...");
            },
            success: function(datos){
                //alert(datos);
                $("#resultados_ajax").html(datos);
                $('#guardar_datos').attr("disabled", false);
                $(".link_login").html('<a href="#" style="margin-top: -1em" onclick="callback_login()">VOLTAR AO LOGIN</a>');
                $('#name').val($('#user_name').val());
                $('#pass').val($('#user_password_new').val());
                           }
        });
        event.preventDefault();
    })
		
	</script>
	<a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- jQuery-Photo-filter-lightbox-Gallery-plugin -->
	<script type="text/javascript" src="bibliotecas/layout_home/js/jquery-1.7.2.js"></script>
	<script src="bibliotecas/layout_home/js/jquery.quicksand.js" type="text/javascript"></script>
	<script src="bibliotecas/layout_home/js/script.js" type="text/javascript"></script>
	<script src="bibliotecas/layout_home/js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<!-- //jQuery-Photo-filter-lightbox-Gallery-plugin -->

</body>

</html>