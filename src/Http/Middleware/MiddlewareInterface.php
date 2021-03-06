<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2018
 * Time: 0:00
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Http\Request\ServerRequest;

interface MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return mixed
     */
	public function process(ServerRequest $request, RequestHandler $handler);
}