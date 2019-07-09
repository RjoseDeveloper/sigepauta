<?php

require_once './src/controller/ActividadeCtr.php';

use PHPUnit\Framework\TestCase;

class ActividadeControllerTest extends TestCase{

    /**
     * @covers MannagerController::create
     */
    public function testCreate(){
        $ac = new MannagerController();
        
        $this->assertEquals('', $ac->create("Inscricao 1 Semestre"));
    }
}