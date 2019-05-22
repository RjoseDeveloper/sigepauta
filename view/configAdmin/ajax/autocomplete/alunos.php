<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$row_array = array();
/* If connection to database, run sql statement. */
if ($con)
{
	$sql ="SELECT aluno.idaluno, utilizador.nomeCompleto, utilizador.email, utilizador.celular
FROM aluno INNER JOIN utilizador ON utilizador.id = aluno.idutilizador";

	$fetch = mysqli_query($con,"$sql where utilizador.nomeCompleto like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,3");

	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {

		//$row_array['value'] = $row['username'];
		$row_array['id_aluno']=$row['idaluno'];
		$row_array['nomeCompleto']=$row['nomeCompleto'];
		$row_array['celular']=$row['celular'];
		$row_array['email']=$row['email'];
		//array_push($return_arr,$row_array);
    }

    echo json_encode($row_array);
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */


}
?>