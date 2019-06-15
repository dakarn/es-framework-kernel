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
use ES\Kernel\Controller\LauncherController;
use ES\Kernel\Helper\ES;
use ES\Kernel\Helper\Render;
use ES\Kernel\Router\Routing;

class MiddlewareController implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return \ES\Kernel\Http\Response\Response
     * @throws \ES\Kernel\Exception\ControllerException
     * @throws \ES\Kernel\Exception\FileException
     * @throws \ES\Kernel\Exception\KernelException
     * @throws \ES\Kernel\Exception\MiddlewareException
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