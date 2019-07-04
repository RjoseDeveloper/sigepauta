<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/29/2019
 * Time: 7:10 PM
 */

require_once  '../view/exames/ExamesEspeciais.php';

class ExameEspecialTest extends \PHPUnit\Framework\TestCase {
<<<<<<< HEAD

=======
    /**
     * @covers ExamesEspeciais::result
     */
>>>>>>> 06289a03d099a331c390c85d09f92bd052470d79
    function testResult(){
        $ee = new ExamesEspeciais();

        $this->assertTrue(true, $ee->result(" order by idinscricao desc LIMIT 0.4"));
    }
}