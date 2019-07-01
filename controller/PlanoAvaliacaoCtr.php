<?php

    require_once '../dbconf/getConection.php';

    global $mydb;

   class PlanoAvaliacaoController{

       public function insert($avaliacao,$disp,$qtd, $peso, mySQLConnection $db){

           // $mes recebe 1 se o mes estiver no intervalo de 1 a 6 primeiro semestre, caso contrario recebe 2 segundo semestre

           $semestre= date('m')<=6 ? 1:2;
           $query ='INSERT INTO `planoavaliacao`(`data_registo`,`peso`,`idTipoAvaliacao`,`idDisciplina`)
                                                  VALUES (now(),?,?,?)';

           $stmt = mysqli_prepare($db->openConection(),$query);
           $result = mysqli_stmt_bind_param($stmt,'dii', $peso,$avaliacao, $disp);

           if(mysqli_stmt_execute($stmt)){
               $_last_id = mysqli_stmt_insert_id($stmt);
               $_SESSION['id_plano'] = $_last_id;

                  echo('Plano registado com sucesso!<br>');

               }else{
                   echo('Problemas na insercao do plano!<br>');
             }
       $db->closeDatabase();

       }

       public function insert_data_avaliacao($data_list,$descricao, mySQLConnection $db){

              $q = "INSERT INTO `data_avaliacao`(`dataRealizacao`, `descricaoteste`, `status`,`idplano`) VALUES (?,?,?,?)";
                  $stmt = mysqli_prepare($db->openConection(), $q);
                  $status=1;

                  $result = mysqli_stmt_bind_param($stmt, 'ssii', $data_list, $descricao, $status,$_SESSION['id_plano']);
                  //echo $descricao;

                  if (mysqli_stmt_execute($stmt)) {
                      echo('Plano registado com sucesso!<br>');
                  } else {
                      echo('Problemas na insercao de datas!<br>');
                  }

       }


       public function update_table_plano($avaliacao, $peso, $qtd, mySQLConnection $db)
       {
              $q="UPDATE planoavaliacao SET idTipoAvaliacao = ?, peso =?, qtdMaxAvaliacao = ?
  WHERE idplano = ?";

              $stmt = mysqli_prepare($db->openConection(),$q);
              $result = mysqli_stmt_bind_param($stmt,'iii', $avaliacao, $peso, $qtd);
              if(mysqli_stmt_execute($stmt)){
                  echo('Registado com sucesso!<br>');

               }else{
                   echo('Ocorreu um problema!<br>');
             }
       }

       public function update_data(mySQLConnection $db, $data, $idplano){

           $q = 'UPDATE data_avaliacao SET dataRealizacao = ? WHERE data_avaliacao.idplano ?';
           $stmt = mysqli_prepare($db->openConection(),$q);
           $result = mysqli_stmt_bind_param($stmt,'si', $data, $idplano);
           if(mysqli_stmt_execute($stmt)){
               return true;
           } }
   }
?>
