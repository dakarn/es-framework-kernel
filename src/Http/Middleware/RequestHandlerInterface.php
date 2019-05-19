<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:59
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Http\Request\Request;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\Response;

interface RequestHandlerInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return Response
     */
	public function handle(ServerRequest $request, RequestHandler $handler): Response;
}