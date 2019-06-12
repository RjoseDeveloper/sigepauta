<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 4/22/2018
 * Time: 1:36 PM
 */

$ano = date('Y');
$semestre = date('m') < 7 ? '1':' 2';

class GestaoPautasSQL {

    public function listAll(){
        return 'SELECT actividade.data_inicio, actividade.data_fim,(actividade.data_fim - CURDATE()) AS restante
from actividade WHERE (actividade.data_fim - CURDATE()) >= 0';
    }

    public function obter_datas($disp, $ctr){
        $semestre = date('m') < 7 ? '1':' 2';

        $query = "SELECT data_avaliacao.descricaoteste as descricao, data_avaliacao.id_data as idTipoAvaliacao
        FROM  data_avaliacao INNER JOIN planoavaliacao ON  planoavaliacao.idplano = data_avaliacao.idplano
        WHERE planoavaliacao.idDisciplina='$disp' AND data_avaliacao.status = 1";

   if ($ctr == 0){$query.= '';}
        return $query;
    }

    public function insert_actividade (){
        return 'INSERT INTO actividade(descricao,data_inicio, data_fim, idutilizador) VALUE (?,?,?,?)';
    }

    function get_director_inst(){
        return "SELECT DISTINCT utilizador.id, utilizador.nomeCompleto FROM utilizador
WHERE idprevilegio > 1;";
    }
    }