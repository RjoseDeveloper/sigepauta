<?php

use PHPUnit\Framework\TestCase;
require_once './src/controller/DocenteCtr.php';

class DocenteControllerTest extends TestCase{
    
    /**
     * @covers  DocenteController::read
     */
    public function testRead(){
       $dc = new DocenteController();     
       $this->assertEquals(false, $dc->read(-1)); 
    }

    /**
         * @covers DocenteController::insert_docente
     */
    public function testInsert_docente(){
        $dc = new DocenteController();     
        $this->assertEquals(false, $dc ->insert_docente("",-1 ,-1));
        $this->assertEquals(false, $dc ->insert_docente("Informatica" ,-1, -1));
        $this->assertEquals(false, $dc ->insert_docente("informatica" ,1, -1));
        $this->assertEquals(false, $dc ->insert_docente("informatica" ,1, 1));
       
    }
}