<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/28/2019
 * Time: 2:39 PM
 */
require_once("../view/integracao/FuncoesIntegracao.php");

class IntegracaoTest extends  \PHPUnit\Framework\TestCase{


    /**
     * @covers FuncoesIntegracao::listaDeAlunos
     */
    public  function testListaDeAlunos(){
        $la = new FuncoesIntegracao();
        $data = $la->buscarDadosNoEsiraEstudante();

        $this->assertEquals(21, $la->listaDeAlunos($data));
    }
}