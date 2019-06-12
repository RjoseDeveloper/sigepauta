<?php

require_once '../dbconf/getConection.php';
class DisciplinaSQL
{

    public function read($id, mySQLConnection $db)
    {

        $query = "SELECT * FROM `disciplina` WHERE idDisciplina ={$id}";
        $result_set = mysqli_query($db->openConection(), $query);
        $found = mysqli_fetch_assoc($result_set);
        return ($found);
    }

    // insere nova disciplina
    public function insert($nivel, $cred, $nomed, $cod, mySQLConnection $db)
    {

        $query = "INSERT INTO `disciplina`(`ano`, `creditos`, `descricao`, `codigo`) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($db->openConection(), $query);
        $result = mysqli_stmt_bind_param($stmt, 'iisi', $nivel, $cred, $nomed, $cod);

        if (mysqli_stmt_execute($stmt)) {
            echo('Disciplina inserida com sucesso!<br>');
        } else {
            echo('problemas na insercao!<br>');
        }
        $db->closeDatabase();
    }

    public function delete($id, mySQLConnection $db)
    {

        $query = "DELETE FROM `curso` WHERE idCurso = ?";
        if ($stmt = mysqli_prepare($db->openConection(), $query)) {
            $result = mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                echo('removido com sucesso!');
            } else {
                echo('problemas na remocao!');
            }
            $db->closeDatabase();
        }
    }

    public function selectAll($idcurso, $ctr)
    {
        if ($ctr== 1){
            return "SELECT * FROM disciplina WHERE disciplina.idcurso='$idcurso'";
        }else{
            return "SELECT * FROM sessao WHERE sessao.idcurso='$idcurso'";
        }



    }
}
