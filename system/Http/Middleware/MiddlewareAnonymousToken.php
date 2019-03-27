<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.2018
 * Time: 21:29
 */

namespace Http\Middleware;

use Configs\Config;
use Helper\Util;
use Http\Cookie;
use Http\Request\ServerRequest;
use Http\Session\SessionRedis;
use System\Auth\JWTokenManager;
use System\Kernel\TypesApp\AbstractApplication;
use System\ES;

class MiddlewareAnonymousToken
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
		$cookie     = Cookie::create()->get(Cookie::JWT);
		$currentApp = ES::get(ES::APP);

		if ($currentApp->getApplicationType() === AbstractApplication::APP_TYPE_AUTH) {
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
		$expire = \time() + Config::get('common', 'TTLAnonymousJWToken');

		$dataToSave = [
			'uniqueId' => Util::generateCookieToken(20),
			'ip'       => ServerRequest::create()->getUserIp(),
			'userId'   => 0,
			'email'    => '',
			'role'     => 0,
			'login'    => '',
			'created'  => \microtime(true),
			'iat'      => \time(),
			'exp'      => $expire,
		];

		$JWTToken = JWTokenManager::create()->setPayload($dataToSave)->createToken();
		$result   = SessionRedis::create()->set($JWTToken->getPartToken(JWTokenManager::SIGN_TOKEN), \json_encode([]), $expire);

		if ($result) {
			Cookie::create()->set(Cookie::JWT, $JWTToken->getToken(), '/', $expire);
		}
	}
}