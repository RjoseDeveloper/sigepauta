<?php

require_once '../controller/PautaRecorrenciaCtr.php';
require_once '../dbconf/db.php';
require_once '../dbconf/conexion.php';
require_once '../dbconf/getConection.php';

use PHPUnit\Framework\TestCase;
use MetaModels\Test\Contao\Database;


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