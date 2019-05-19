<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace ES\Kernel\System\Auth\Authorization;

use ES\Kernel\System\Auth\Authentication\Authentication;
use ES\Kernel\System\Auth\JWTokenManager;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Traits\SingletonTrait;
use ES\Kernel\Http\Session\SessionRedis;

class Authorization implements AuthorizationInterface
{
	use SingletonTrait;

	private $isAccess = false;

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function verifyAccess(): AuthorizationInterface
	{
		$token = ServerRequest::create()->getAccessTokenFromRequest();

		if (empty($token)) {
			return $this;
		}

		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken($token);
		
		if (!$JWTokenManager->verifyToken($token)) {
			return $this;
		}

		$token = SessionRedis::create()->get($JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN));

		if (!$token) {
			return $this;
		}

		if ($JWTokenManager->getProperties()->getUserId() === 0) {
			return $this;
		}

		$this->isAccess = true;

		return $this;
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
	public function verifyAccessByUserId(): AuthorizationInterface
	{
		return $this;
	}
}