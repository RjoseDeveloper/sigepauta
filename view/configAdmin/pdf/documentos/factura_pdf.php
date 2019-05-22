<?php
	/*-------------------------
	Autor: rjose
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");

    require_once("../../../QuerySql/ContabilidadeSQL.php");
    $contas = new ContabilidadeSQL();
	//Archivo de funciones PHP
	include("../../funciones.php");
	$session_id= $_GET['id_aluno'];
	$sql_count=mysqli_query($con,"select * from prestacao where idaluno='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Não Existe Pagamentos Associados a Factura')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente=intval($_GET['id_aluno']);
	$id_vendedor=intval($_SESSION[id]);
	//$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));

	//Fin de variables por GET
	$sql=mysqli_query($con, "select LAST_INSERT_ID(idaluno) as last from prestacao order by idaluno desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero_factura=$rw['last']+1;	
	$simbolo_moneda="mzn";
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/factura_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
