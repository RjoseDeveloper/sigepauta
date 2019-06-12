<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/10/2019
 * Time: 3:32 PM
 */


session_start(); //to ensure you are using same session
session_destroy(); //destroy the sessio
header('location: ../../index.php');

