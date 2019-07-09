<?php

require_once './src/controller/PautaRecorrenciaCtr.php';

use PHPUnit\Framework\TestCase;



class PautaExameRecorrenciaControllerTest extends TestCase{

/**
 * @covers PautaExameRecorrenciaController::read
 */
    public function testRead(){
        $perc = new PautaExameRecorrenciaController();
        $this->assertEquals(false, $perc->read(-1));
       // $this->assertEquals(true, $perc->read(1));
    }
        
    
    
}


?>