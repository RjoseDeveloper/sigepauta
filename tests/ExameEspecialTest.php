<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/29/2019
 * Time: 7:10 PM
 */

require_once  './src/view/exames/ExamesEspeciais.php';
use PHPUnit\Framework\TestCase;

class ExameEspecialTest extends TestCase {

    private $fucEe;
    public function __construct(){
        $this->fucEe = new ExamesEspeciais();
        parent::__construct();
    }

    public function testInstanceFuncoesIntragacao(){
        $this->assertInstanceOf(FuncoesIntegracao::class, $this->fucEe);
    }
    /**
     * @covers ExamesEspeciais::result
     */
    function testResult(){
        $ee = new ExamesEspeciais();

        $this->assertTrue(true, $ee->result(" order by idinscricao desc LIMIT 0.4"));
    }
}