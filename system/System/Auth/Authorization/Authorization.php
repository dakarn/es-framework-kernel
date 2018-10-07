<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace System\Auth\Authorization;

use System\Auth\JWTokenManager;
use Http\Cookie;
use Http\Request\ServerRequest;
use Traits\SingletonTrait;

class Authorization
{
	use SingletonTrait;

	private $isAccess = false;

	/**
	 * @throws \Exception\FileException
	 */
	public function verifyAccess()
	{
		$token = $this->getTokenFromRequest();

		if (empty($token)) {
			return;
		}


		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken($token);

		if (!$JWTokenManager->verifyToken($token)) {
			return;
		}

		$this->isAccess = true;
	}

	/**
	 * @return bool
	 */
	public function isAccess(): bool
	{
		return $this->isAccess;
	}

	/**
	 * @param int $checkRole
	 * @param int $userRole
	 * @return bool
	 */
	public function isGranted(int $checkRole, int $userRole): bool
	{
		return $userRole & $checkRole;
	}

	/**
	 * @return Authorization
	 */
	public function verifyAccessByUserId(): Authorization
	{
		return $this;
	}

	/**
	 * @return string
	 */
	private function getTokenFromRequest(): string
	{
		$token = Cookie::create()->get('JWT');

		if (!empty($token)) {
			return $token;
		}

		return ServerRequest::create()->getBearer();
	}
}