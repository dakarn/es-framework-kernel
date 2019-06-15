<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 19:27
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Exception\FileException;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\API;
use ES\Kernel\Http\Response\Text;
use ES\Kernel\Kernel\TypesApp\AbstractApplication;
use ES\Kernel\Helper\ES;
use ES\Kernel\Helper\Render;
use ES\Kernel\Router\Routing;
use ES\Kernel\Kernel\GETParam;
use ES\Kernel\Configs\Config;

class MiddlewareRouting implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return \ES\Kernel\Http\Response\Response
     * @throws FileException
     * @throws \ES\Kernel\Exception\KernelException
     * @throws \ES\Kernel\Exception\MiddlewareException
     */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		$router = Routing::findRoute(Config::getRouters(), GETParam::getPath());

		if (!$router->isFilled()) {

			/** @var AbstractApplication $app */
			$app = ES::get(ES::APP);

			if ($app->getApplicationType() === AbstractApplication::APP_TYPE_WEB) {
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