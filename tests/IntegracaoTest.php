<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/28/2019
 * Time: 2:39 PM
 */
<<<<<<< HEAD
require_once("../view/integracao/functions/FuncoesIntegracao.php");

use PHPUnit\Framework\TestCase;

class IntegracaoTest extends  TestCase{

   /**
=======
require_once("../view/integracao/FuncoesIntegracao.php");

class IntegracaoTest extends  \PHPUnit\Framework\TestCase{

    /**
>>>>>>> 06289a03d099a331c390c85d09f92bd052470d79
     * @covers FuncoesIntegracao::buscarDadosNoEsiraEstudante
     */
    function testBuscarDadosNoEsiraEstudante(){
        $la = new FuncoesIntegracao();
<<<<<<< HEAD
        $dataBEE= $la->buscarDadosNoEsiraEstudante();

        $this->assertEquals(665, count($dataBEE));
    }
	
	/**
=======
        $data= $la->buscarDadosNoEsiraEstudante();

        $this->assertEquals(665, count($data));
    }
    /**
>>>>>>> 06289a03d099a331c390c85d09f92bd052470d79
     * @covers FuncoesIntegracao::buscarDadosNoEsiraDisciplina
     */
    function testBuscarDadosNoEsiraDisciplina(){
        $la = new FuncoesIntegracao();
<<<<<<< HEAD
        $dataBDE= $la->buscarDadosNoEsiraDisciplina();
        $this->assertEquals(379, count($dataBDE));
    }
	/**
=======
        $data= $la->buscarDadosNoEsiraDisciplina();
        $this->assertEquals(379, count($data));
    }
    /**
>>>>>>> 06289a03d099a331c390c85d09f92bd052470d79
     * @covers FuncoesIntegracao::buscarDadosNoEsiraCurso
     */
    function testBscarDadosNoEsiraCurso(){
        $la = new FuncoesIntegracao();
<<<<<<< HEAD
        $dataBCE= $la->buscarDadosNoEsiraCurso();
        $this->assertEquals(5, count($dataBCE));
    }
	 /**
=======
        $data= $la->buscarDadosNoEsiraCurso();
        $this->assertEquals(5, count($data));
    }
    /**
>>>>>>> 06289a03d099a331c390c85d09f92bd052470d79
     * @covers FuncoesIntegracao::buscarDadosNoEsiraInscricao
     */
    function testBuscarDadosNoEsiraInscricao(){

        $la = new FuncoesIntegracao();
<<<<<<< HEAD
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
   
=======
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

        $this->assertEquals(11, $lc->listaDeCursos());
    }

    /**
     * @covers FuncoesIntegracao::listaDeInscricoes
     */

    function testListaDeInscricoes() {
        $li = new FuncoesIntegracao();

        $this->assertEquals(54, $li->listaDeInscricoes());
    }
>>>>>>> 06289a03d099a331c390c85d09f92bd052470d79
}