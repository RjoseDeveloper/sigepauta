<?php
namespace Aiw\PhpUnit;

abstract class RoutingTestCase extends \PHPUnit_Framework_TestCase
{

    protected $routeConfig = array();

    /**
     * @var Zend\Http\PhpEnvironment\Request
     */
    protected $request;

    /**
     * @var Zend\EventManager\EventManager
     */
    protected $events;

    /**
     * @var Zend\Mvc\Router\Http\TreeRouteStack
     */
    protected $router;


    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->routeConfig = $this->getRouterConfig();
    }


    protected function getRouterConfig()
    {
        $serviceManager = new \Zend\ServiceManager\ServiceManager(new \Zend\Mvc\Service\ServiceManagerConfig(array()));
        $serviceManager->setService('ApplicationConfig', include 'config/application.config.php');
        $serviceManager->get('ModuleManager')->loadModules();
        return $serviceManager->get('Config')['router']['routes'];
    }

    public function setUp()
    {
        parent::setUp();
        $this->request = new \Zend\Http\PhpEnvironment\Request();
        $this->events = new \Zend\EventManager\EventManager();
        $this->router = new \Zend\Mvc\Router\Http\TreeRouteStack();

        foreach ($this->routeConfig as $name => $route) {
            $this->router->addRoute($name, $route);
        }

        $this->events->attach(new \Zend\Mvc\RouteListener());
        $this->events->attach(new \Zend\Mvc\ModuleRouteListener(), -1);

    }

    function dispatch($uri)
    {
        $this->request->setUri($uri);
        $event = new \Zend\Mvc\MvcEvent();
        $event->setRouter($this->router);
        $event->setRequest($this->request);

        $this->events->trigger('route', $event);
        $this->routeMatch = $event->getRouteMatch();
    }


    /**
     * Asserts that the most recent dispatch arrived at the specified action.
     * adapted from https://github.com/mmoussa/zf2test/blob/master/module/ZF2Test/src/ZF2Test/PHPUnit/ControllerTestCase.php
     *
     * @param  string $action The action.
     * @param  string $message (Optional) The message to output on failure.
     */
    public function assertAction($action, $message = '')
    {
        $actualAction = !empty($this->routeMatch)
            ? $this->routeMatch->getParam('action')
            : null;
        $this->assertSame($action, $actualAction, $message);
    }

    /**
     * Asserts that the most recent dispatch arrived at the specified controller.
     * adapted from https://github.com/mmoussa/zf2test/blob/master/module/ZF2Test/src/ZF2Test/PHPUnit/ControllerTestCase.php
     *
     * @param  string $controller The controller.
     * @param  string $message (Optional) The message to output on failure.
     */
    public function assertController($controller, $message = '')
    {
        $actualController = !empty($this->routeMatch)
            ? $this->routeMatch->getParam('controller')
            : null;
        $this->assertSame($controller, $actualController, $message);
    }


}