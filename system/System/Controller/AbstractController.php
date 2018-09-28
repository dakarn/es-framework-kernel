<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 14:55
 */

namespace System\Controller;

use Exception\ControllerException;
use Helper\Cookie;
use Http\Request\Request;
use Http\Response\Response;
use Helper\Session;
use System\AppObjectMemento;
use System\Config;
use System\EventListener\EventManager;
use System\Logger\Logger;
use System\Logger\LoggerAware;
use System\Router\Routing;
use System\Service\ServiceContainer;
use System\Service\ServiceInterface;
use System\Render;
use System\Router\RouteData;

abstract class AbstractController implements ControllerInterface
{
	protected $eventManager;

	protected $response;

	public function __construct(EventManager $eventManager, Response $response)
	{
		$this->eventManager = $eventManager;
		$this->response     = $response;
	}

	protected function redirect(string $url)
	{
		$this->response->redirect($url);
	}

	protected function notFound(): Render
	{
		return new Render(Config::get('common', 'errors')['404']);
	}

	protected function log(string $level, string  $message)
	{
		LoggerAware::setlogger(new Logger())->log($level, $message);
	}

	public function __before(RouteData $route): bool
	{
		return true;
	}

	public function __after(RouteData $route): bool
	{
		return false;
	}

	protected function getUser()
	{

	}

	protected function request(): Request
	{
		return Request::create();
	}

	protected function response($data = null, string $responseType = '', array $param = []): Response
	{
		return $this->response->setData($data, $responseType, $param);
	}

	protected function session(): Session
	{
		return $this->request()->getSession();
	}

	protected function cookie(): Cookie
	{
		return $this->request()->getCookie();
	}

	protected function invokeRouter(string $invokeRouter)
	{
		$routerList = Routing::getRouterList();
		$router     = $routerList->get($invokeRouter);

		if (!empty($router)) {
			$app = AppObjectMemento::get(AppObjectMemento::APP);
			return $app->runController($router);
		}

		throw ControllerException::notFoundController([$invokeRouter]);
	}

	protected function get(string $nameService): ServiceInterface
	{
		return ServiceContainer::create()
			->setServiceConfig(Config::get('service'))
			->addService($nameService)
			->getService($nameService);
	}

	protected function render(string $template, array $param = []): Render
	{
		return new Render($template, $param);
	}

	protected function redirectToRoute(string $routeName, array $arguments = [], int $status = 302): void
	{
		$this->response->redirectToRoute($routeName, $arguments, $status);
	}

	public function __destruct()
	{
	}
}