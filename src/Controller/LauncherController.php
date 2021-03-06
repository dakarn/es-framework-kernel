<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 19.04.2018
 * Time: 9:26
 */

namespace ES\Kernel\Controller;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\Response;
use ES\Kernel\EventListener\EventManager;
use ES\Kernel\Kernel\GETParam;
use ES\Kernel\EventListener\EventTypes;
use ES\Kernel\Kernel\TypesApp\AbstractApplication;
use ES\Kernel\Helper\Render;
use ES\Kernel\Router\RouteData;
use ES\Kernel\Router\Router;
use ES\Kernel\Exception\ControllerException;

class LauncherController implements LauncherControllerInterface
{
	/**
	 * @var string
	 */
	const APP = 'ES\\App\\';

    const PREFIX_ACTION = 'Action';

    /**
     * @var ServerRequest
     */
    private $request;

    /**
     * @var AbstractController
     */
    private $controller;

	/**
	 * @var string
	 */
    private $className;

	/**
	 * @var string
	 */
    private $action;

    /**
     * @var Render|Response
     */
    private $resultAction;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Router
     */
    private $router;

	/**
	 * @return Response|Render
	 * @throws ControllerException
	 */
    public function execute()
    {
        $this->prepare();
        $this->runController();

        return $this->resultAction;
    }

	/**
	 * LauncherController constructor.
	 * @param AbstractApplication $webApp
	 * @param Router $router
	 * @param ServerRequest $request
	 * @param Response $response
	 */
    public function __construct(AbstractApplication $webApp, Router $router, ServerRequest $request, Response $response)
    {
        $this->request      = $request;
        $this->eventManager = $webApp->getEventApp();
        $this->response     = $response;
        $this->router       = $router;
    }

	/**
	 * @return void
	 */
    private function prepare(): void
    {
        $this->className = self::APP . \str_replace(':', '\\', $this->router->getController());
        $this->action    = $this->router->getAction() . self::PREFIX_ACTION;
    }

	/**
	 * @throws ControllerException
	 */
    private function runController(): void
    {
        $routeData  = $this->setRouteData($this->action, $this->router);

        $this->eventManager->runEvent(EventTypes::BEFORE_CONTROLLER, [
            'controller' => $routeData->getControllerName(),
            'action'     => $routeData->getActionName(),
        ]);

        /** @var AbstractController $controller */
        $this->controller = new $this->className($this->eventManager, $this->response, $this->request);

        if (!$this->controller->__before($routeData)) {
            throw ControllerException::beforeReturnFalse();
        }

        $this->runAction($this->controller, $this->action);

        $this->controller->__after($routeData);
        $this->eventManager->runEvent(EventTypes::AFTER_CONTROLLER);
    }

	/**
	 * @param ControllerInterface $controller
	 * @param string $action
	 * @throws ControllerException
	 */
    private function runAction(ControllerInterface $controller, string $action)
    {
        if (!\method_exists($controller, $action)) {
            throw ControllerException::notFoundController([$action]);
        }

        $this->eventManager->runEvent(EventTypes::BEFORE_ACTION);
        $this->resultAction = \call_user_func_array([$controller, $action], array_values(GETParam::getParamForController()));
        $this->eventManager->runEvent(EventTypes::AFTER_ACTION);
    }

	/**
	 * @param string $action
	 * @param Router $router
	 * @return RouteData
	 */
    private function setRouteData(string $action, Router $router): RouteData
    {
        $routeData  = (new RouteData())
            ->setData('action', $action)
            ->setData('controller', \substr($router->getController(), \strrpos($router->getController(), ':') + 1));

        return $routeData;
    }
}