<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:28
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Exception\ControllerException;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\Response;
use ES\Kernel\Router\Routing;

class MiddlewareAllowMethod implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return Response
     * @throws ControllerException
     * @throws \ES\Kernel\Exception\MiddlewareException
     */
	public function process(ServerRequest $request, RequestHandler $handler): Response
	{
		$router = Routing::getFoundRouter();

		if (!\in_array($request->getMethod(), $router->getAllow())) {
			throw ControllerException::deniedMethod([$request->getMethod()]);
		}

		if (!empty($router->getMiddleware())) {
			foreach ($router->getMiddleware() as $middleware) {
				StorageMiddleware::addOne(['class' => $middleware]);
			}
		}

		return $handler->handle($request, $handler);
	}
}