<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.04.2018
 * Time: 22:33
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\Text;
use ES\Kernel\System\Controller\LauncherController;
use ES\Kernel\System\ES;
use ES\Kernel\System\Render;
use ES\Kernel\System\Router\Routing;

class MiddlewareController implements MiddlewareInterface
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Kernel\Http\Response\Response|mixed
	 * @throws \ES\Kernel\Exception\\KernelException
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
        $launcher = new LauncherController(
            ES::get(ES::APP),
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