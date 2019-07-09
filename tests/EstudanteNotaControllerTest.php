<?php 
use PHPUnit\Framework\TestCase;
require_once './src/controller/EstudanteNotaCtr.php';

class EstudanteNotaControllerTest extends TestCase{
    
    /**
     * @covers  EstudanteNotaController::insertF1
     */
    public function testInsertF1()
    {
        $enc = new EstudanteNotaController();     
        $this->assertEquals(false, $enc->insertF1(-1, -1, -1));
        $this->assertEquals('', $enc->insertF1(1, 1, 1));
        
    }

    /**
     * @covers  EstudanteNotaController::read
     */
    public function testRead()
    {
       $enc = new EstudanteNotaController();     
       $this->assertEquals(false, $enc->read(-1)); 
       $this->assertEquals('', $enc->read(11));
    }
    
    /**
     * @covers  EstudanteNotaController::update
     */
    public function testUpdate(){
        $enc = new EstudanteNotaController(); 
        $this->assertEquals('', $enc->update(1, 1));
        $this->assertEquals(false, $enc->update(-1, -1));
    }
    /**
     * @covers  EstudanteNotaController::delete
     */
    public function testDelete(){
        $enc = new EstudanteNotaController();
        $this->assertEquals('', $enc->delete(1));
        $this->assertEquals(false, $enc->delete(-1));
    }
     
 }