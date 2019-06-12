<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/7/2019
 * Time: 10:19 AM
 */
namespace MetaModels\Test;

use MetaModels\Test\Contao\Database;

class Test extends  \PHPUnit_Framework_TestCase {

    protected $db;
    public function __construct(){

        $con = new mySQLConnection();
        $this->db = $con->openConection();
    }

    public function getAvaliacao(){
        $resuts = mysqli_query($this->db,"select COUNT * from avaliacao");
        return mysqli_num_rows($resuts);
    }

}
