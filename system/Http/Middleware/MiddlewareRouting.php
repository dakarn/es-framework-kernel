<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 19:27
 */

namespace Http\Middleware;

use Exception\RoutingException;
use Http\Request\ServerRequest;
use Http\Response\API;
use Http\Response\Text;
use System\Kernel\TypesApp\AbstractApplication;
use System\Registry;
use System\Render;
use System\Router\Routing;
use System\Kernel\GETParam;
use Configs\Config;

class MiddlewareRouting implements MiddlewareInterface
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Http\Response\Response|mixed
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		$router = Routing::findRoute(Config::getRouters(), GETParam::getPath());

		if (!$router->isFilled()) {

			/** @var AbstractApplication $app */
			$app = Registry::get(Registry::APP);

			if ($app->getApplicationType() === AbstractApplication::APP_TYPE['Web']) {
				$outputData = new Text((new Render(Config::get('common', 'errors')['404']))->render());
			} else {
				$outputData = new API([
					'success' => false,
					'error'   => '404 Not Found'
				], [
					'type' => ''
				]);
			}

			$handler
				->getResponse()
				->withBody($outputData)
				->output();

			exit;
		}

		Routing::setFoundRouter($router);

		return $handler->handle($request, $handler);
	}
}