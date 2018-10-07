<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:28
 */

namespace Http\Middleware;

use Exception\ControllerException;
use Http\Request\ServerRequest;
use Http\Response\Response;
use System\Router\Routing;

class MiddlewareAllowMethod implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return Response
     * @throws ControllerException
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