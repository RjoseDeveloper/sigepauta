<?php

require_once './src/controller/ActividadeCtr.php';

use PHPUnit\Framework\TestCase;

/**
 * Class ActividadeControllerTest
 */
class ActividadeControllerTest extends TestCase{

    /**
     * @var MannagerController
     */
    private $ac;

    /**
     * ActividadeControllerTest constructor.
     */
    function __construct(){
        $this->ac = new MannagerController();
        parent::__construct();
    }

    /**
     * @covers ActividadeControllerTest::__construct
     */
    function testConstruct(){

    }
    /**
     * @covers MannagerController::create
     */
    public function testCreate(){
        $this->assertEquals('Encontramos problemas ao Criar a actividade', $this->ac->create("Inscricao 1 Semestre"));
    }
}
