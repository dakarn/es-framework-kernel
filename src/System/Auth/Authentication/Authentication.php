<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace ES\Kernel\System\Auth\Authentication;

use ES\Kernel\System\Auth\Authentication\Processes\AuthByUserIdProcess;
use ES\Kernel\System\Auth\Authentication\Processes\AuthenticationProcess;
use ES\Kernel\System\Auth\Authentication\Processes\LogoutAllDevicesProcess;
use ES\Kernel\System\Auth\Authentication\Processes\LogoutProcess;
use ES\Kernel\System\Auth\Authentication\Processes\UpdateRefreshTokenProcess;
use ES\Kernel\System\Auth\JWTokenManager;
use ES\Kernel\Models\User\UserInterface;
use ES\Kernel\System\Validators\AbstractValidator;
use ES\Kernel\Traits\SingletonTrait;

class Authentication implements AuthenticationInterface
{
	use SingletonTrait;

	/**
	 * @var bool
	 */
	private $isAuth = false;

	/**
	 * @var bool
	 */
	private $isLogout = false;

	/**
	 * @var bool 
	 */
	private $isUpdate = false;

	/**
	 * @var UserInterface
	 */
	private $currentUser;

	/**
	 * @param UserInterface $user
	 * @return Authentication
	 */
	public function setCurrentUser(UserInterface $user): AuthenticationInterface
	{
		$this->currentUser = $user;

		return $this;
	}

	/**
	 * @return Authentication
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \Exception
	 */
	public function processLogout(): AuthenticationInterface
	{
		$logoutProcess  = new LogoutProcess();
		$this->isLogout = $logoutProcess->execute();

		return $this;
	}

	/**
	 * @return Authentication
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \Exception
	 */
	public function processLogoutAllDevice(): AuthenticationInterface
	{
		$logoutProcess  = new LogoutAllDevicesProcess();
		$this->isLogout = $logoutProcess->execute();

		return $this;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return null|Authentication
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \Exception
	 */
	public function processUpdateRefreshToken(AbstractValidator $validator):? AuthenticationInterface
	{
		$logoutProcess  = new UpdateRefreshTokenProcess($validator);
		$this->isUpdate = $logoutProcess->execute();
		
		return $this;
	}

	/**
	 * @param UserInterface $user
	 * @return Authentication
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \Exception
	 */
	public function processAuthentication(UserInterface $user): AuthenticationInterface
	{
		$logoutProcess  = new AuthenticationProcess($user);
		$this->isAuth   = $logoutProcess->execute();

		if ($this->isAuth) {
			$this->currentUser = $user;
		}

		return $this;
	}

	/**
	 * @param UserInterface $user
	 * @return Authentication
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function processAuthByUserId(UserInterface $user): AuthenticationInterface
	{
		$logoutProcess  = new AuthByUserIdProcess($user);
		$this->isAuth   = $logoutProcess->execute();

		return $this;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getCredentials(): array
	{
		$JWToken = JWTokenManager::create();

		return [
			'accessToken'  => $JWToken->getToken(),
			'refreshToken' => $JWToken->getRefreshToken(),
			'expires_in'   => $JWToken->getProperties()->getExp(),
		];
	}

	/**
	 * @return bool
	 */
	public function isAuth(): bool
	{
		return $this->isAuth;
	}

	/**
	 * @return bool
	 */
	public function isUpdate(): bool
	{
		return $this->isUpdate;
	}
	
	/**
	 * @return bool
	 */
	public function isLogout(): bool
	{
		return $this->isLogout;
	}
}