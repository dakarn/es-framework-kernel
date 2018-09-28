<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:57
 */

namespace Middleware;

use Http\Request\RequestInterface;
use Http\Response\Response;

class RequestHandler implements RequestHandlerInterface
{
	private $response;

	public function __construct()
	{
		$this->response = new Response();
	}

	public function getResponse(): Response
	{
		return $this->response;
	}

	public function handle(RequestInterface $request, RequestHandler $handler): Response
	{
		$curr = StorageMiddleware::currPosition();

		if ($curr >= StorageMiddleware::count()) {
			return $this->response;
		}

		$classMiddleware = StorageMiddleware::get()[$curr]['class'];
		StorageMiddleware::nextPosition();

		/** @var MiddlewareInterface $middleware */
		$middleware = new $classMiddleware();
		return $middleware->process($request, $handler);
	}
}