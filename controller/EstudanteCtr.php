<?php

require_once '../functions/Conexao.php';

class EstudanteController {

    public function read($id){
        $db = new mySQLConnection();
        if ($db){
            $query= "SELECT * FROM `estudante` WHERE idEstudante ={$id}";
            $result_set = mysqli_query($db->openConection(),$query);
            $found = mysqli_fetch_assoc($result_set);
            return($found);
        }else{
            return(false);
        }

        $db->closeDatabase();
    }

    public function insert($util,$nrest){

        $db = new mySQLConnection();
        $query ="INSERT INTO `estudante`(`idUtilizador`, `nrEstudante`) VALUES (?,?)";

        if ($stmt = mysqli_prepare($db->openConection(),$query)){
            $result = mysqli_stmt_bind_param($stmt,'iss',$util,$nrest);

            if(mysqli_stmt_execute($stmt)){
                echo('Estudante inserido com sucesso!');
            }else{
                echo('problemas na insercao!');
            }
            $db->closeDatabase();

        }
    }

    public function incluir_estudante($nr_mec,$nota,$comentario,$estado, $idpauta, $avaliacao){

        $q="INSERT INTO `estudante_inclusao`(`nr_estudante`, `nota`, `comentario`, `estado`,`idpauta`,`avaliacao`, `data_reg`) VALUES (?,?,?,?,?,?,now())";

        $db = new mySQLConnection();
        $stmt = mysqli_prepare($db->openConection(),$q);
        mysqli_stmt_bind_param($stmt,'sdsiis',$nr_mec,$nota,$comentario,$estado, $idpauta, $avaliacao);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_execute($stmt)){
            echo('Estudante incluido com sucesso!');

        }else{
            echo('Problemas na inclusao!');
        }
    }

    public function update_inclusao($idpauta){

        $q= 'UPDATE estudante_inclusao SET estado = 2 WHERE idpauta= ?';
        $db = new mySQLConnection();

        $stmt = mysqli_prepare($db->openConection(),$q);
        mysqli_stmt_bind_param($stmt,'i',$idpauta);
        mysqli_stmt_execute($stmt);
        $db->closeDatabase();
    }

    public function associar_estudante_disp($curso, $disp, $aluno)
    {
        $query ="INSERT INTO `estudante_disciplina`(`idestudante`, `iddisciplina`, `idcurso`, `dataReg`) VALUES (?,?,?,now())" ;

        $db = new mySQLConnection();

        $stmt = mysqli_prepare($db->openConection(),$query);
        mysqli_stmt_bind_param($stmt,'iii',$aluno,$disp,$curso);

        if(mysqli_stmt_execute($stmt)){
            echo('Estudante sssociado com sucesso!');
        }else{
            echo('Problemas na insercao!');
        }
        $db->closeDatabase();
    }

    public function update($object){
        $db = new mySQLConnection();
    }

    public function delete($id){

        $db = new mySQLConnection();

        $query = "DELETE FROM `estudante` WHERE idCurso = ?";
        if ($stmt = mysqli_prepare($db->openConection(),$query)){
            $result = mysqli_stmt_bind_param($stmt,'i',$id);

            if(mysqli_stmt_execute($stmt)){
                echo('removido com sucesso!');
            }else{
                echo('problemas na remocao!');
            }
            $db->closeDatabase();
        }

    }

    public function selectAll(){

        $db = new mySQLConnection();
        $query= "SELECT * FROM `estudante`";
        if ($db){
            $result_set = mysqli_query($db->openConection(),$query);
        }
        return($result_set);

    }
}

?>