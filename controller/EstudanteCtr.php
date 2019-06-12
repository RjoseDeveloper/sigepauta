<?php



class EstudanteController {

    private $db;

    public function __construct(){
        $this->db = new mySQLConnection();
    }

    public function read($id){
   
        if ($this->db){
            $query= "SELECT * FROM `estudante` WHERE idEstudante ={$id}";
            $result_set = mysqli_query($this->db->openConection(),$query);
            $found = mysqli_fetch_assoc($result_set);
            return($found);
        }else{
            return(false);
        }

    
    }

    public function insert($util,$nrest){

   
        $query ="INSERT INTO `estudante`(`idUtilizador`, `nrEstudante`) VALUES (?,?)";

        if ($stmt = mysqli_prepare($this->db->openConection(),$query)){
            $result = mysqli_stmt_bind_param($stmt,'iss',$util,$nrest);

            if(mysqli_stmt_execute($stmt)){
                echo('Estudante inserido com sucesso!');
            }else{
                echo('problemas na insercao!');
            }
        }
    }

    public function incluir_estudante($nr_mec,$nota,$comentario,$estado, $idpauta, $avaliacao){

        $q="INSERT INTO `estudante_inclusao`(`nr_estudante`, `nota`, `comentario`, `estado`,`idpauta`,`avaliacao`, `data_reg`) VALUES (?,?,?,?,?,?,now())";
        $stmt = mysqli_prepare($this->db->openConection(),$q);
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

        $stmt = mysqli_prepare($this->db->openConection(),$q);
        mysqli_stmt_bind_param($stmt,'i',$idpauta);
        mysqli_stmt_execute($stmt);
    
    }

    public function associar_estudante_disp($curso, $disp, $aluno)
    {
        $query ="INSERT INTO `estudante_disciplina`(`idestudante`, `iddisciplina`, `idcurso`, `dataReg`) VALUES (?,?,?,now())" ;

   

        $stmt = mysqli_prepare($this->db->openConection(),$query);
        mysqli_stmt_bind_param($stmt,'iii',$aluno,$disp,$curso);

        if(mysqli_stmt_execute($stmt)){
            echo('Estudante sssociado com sucesso!');
        }else{
            echo('Problemas na insercao!');
        }
    
    }

    public function update($object){
   
    }

    public function delete($id){

   

        $query = "DELETE FROM `estudante` WHERE idCurso = ?";
        if ($stmt = mysqli_prepare($this->db->openConection(),$query)){
            $result = mysqli_stmt_bind_param($stmt,'i',$id);

            if(mysqli_stmt_execute($stmt)){
                echo('removido com sucesso!');
            }else{
                echo('problemas na remocao!');
            }
        
        }

    }

    public function selectAll(){

   
        $query= "SELECT * FROM `estudante`";
        if ($this->db){
            $result_set = mysqli_query($this->db->openConection(),$query);
        }
        return($result_set);

    }
}

?>