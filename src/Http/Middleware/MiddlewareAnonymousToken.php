<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.2018
 * Time: 21:29
 */

namespace ES\Kernel\Http\Middleware;

use ES\Kernel\Configs\Config;
use ES\Kernel\Helper\Util;
use ES\Kernel\Http\Cookie;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Session\SessionRedis;
use ES\Kernel\System\Auth\JWTokenManager;
use ES\Kernel\System\Kernel\TypesApp\AbstractApplication;
use ES\Kernel\System\ES;

class MiddlewareAnonymousToken
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \Kernel\Http\Response\Response
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\KernelException
	 * @throws \ES\Kernel\Exception\MiddlewareException
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
	 * @throws \ES\Kernel\Exception\FileException
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