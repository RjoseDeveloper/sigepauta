<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/7/2018
 * Time: 7:24 AM
 */

interface Factory {

    public function create($sql,UtilizadorMDL $u, mySQLConnection $db);
    public function read($_id, mySQLConnection $db);
    public function update($sql,UtilizadorMDL $u, mySQLConnection $db);
    public function delete($_id, mySQLConnection $db);
    public function listall(mySQLConnection $db);

}