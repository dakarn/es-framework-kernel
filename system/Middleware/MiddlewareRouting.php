<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 19:27
 */

namespace Middleware;

use Exception\RoutingException;
use Http\Request\RequestInterface;
use System\Router\Routing;
use System\Kernel\GETParam;
use System\Config;

class MiddlewareRouting implements MiddlewareInterface
{
	public function process(RequestInterface $request, RequestHandler $handler)
	{
		$router = Routing::findRoute(Config::getRouters(), GETParam::getPath());

		if (!$router->isFilled()) {
			throw RoutingException::notFound();
		}

		Routing::setFoundRouter($router);

		return $handler->handle($request, $handler);
	}
}