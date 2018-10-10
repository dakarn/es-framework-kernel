<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:57
 */

namespace Http\Middleware;

use Http\Request\ServerRequest;
use Http\Response\Response;

class RequestHandler implements RequestHandlerInterface
{
	/**
	 * @var Response
	 */
	private $response;

	/**
	 * RequestHandler constructor.
	 * @param Response $response
	 */
	public function __construct(Response $response)
	{
		$this->response = $response;
	}

	/**
	 * @return Response
	 */
	public function getResponse(): Response
	{
		return $this->response;
	}

	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return Response
	 * @throws \Exception\MiddlewareException
	 */
	public function handle(ServerRequest $request, RequestHandler $handler): Response
	{
		$curr = StorageMiddleware::current();

		if (StorageMiddleware::isEnd()) {
			return $this->response;
		}

		$classMiddleware = StorageMiddleware::get($curr);
		StorageMiddleware::next();

		/** @var MiddlewareInterface $middleware */
		$middleware = new $classMiddleware();
		return $middleware->process($request, $handler);
	}
}