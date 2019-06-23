<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace ES\Kernel\Auth\Authorization;

use ES\Kernel\Auth\JWTokenManager;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Traits\SingletonTrait;
use ES\Kernel\Http\Session\SessionRedis;
use ES\Kernel\UserManager\User;

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
	 * @param User $user
	 * @return bool
	 */
	public function isGranted(int $checkRole, User $user): bool
	{
		return $user->getRole() & $checkRole;
	}

	/**
	 * @return Authorization
	 */
	public function verifyAccessByUserId(): AuthorizationInterface
	{
		return $this;
	}
}