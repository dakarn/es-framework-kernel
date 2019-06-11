<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.2018
 * Time: 15:37
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Response\API;
use ES\Kernel\Models\User\User;
use ES\Kernel\Kernel\TypesApp\AbstractApplication;
use ES\Kernel\System\ES;
use ES\Kernel\Router\Routing;

class MiddlewareGrantAccess
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return \ES\Kernel\Http\Response\Response
     * @throws \ES\Kernel\Exception\FileException
     * @throws \ES\Kernel\Exception\KernelException
     * @throws \ES\Kernel\Exception\MiddlewareException
     */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		$router = Routing::getFoundRouter();

		if (!empty($router->getAccess())) {

			if (!User::current()->isGranted($router->getAccess())) {
				
				/** @var AbstractApplication $app */
				$app = ES::get(ES::APP);

				if ($app->getApplicationType() === AbstractApplication::APP_TYPE_WEB) {
					$handler->getResponse()->redirectToRoute('authUser', [], 301);
				} else {
					$handler
						->getResponse()
						->withStatus('401', 'Access Denied')
						->withBody(new API([
							'success' => false,
							'error'   => '401 Access Denied'
						], [
							'type' => ''
						]))
						->output();

					exit;
				}


			}
		}

		return $handler->handle($request, $handler);
	}
}