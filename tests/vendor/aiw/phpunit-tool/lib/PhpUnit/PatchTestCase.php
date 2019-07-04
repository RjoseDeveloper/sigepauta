<?php

/**
 * Description of PatchTestCase
 *
 * @author AliceIw
 */

namespace Aiw\PhpUnit;

use \Zend\ServiceManager\ServiceManager;
use \Zend\Mvc\Service\ServiceManagerConfig;

abstract class PatchTestCase extends \PHPUnit_Framework_TestCase
{

    protected $patch;
    protected $serviceManager;
    protected $database;

    abstract public function getPatchName();

    abstract public function undoChanges();

    public function getZendTestDbConfig() {
        return [
            'driver' => 'Pdo',
            'dsn' => 'mysql:dbname=' . TEST_DB_NAME . ';host=' . TEST_DB_SERVER,
            'username' => TEST_DB_USERNAME,
            'password' => TEST_DB_PASSWORD,
            'driver_options' => array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
            )];
    }

    function __construct()
    {
        parent::__construct();

        $patchName = $this->getPatchName();

        include_once('patches/' . $patchName . '.php');

        $this->setServiceManager();

        $this->undoChanges();
        $patchName = 'Patch_' . $patchName;
        $this->patch = new $patchName();
        $this->patch->initialise($this->serviceManager);
    }

    protected function setServiceManager()
    {
        $config = include('config/application.config.php');

        $this->serviceManager = new ServiceManager(new ServiceManagerConfig());
        $this->serviceManager->setService('ApplicationConfig', $config);
        $this->serviceManager->get('ModuleManager')->loadModules();
        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('database', $this->getZendTestDbConfig());

        $this->database = $this->getTestDatabaseFacade();
    }
}
