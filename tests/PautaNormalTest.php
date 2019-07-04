<?php
use PHPUnit\Framework\TestCase;
require_once '../controller/PautaNormalCtr.php';

class PautaNormalTest extends TestCase{


    /**
     * @covers  PautaNormalController::read
     */
    public function testRead(){
        
       $pnc = new PautaNormalController(); 
       $expeted = array('idPautaNormal' => '1','idcurso' => '30','idDisciplina' => '15','idTipoAvaliacao' => '1',
    'estado' => '1','dataReg' => '2019-04-07','dataPub' => '2019-06-19','idsemestre' => '1','idusers' => '3' );   
       $this->assertEquals(false, $pnc->read(-1));
       $this->assertEquals($expeted, $pnc->read(1)); 
    }
    /**
     * @covers  PautaNormalController::insert
     */
    public function testInsert(){
        $pnc = new PautaNormalController();     
        $this->assertEquals(false, $pnc->insert(-1, -1, -1));
        $this->assertEquals(null, $pnc->insert(1, 1, 1));
    }
    /**
     * @covers  PautaNormalController::update
     */
    public function testUpdate(){
        $pnc = new PautaNormalController();     
        $this->assertEquals(false, $pnc->update(-1, -1));
        $this->assertEquals('', $pnc->update(1, 1));
    }
    /**
     * @covers  PautaNormalController::delete
     */
    public function testDelete(){ 
        
        $pnc = new PautaNormalController();     
        $this->assertEquals(false, $pnc->delete(-1));
        $this->assertEquals('', $pnc->delete(7));
    }
    /**
     * @covers  PautaNormalController::getMaxRowValue
     */
    public function testGetMaxRowValue(){
        $pnc = new PautaNormalController();     
        $this->assertEquals(7, $pnc->getMaxRowValue());

    }
}