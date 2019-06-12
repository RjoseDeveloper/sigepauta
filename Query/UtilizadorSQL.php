<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/6/2018
 * Time: 9:07 PM
 */

class UtilizadorSQL {

    public function insert(){
        return 'INSERT INTO `utilizador` (`idsexo`, `username`, `password`, `data_ingresso`, `idprevilegio`, `nomeCompleto`)
               VALUES (?,?,?,now(),?,?)';
    }

    public function list_utilizador(){
    return 'DISTINCT(utilizador.id), utilizador.username, utilizador.nomeCompleto,previlegio.idprevilegio,
                utilizador.email, utilizador.sexo, previlegio.descricao,utilizador.data_ingresso, utilizador.estado
                FROM utilizador inner join  previlegio on utilizador.idprevilegio = previlegio.idprevilegio';
}

}