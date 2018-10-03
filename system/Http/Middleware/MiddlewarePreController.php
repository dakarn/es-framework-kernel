<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 13:58
 */

namespace Http\Middleware;

use Helper\CSRFTokenManager;
use Http\Request\ServerRequest;

class MiddlewarePreController
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Http\Response\Response
	 * @throws \Exception\FileException
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		CSRFTokenManager::create()->makeToken();
		return $handler->handle($request, $handler);
	}
}