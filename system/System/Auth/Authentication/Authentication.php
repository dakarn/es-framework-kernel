<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace System\Auth\Authentication;

use App\Models\AuthAppRepository;
use Http\Request\ServerRequest;
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
	 * @throws \Exception
	 */
	public function processLogout(): Authentication
	{
		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken(ServerRequest::create()->getAccessTokenFromRequest());

		if (!$JWTokenManager->verifyToken()) {
			return $this;
		}

		$signToken     = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		$isDeleteRedis = SessionRedis::create()->delete($signToken);

		$tokenRepos = new TokenRepository();
		$isDeleteDB = $tokenRepos->deleteByAccessToken($signToken);

		if (!empty($isDeleteRedis && $isDeleteDB)) {
			$this->isLogout = true;
		}

		return $this;
	}

	/**
	 * @return Authentication
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function processLogoutAllDevice(): Authentication
	{
		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken(ServerRequest::create()->getAccessTokenFromRequest());

		if (!$JWTokenManager->verifyToken()) {
			return $this;
		}

		$userId = $JWTokenManager->decode()->getUserId();

		$tokenRepos    = new TokenRepository();
		$tokens        = $tokenRepos->loadByUserId($userId);

		$isDeleteRedis = SessionRedis::create()->deleteKeys(\array_column($tokens, 'access'));
		$isDeleteDB    = $tokenRepos->deleteTokensByUserId($userId);
		
		if ($isDeleteDB && $isDeleteRedis) {
			$this->isLogout = true;
		}

		return $this;
	}

	/**
	 * @param AbstractValidator $validator
	 * @param AuthAppRepository $authAppRepository
	 * @return bool
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function processUpdateRefreshToken(AbstractValidator $validator, AuthAppRepository $authAppRepository): bool
	{
		$tokenRepos = new TokenRepository();
		$result = $tokenRepos->loadByRefreshToken($validator);

		if (!$tokenRepos->isLoaded()) {
			$validator->setExtraErrorAPI('unknown-refresh', Validators::COMMON);
			return false;
		}

		$JWToken = JWTokenManager::create();

		$now = Util::now();
		$ttl = $authAppRepository->getResult()->getAccessTTL();

		$user = User::create();
		$user->loadByUserId($tokenModel->getUserId());

		$dataToSave = $this->fillPayload($authAppRepository, $user, $now, $ttl);
		
		$JWToken
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		$tokenRepos->updateRefreshToken($result, $authAppRepository);
		SessionRedis::create()->set($signToken, \json_encode($dataToSave, $ttl));
		
		return true;
	}

	/**
	 * @param UserInterface $user
	 * @param int $ttl
	 * @return Authentication
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function processAuthentication(UserInterface $user, AuthAppRepository $authAppRepository): Authentication
	{
		$JWTokenManager = JWTokenManager::create();

		$now = Util::now();
		$ttl = $authAppRepository->getResult()->getAccessTTL();

		$dataToSave = $this->fillPayload($authAppRepository, $user, $now, $ttl);

		$JWTokenManager
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		$signToken = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		$result    = (new TokenRepository)->addAccessToken($JWTokenManager);

		SessionRedis::create()->set($signToken, \json_encode($dataToSave, $ttl));

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

	/**
	 * @param AuthAppRepository $authAppRepository
	 * @param UserInterface $user
	 * @param int $now
	 * @param int $ttl
	 * @return array
	 */
	private function fillPayload(AuthAppRepository $authAppRepository, UserInterface $user, int $now, int $ttl): array
	{
		return [
			'sub'     => $authAppRepository->getResult()->getType(),
			'iss'     => $authAppRepository->getResult()->getSite(),
			'userId'  => $user->getUserId(),
			'email'   => $user->getEmail(),
			'role'    => $user->getRole(),
			'login'   => $user->getLogin(),
			'created' => $user->getCreated(),
			'iat'     => $now,
			'exp'     => $now + $ttl,
		];
	}
}