<?php

require_once './src/controller/CursoCtr.php';
use PHPUnit\Framework\TestCase;

class CursoControllerTest extends TestCase{

 /**
  * @covers CursoController::insert
  */
    public function testInsert(){
        $cc = new CursoController();
        
         $this->assertEquals(false, $cc->insert(-1, '', -1, -1));
         $this->assertEquals(false, $cc->insert( 1, "LEI", -1, -1));
         $this->assertEquals(false, $cc->insert( 1, "LEI", 1, -1));
        // $this->assertEquals(true, $cc->insert( 1, "INFOSS.NET", 1, 1));
        
    }
    
     
}


?>