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
use System\Router\Routing;
use System\Kernel\GETParam;
use Configs\Config;

class MiddlewareRouting implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return \Http\Response\Response
     * @throws RoutingException
     */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		$router = Routing::findRoute(Config::getRouters(), GETParam::getPath());

		if (!$router->isFilled()) {
			throw RoutingException::notFound();
		}

		Routing::setFoundRouter($router);

		return $handler->handle($request, $handler);
	}
}