<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace System\Auth\Authorization;

use System\Auth\JWTokenManager;
use Http\Request\ServerRequest;
use Traits\SingletonTrait;
use Http\Session\SessionRedis;

class Authorization implements AuthorizationInterface
{
	use SingletonTrait;

	private $isAccess = false;

	/**
	 * @throws \Exception\FileException
	 */
	public function verifyAccess()
	{
		$token = ServerRequest::create()->getAccessTokenFromRequest();

		if (empty($token)) {
			return;
		}

		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken($token);
		
		if (!$JWTokenManager->verifyToken($token)) {
			return;
		}

		$token = SessionRedis::create()->get($JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN));

		if (!$token) {
			return;
		}

		if ($JWTokenManager->getProperties()->getUserId() === 0) {
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
}