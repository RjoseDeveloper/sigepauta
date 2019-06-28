<?php
namespace Aiw\PhpUnit;


abstract class ModuleTestCase extends \PHPUnit_Framework_TestCase
{

    /* @var $serviceManager \Zend\ServiceManager\ServiceManager */
    protected $serviceManager;
    protected $moduleManager;

    function setUp()
    {
        parent::setUp();
        $this->serviceManager = new \Zend\ServiceManager\ServiceManager(new \Zend\Mvc\Service\ServiceManagerConfig());
        $this->serviceManager->setService('ApplicationConfig', include 'config/application.config.php');
        $this->moduleManager = $this->serviceManager->get('ModuleManager');
        $this->setModules();
        $this->moduleManager->loadModules();
        $this->serviceManager->setAllowOverride(true);
    }

    protected function setModules()
    {
        $this->moduleManager->setModules(array($this->getModuleNamespace()));
    }

    protected function getModuleFolder()
    {
        $module = $this->getModule();
        $reflector = new \ReflectionClass($module);
        $filename = $reflector->getFileName();
        return dirname($filename);
    }

    public function test_isEnabledInApplicationConfig()
    {
        $applicationConfig = include('config/application.config.php');
        $this->assertTrue(in_array($this->getModuleNamespace(), $applicationConfig['modules']), 'Module ' . $this->getModuleNamespace() . ' is enabled in application.config.php');
    }

    function test_getAutoloaderConfig()
    {
        $dir = $this->getModuleFolder();
        $nameSpace = $this->getModuleNamespace();
        $module = $this->getModule();
        $config = $module->getAutoloaderConfig();
        $this->assertEquals(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                $dir . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    $nameSpace => $dir . '/src/' . $nameSpace,
                ),
            ),
        ), $config);

    }

    public function test_getConfig()
    {
        $this->assertEquals(include $this->getModuleFolder() . '/config/module.config.php', $this->getModule()->getConfig());
    }

    protected function getFromControllerPluginManager($name)
    {
        return $this->serviceManager->get('ControllerPluginManager')->get($name);
    }

    protected function getFromViewHelperManager($name)
    {
        return $this->serviceManager->get('ViewHelperManager')->get($name);
    }

    protected function getFromControllerLoader($name)
    {
        return $this->serviceManager->get('ControllerLoader')->get($name);
    }

    protected function setDependency($classNameOrMock, $serviceKeyName = false, $serviceManagerKey = false)
    {
        if (!$serviceKeyName) {
            $serviceKeyName = $classNameOrMock;
        }
        if (is_string($classNameOrMock)) {
            $mock = \Mockery::mock($classNameOrMock);
        } else {
            $mock = $classNameOrMock;
        }
        if (!$serviceManagerKey) {
            $this->serviceManager->setService($serviceKeyName, $mock);
        } else {
            $this->serviceManager->get($serviceManagerKey)->setService($serviceKeyName, $mock);
        }
        return $mock;
    }

    protected function assertClass($expectedClass, $testedObject)
    {
        $this->assertEquals($expectedClass, get_class($testedObject));
    }

    abstract protected function getModule();

    abstract protected function getModuleNamespace();

}