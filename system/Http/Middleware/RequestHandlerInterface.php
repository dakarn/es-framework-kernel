<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:59
 */

namespace Http\Middleware;

use Http\Request\Request;
use Http\Request\ServerRequest;
use Http\Response\Response;

interface RequestHandlerInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return Response
     */
	public function handle(ServerRequest $request, RequestHandler $handler): Response;
}