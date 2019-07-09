<?php

use PHPUnit\Framework\TestCase;
use MetaModels\Test\Contao\Database;
require_once './src/controller/EstudanteCtr.php';

class EstudanteControllerTest extends TestCase{
    /**
    * @covers EstudanteController::read
    */
    public function testRead(){
        $ec = new EstudanteController();
        $this->assertEquals(true, $ec->read(1));
       // $this->assertEquals(true, $perc->read(1));
    }
    /**
    * @covers EstudanteController::insert
    */
    public function testInsert(){
        $ec = new EstudanteController();

        $this->assertEquals(false, $esc->insert(-1, 110));
        $this->assertEquals(false, $esc->insert(1, -110));
        $this->assertEquals(true, $esc->insert(1, 110));
    }
     /**
     * @covers EstudanteController::incluir_estudante
     */
    public function testIncluir_estudante(){
        $esc = new EstudanteController();
        // $this->assertEquals(false, $esc->incluir_estudante(221,0,"Nao Participou da avaliacao",0,0, 110));
        //    teste nao realizado nao sabendo a saida esperada da funcao 
                       
    }
     /**
     * @covers EstudanteController::update_inclusao
     */
    public function testUpdate_inclusao(){
        $esc = new EstudanteController();
        $this->assertEquals(false, $esc->update_inclusao(221));
        $this->assertEquals(true, $esc->update_inclusao(13));
                       
    }
     /**
     * @covers EstudanteController::associar_estudante_disp
     */
    public function testAssociar_estudante_disp(){
        $esc = new EstudanteController();
        $this->assertEquals(false, $esc->associar_estudante_disp(221));
        $this->assertEquals(true, $esc->associar_estudante_disp(221));
        
                       
    }
    /**
     * @covers EstudanteController::delete
     */
    public function testDelete(){
        /**
         * impossivel testar o metodo  por causa de query preparada 
         * $query = "DELETE FROM `estudante` WHERE idCurso = ?";
         */
        $esc = new EstudanteController();
        $this->assertEquals(false, $esc->delete(221));
        $this->assertEquals(true, $esc->delete(221));
                       
    }
}