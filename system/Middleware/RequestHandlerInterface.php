<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:59
 */

namespace Middleware;

use Http\Request\RequestInterface;
use Http\Response\Response;

interface RequestHandlerInterface
{
	public function handle(RequestInterface $request, RequestHandler $handler): Response;
}