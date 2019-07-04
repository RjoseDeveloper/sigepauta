<?php

chdir(dirname(__DIR__));
define('APPLICATION_ENV', 'test');

// Setup autoloading
require 'init_autoloader.php';
require 'tests/config.php';
$bootstrap = \Zend\Mvc\Application::init(require 'config/application.config.php');
