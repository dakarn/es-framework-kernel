<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace System\Auth\Authentication;

use App\Models\AuthAppRepository;
use System\Auth\TokenRepository;
use System\Auth\JWTokenManager;
use Helper\Util;
use Http\Cookie;
use Http\Session\SessionRedis;
use Models\User\UserInterface;
use System\Validators\AbstractValidator;
use System\Validators\Validators;
use Traits\SingletonTrait;

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
	 * @var UserInterface
	 */
	private $currentUser;

	/**
	 * @param UserInterface $user
	 * @return Authentication
	 */
	public function setCurrentUser(UserInterface $user): Authentication
	{
		$this->currentUser = $user;

		return $this;
	}

	/**
	 * @return Authentication
	 * @throws \Exception\FileException
	 */
	public function processLogout(): Authentication
	{
		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken(Cookie::create()->get('JWT'));

		$isDelete = SessionRedis::create()->delete($JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN));
		Cookie::create()->remove('JWT');

		if ($isDelete) {
			$this->isLogout = true;
		}

		return $this;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function processUpdateRefreshToken(AbstractValidator $validator, AuthAppRepository $authAppRepository): bool
	{
		$tokenRepos = new TokenRepository();
		$result = $tokenRepos->loadByRefreshToken($validator);

		if (!$tokenRepos->isLoaded()) {
			$validator->setExtraErrorAPI('unknown-refresh', Validators::COMMON);
			return false;
		}

		$tokenRepos->updateRefreshToken($result, $authAppRepository);
		
		return true;
	}

	/**
	 * @param UserInterface $user
	 * @param int $ttl
	 * @return Authentication
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function processAuthentication(UserInterface $user, int $ttl): Authentication
	{
		$JWTokenManager = JWTokenManager::create();

		$dataToSave = [
			'userId'  => $user->getUserId(),
			'email'   => $user->getEmail(),
			'role'    => $user->getRole(),
			'login'   => $user->getLogin(),
			'created' => $user->getCreated(),
			'iat'     => \time(),
			'exp'     => \time() + $ttl,
		];

		$JWTokenManager
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		Cookie::create()->set('JWT', $JWTokenManager->getToken(), '', \time() + 222222, 'es-framework.dev.ru');

		$signToken = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		SessionRedis::create()->set($signToken, \json_encode($dataToSave));
		$result    = (new TokenRepository)->addAccessToken($JWTokenManager);

		if ($result) {
			$this->currentUser   = $user;
			$this->isAuth        = true;
		}

		return $this;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getCreds(): array
	{
		$JWToken = JWTokenManager::create();

		return [
			'accessToken'  => $JWToken->getToken(),
			'refreshToken' => $JWToken->getRefreshToken(),
			'expires_in'   => $JWToken->getProperties()->getExp(),
		];
	}

	/**
	 * @param int $userId
	 * @return Authentication
	 */
	public function authByUserId(int $userId): Authentication
	{
		return $this;
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
	public function isLogout(): bool
	{
		return $this->isLogout;
	}
}