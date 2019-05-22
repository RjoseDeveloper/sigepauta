<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 2/21/2018
 * Time: 2:31 AM
 */

class AutenticarSQL {

    public function acesso_sistema($username, $password){

        return "SELECT utilizador.id,utilizador.username,previlegio.tipo,
                utilizador.nomeCompleto,previlegio.descricao
                FROM utilizador INNER JOIN previlegio ON
                previlegio.idprevilegio = utilizador.idprevilegio
                WHERE utilizador.username='$username' AND utilizador.password='$password'";
    }

    /****
     * Permite obter nome do docente associado a discplinas
     */

}