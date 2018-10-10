<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2018
 * Time: 13:58
 */

namespace Http\Middleware;

use Configs\Config;
use Helper\CSRFTokenManager;
use Helper\Util;
use Http\Cookie;
use Http\Request\ServerRequest;
use Http\Session\SessionRedis;
use System\Auth\JWTokenManager;
use System\Kernel\TypesApp\AbstractApplication;
use System\Registry;

class MiddlewarePreController
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
		CSRFTokenManager::create()->makeToken();

		$cookie     = Cookie::create()->get('JWT');
		$currentApp = Registry::get(Registry::APP);

		if ($currentApp->getApplicationType() === AbstractApplication::APP_TYPE['Auth']) {
			return $handler->handle($request, $handler);
		}

		if (empty($cookie)) {
			$this->createAnonymousJWToken();
		}

		return $handler->handle($request, $handler);
	}

	/**
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	private function createAnonymousJWToken()
	{
		$expires = \time() + (int) Config::get('common', 'timeAnonJWToken');

		$dataToSave = [
			'uniqueId' => Util::generateCookieToken(20),
			'ip'       => ServerRequest::create()->getUserIp(),
			'userId'   => 0,
			'email'    => '',
			'role'     => 0,
			'login'    => '',
			'created'  => \microtime(true),
			'iat'      => \time(),
			'exp'      => \time() + $expires,
		];

		$JWTToken = JWTokenManager::create()->setPayload($dataToSave)->createToken();
		$result   = SessionRedis::create()->set($JWTToken->getPartToken(JWTokenManager::SIGN_TOKEN), \json_encode([]), $expires);

		if ($result) {
			Cookie::create()->set('JWT', $JWTToken->getToken(), '', $expires);
		}
	}
}