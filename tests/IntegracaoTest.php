<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/28/2019
 * Time: 2:39 PM
 */
require_once("../view/integracao/functions/FuncoesIntegracao.php");

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
       /**
     * @covers FuncoesIntegracao::listaDeAlunos
     */
    function testListaDeAlunos(){
        $it = new FuncoesIntegracao();        
        $this->assertEquals(21, $it->listaDeAlunos());
    }
   /**
    * @covers FuncoesIntegracao::listaDeDisciplinas
    */

   function testListaDeDisciplinas(){
       $it = new FuncoesIntegracao();
       $this->assertEquals(20, $it->listaDeDisciplinas());

   }
   /**
    * @covers FuncoesIntegracao::listaDeCursos
    */

   function testListaDeCursos(){
       $it = new FuncoesIntegracao();
       $this->assertEquals(6, $it->listaDeCursos());

   }
   /**
    * @covers FuncoesIntegracao::listaDeInscricoes
    */
   function testListaDeInscricoes(){
       $it = new FuncoesIntegracao();
       $this->assertEquals(54, $it->listaDeInscricoes());

   }
   
}