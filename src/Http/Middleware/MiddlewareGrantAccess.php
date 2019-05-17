<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.2018
 * Time: 15:37
 */

namespace Http\Middleware;

use Http\Request\ServerRequest;
use Http\Response\API;
use Models\User\User;
use System\Kernel\TypesApp\AbstractApplication;
use System\ES;
use System\Router\Routing;

class MiddlewareGrantAccess
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Http\Response\Response
	 * @throws \Exception\FileException
	 * @throws \Exception
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