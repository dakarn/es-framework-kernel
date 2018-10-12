<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.2018
 * Time: 15:37
 */

namespace Http\Middleware;

use Http\Request\ServerRequest;
use Models\User\User;
use System\Router\Routing;

class MiddlewareGrantAccess
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Http\Response\Response
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		$router = Routing::getFoundRouter();

		if (!empty($router->getAccess())) {

			if (!User::current()->isGranted($router->getAccess())) {

			}
		}

		return $handler->handle($request, $handler);
	}
}