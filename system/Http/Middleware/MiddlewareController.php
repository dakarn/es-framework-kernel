<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 22:33
 */

namespace Http\Middleware;

use Http\Request\ServerRequest;
use Http\Response\Text;
use System\Controller\LauncherController;
use System\Registry;
use System\Render;
use System\Router\Routing;

class MiddlewareController implements MiddlewareInterface
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Http\Response\Response|mixed
	 * @throws \Exception\ControllerException
	 * @throws \Exception\FileException
	 * @throws \Exception\KernelException
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
        $launcher = new LauncherController(
            Registry::get(Registry::APP),
            Routing::getFoundRouter(),
            $request,
            $handler->getResponse()
        );

        $result = $launcher->execute();

        if ($result instanceof Render) {
            $handler->getResponse()->withBody(new Text($result->render()));
        }

        return $handler->handle($request, $handler);
	}
}