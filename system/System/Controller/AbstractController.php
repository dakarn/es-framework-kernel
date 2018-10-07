<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 14:55
 */

namespace System\Controller;

use Exception\ControllerException;
use Http\Cookie;
use Http\Request\ServerRequest;
use Http\Response\API;
use Http\Response\FormatResponseInterface;
use Http\Response\Response;
use Http\Session\SessionRedis;
use Http\Session\Strategy\RedisStrategy;
use System\Registry;
use Configs\Config;
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
	/**
	 * @var EventManager
	 */
	protected $eventManager;

	/**
	 * @var Response
	 */
	protected $response;

    /**
     * @var ServerRequest
     */

	protected $request;

    /**
     * AbstractController constructor.
     * @param EventManager $eventManager
     * @param Response $response
     * @param ServerRequest $request
     */
	public function __construct(EventManager $eventManager, Response $response, ServerRequest $request)
	{
	    $this->request      = $request;
		$this->eventManager = $eventManager;
		$this->response     = $response;
	}

	/**
	 * @param string $url
	 */
	protected function redirect(string $url)
	{
		$this->response->redirect($url);
	}

	/**
	 * @return Render
	 * @throws \Exception\FileException
	 */
	protected function notFound(): Render
	{
		return new Render(Config::get('common', 'errors')['404']);
	}

	/**
	 * @param string $level
	 * @param string $message
	 */
	protected function log(string $level, string  $message)
	{
		LoggerAware::setlogger(new Logger())->log($level, $message);
	}

	/**
	 * @param RouteData $route
	 * @return bool
	 */
	public function __before(RouteData $route): bool
	{
		return true;
	}

	/**
	 * @param RouteData $route
	 * @return bool
	 */
	public function __after(RouteData $route): bool
	{
		return false;
	}

	/**
	 * @return ServerRequest
	 */
	protected function request(): ServerRequest
	{
		return $this->request;
	}

	/**
	 * @param FormatResponseInterface $formatted
	 * @return Response
	 */
	protected function response(FormatResponseInterface $formatted): Response
	{
		return $this->response->withBody($formatted);
	}

	/**
	 * @param array $data
	 * @return Response
	 */
	protected function responseApiOK(array $data): Response
	{
		$this->response->withHeader('Access-Control-Allow-Origin','*');
		return $this->response(new API($data, ['type' => 'success']));
	}

	/**
	 * @param array $data
	 * @return Response
	 */
	protected function responseApiBad(array $data): Response
	{
		$this->response->withHeader('Access-Control-Allow-Origin','*');
		return $this->response(new API($data, ['type' => 'fail']));
	}

	/**
	 * @return RedisStrategy
	 */
	protected function session(): RedisStrategy
	{
		return SessionRedis::create();
	}

	/**
	 * @return Cookie
	 */
	protected function cookie(): Cookie
	{
		return Cookie::create();
	}

	/**
	 * @param string $invokeRouter
	 * @throws ControllerException
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 */
	protected function invokeRouter(string $invokeRouter)
	{
		$router = Routing::getRouterList()->get($invokeRouter);

		if (!empty($router)) {
			(new LauncherController(
				Registry::get(Registry::APP),
				$router,
				$this->request,
				$this->response
			))->execute();
		}

		throw ControllerException::notFoundController([$invokeRouter]);
	}

	/**
	 * @param string $nameService
	 * @return ServiceInterface
	 * @throws \Exception\FileException
	 */
	protected function get(string $nameService): ServiceInterface
	{
		return ServiceContainer::create()
			->setServiceConfig(Config::get('service'))
			->add($nameService)
			->get($nameService);
	}

	/**
	 * @param string $template
	 * @param array $param
	 * @return Render
	 * @throws \Exception\FileException
	 */
	protected function render(string $template, array $param = []): Render
	{
		return new Render($template, $param);
	}

	/**
	 * @param string $routeName
	 * @param array $arguments
	 * @param int $status
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 * @throws \Exception\RoutingException
	 */
	protected function redirectToRoute(string $routeName, array $arguments = [], int $status = 302): void
	{
		$this->response->redirectToRoute($routeName, $arguments, $status);
	}

	/**
	 *
	 */
	public function __destruct()
	{

	}
}