<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/29/2019
 * Time: 7:10 PM
 */

require_once  '../view/exames/ExamesEspeciais.php';

class ExameEspecialTest extends \PHPUnit\Framework\TestCase {

    function testResult(){
        $ee = new ExamesEspeciais();

        $this->assertTrue(true, $ee->result(" order by idinscricao desc LIMIT 0.4"));
    }
}