<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 13:58
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Helper\CSRFTokenManager;
use ES\Kernel\Http\Request\ServerRequest;

class MiddlewarePreController
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return \ES\Kernel\Http\Response\Response
     * @throws \ES\Kernel\Exception\FileException
     * @throws \ES\Kernel\Exception\MiddlewareException
     */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		CSRFTokenManager::create()->makeToken();

		return $handler->handle($request, $handler);
	}
}