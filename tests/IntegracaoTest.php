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
     * @covers FuncoesIntegracao::buscarDadosNoEsiraEstudante
     */
    function testBuscarDadosNoEsiraEstudante(){
        $la = new FuncoesIntegracao();
        $data= $la->buscarDadosNoEsiraEstudante();

        $this->assertEquals(665, count($data));
    }
    /**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraDisciplina
     */
    function testBuscarDadosNoEsiraDisciplina(){
        $la = new FuncoesIntegracao();
        $data= $la->buscarDadosNoEsiraDisciplina();
        $this->assertEquals(379, count($data));
    }
    /**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraCurso
     */
    function testBscarDadosNoEsiraCurso(){
        $la = new FuncoesIntegracao();
        $data= $la->buscarDadosNoEsiraCurso();
        $this->assertEquals(5, count($data));
    }
    /**
     * @covers FuncoesIntegracao::buscarDadosNoEsiraInscricao
     */
    function testBuscarDadosNoEsiraInscricao(){

        $la = new FuncoesIntegracao();
        $data= $la->buscarDadosNoEsiraInscricao();
        $this->assertEquals(15746, count($data));
    }
    /**
     * @covers FuncoesIntegracao::listaDeAlunos
     */
    public  function testListaDeAlunos(){

        $la = new FuncoesIntegracao();
        $data = $la->buscarDadosNoEsiraEstudante();

        $this->assertEquals(21, $la->listaDeAlunos($data));
    }
    /**
     * @covers FuncoesIntegracao::listaDeDisciplinas
     */
    function testListaDeDisciplinas(){
        $ld = new FuncoesIntegracao();
        $data = $ld->buscarDadosNoEsiraDisciplina();

        $this->assertEquals(20, $ld->listaDeDisciplinas($data));
    }
    /**
     * @covers FuncoesIntegracao::listaDeCursos
     */
    function testListaDeCursos(){
        $lc = new FuncoesIntegracao();
        $data = $lc->buscarDadosNoEsiraCurso();

        $this->assertEquals(6, $lc->listaDeCursos($data));
    }
    /**
     * @covers FuncoesIntegracao::listaDeInscricoes
     */
    function testListaDeInscricoes() {
        $li = new FuncoesIntegracao();
        $data = $li->buscarDadosNoEsiraInscricao();

        $this->assertEquals(54, $li->listaDeInscricoes($data));
    }
}