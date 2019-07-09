<?php
/**
 * Created by IntelliJ IDEA.
 * User: Biemos
 * Date: 7/6/2019
 * Time: 3:58 PM
 */
use PHPUnit\Framework\TestCase;
require_once './src/view/integracao/functions/FuncoesIntegracao.php';

class IntragrationFunctionsTest extends TestCase{

    /**
     * @var FuncoesIntegracao
     */
    private $fucInt;

    /**
     * IntragrationFunctionsTest constructor.
     */
    public function __construct(){
        $this->fucInt = new FuncoesIntegracao();
        parent::__construct();
    }

    public function testInstanceFuncoesIntragacao(){
        $this->assertInstanceOf(FuncoesIntegracao::class, $this->fucInt);
    }

}
