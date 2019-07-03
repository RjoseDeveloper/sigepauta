<?php

namespace Aiw\PhpUnit;

use Mockery\Matcher\Any;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

abstract class ControllerTestCase extends \PHPUnit_Framework_TestCase
{

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected $mockParamsPlugin;

    const FORWARDED = 'forwarded';

    protected function onCreate()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    abstract protected function disableRealDb($serviceManager);


    protected function setUpController(\Zend\Mvc\Controller\AbstractActionController $controller)
    {

        $config = include 'config/application.config.php';

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        $serviceManager->setAllowOverride(true);

        $this->disableRealDb($serviceManager);

        $this->controller = $controller;
        $this->request = new Request();
        $this->response = new Response();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();

        $this->event->setRequest($this->request)
            ->setResponse($this->response);

        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->setupParamsPlugin();
    }

    function setupParamsPlugin()
    {
        $this->mockParamsPlugin = \Mockery::mock('Zend\Mvc\Controller\Plugin\Params');
        $this->controller->getPluginManager()->setAllowOverride(true);
        $this->controller->getPluginManager()->setService('params', $this->mockParamsPlugin);
        $this->mockParamsPlugin->shouldReceive('setController')->with($this->controller);

        $this->mockParamsPlugin->shouldReceive("__invoke")->zeroOrMoreTimes()->withNoArgs()->andReturn($this->mockParamsPlugin);
    }

    protected function dispatch($actionName)
    {
        $this->routeMatch->setParam('action', $actionName);
        return $this->controller->dispatch($this->request, $this->response);
    }

    public function assertRedirectTo($result, $uri, $message = '')
    {
        $this->assertEquals($this->response, $result, 'response object is returned on redirect');
        $location = $this->response->getHeaders()->get('location');

        if (!$location) {
            $this->fail($message);
        }

        $this->assertSame($uri, $location->getFieldValue(), $message);
    }

}
