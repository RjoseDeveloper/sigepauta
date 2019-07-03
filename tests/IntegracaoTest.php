<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/28/2019
 * Time: 2:39 PM
 */
require_once("../view/integracao/FuncoesIntegracao.php");

use PHPUnit\Framework\TestCase;

class IntegracaoTest extends  TestCase{

   /**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraEstudante
     */
    function testBuscarDadosNoEsiraEstudante(){
        $la = new FuncoesIntegracao();
        $dataBEE= $la->buscarDadosNoEsiraEstudante();

        $this->assertEquals(665, count($dataBEE));
    }
	
	/**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraDisciplina
     */
    function testBuscarDadosNoEsiraDisciplina(){
        $la = new FuncoesIntegracao();
        $dataBDE= $la->buscarDadosNoEsiraDisciplina();
        $this->assertEquals(379, count($dataBDE));
    }
	/**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraCurso
     */
    function testBscarDadosNoEsiraCurso(){
        $la = new FuncoesIntegracao();
        $dataBCE= $la->buscarDadosNoEsiraCurso();
        $this->assertEquals(5, count($dataBCE));
    }
	 /**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraInscricao
     */
    function testBuscarDadosNoEsiraInscricao(){

        $la = new FuncoesIntegracao();
        $dataBIE= $la->buscarDadosNoEsiraInscricao();
        $this->assertEquals(15746, count($dataBIE));
    }
   
}