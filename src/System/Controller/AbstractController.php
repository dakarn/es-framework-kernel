<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 14:55
 */

namespace ES\Kernel\System\Controller;

use ES\Kernel\Exception\ControllerException;
use ES\Kernel\Helper\Util;
use ES\Kernel\Http\Cookie;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\API;
use ES\Kernel\Http\Response\FormatResponseInterface;
use ES\Kernel\Http\Response\Response;
use ES\Kernel\Http\Session\SessionRedis;
use ES\Kernel\Http\Session\Strategy\RedisStrategy;
use ES\Kernel\System\ES;
use ES\Kernel\Configs\Config;
use ES\Kernel\System\EventListener\EventManager;
use ES\Kernel\System\Logger\Logger;
use ES\Kernel\System\Logger\LoggerAware;
use ES\Kernel\System\Router\Routing;
use ES\Kernel\System\Service\ServiceContainer;
use ES\Kernel\System\Service\ServiceInterface;
use ES\Kernel\System\Render;
use ES\Kernel\System\Router\RouteData;
use ES\Kernel\System\Validators\AbstractValidator;

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
	 * @throws \ES\Kernel\Exception\FileException
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
		LoggerAware::setlogger(Logger::class)->log($level, $message);
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
		$this->setHeaderAPI();

		return $this->response(new API($data, ['type' => 'success']));
	}

	/**
	 * @param array $data
	 * @return Response
	 */
	protected function responseApiBad(array $data): Response
	{
		$this->setHeaderAPI();

		return $this->response(new API($data, ['type' => 'fail']));
	}

	/**
	 * @param string $keyError
	 * @param string $itemError
	 * @return Response
	 * @throws \ES\Kernel\Exception\FileException
	 */
	protected function responseApiBadFormError(string $keyError, string $itemError): Response
	{
		$this->setHeaderAPI();

		$data = [
			'error' => Util::getFormMessage($itemError)[$keyError] ?? ''
		];

		return $this->response(new API($data, ['type' => 'success']));
	}

	/**
	 * @param string $keyError
	 * @param string $itemError
	 * @return Response
	 * @throws \ES\Kernel\Exception\FileException
	 */
	protected function responseApiOKFormMsg(string $keyError, string $itemError): Response
	{
		$this->setHeaderAPI();

		$data = [
			'text' => Util::getFormMessage($itemError)[$keyError] ?? ''
		];

		return $this->response(new API($data, ['type' => 'success']));
	}

	/**
	 * @param AbstractValidator $validator
	 * @param string $keyError
	 * @param $itemError
	 * @return Response
	 * @throws \ES\Kernel\Exception\FileException
	 */
	protected function responseApiBadWithError(AbstractValidator $validator, string $keyError, string $itemError): Response
	{
		$this->setHeaderAPI();

		$validator->setExtraErrorAPI($keyError, $itemError);
		return $this->response(new API($validator->getErrorsApi(), ['type' => 'fail']));
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
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\KernelException
	 */
	protected function invokeRouter(string $invokeRouter)
	{
		$router = Routing::getRouterList()->get($invokeRouter);

		if (!empty($router)) {
			(new LauncherController(
				ES::get(ES::APP),
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
	 * @throws \ES\Kernel\Exception\FileException
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
	 * @throws \ES\Kernel\Exception\FileException
	 */
	protected function render(string $template, array $param = []): Render
	{
		return new Render($template, $param);
	}

	/**
	 * @param string $routeName
	 * @param array $arguments
	 * @param int $status
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\KernelException
	 * @throws \ES\Kernel\Exception\RoutingException
	 */
	protected function redirectToRoute(string $routeName, array $arguments = [], int $status = 302): void
	{
		$this->response->redirectToRoute($routeName, $arguments, $status);
	}

	private function setHeaderAPI()
	{
		$this->response->withHeader('Access-Control-Allow-Origin','*');
		$this->response->withHeader('Content-type','application/json');
	}

	/**
	 *
	 */
	public function __destruct()
	{

	}
}