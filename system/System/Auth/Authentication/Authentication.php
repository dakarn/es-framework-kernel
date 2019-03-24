<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 21:38
 */

namespace System\Auth\Authentication;

use System\Auth\ClientAppRepository;
use Helper\RepositoryHelper\StorageRepository;
use Http\Request\ServerRequest;
use Models\User\User;
use System\Auth\TokenRepository;
use System\Auth\JWTokenManager;
use Helper\Util;
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

		/** @var TokenRepository $tokenRepository */
		$tokenRepository = StorageRepository::getRepository(TokenRepository::class);
		$isDeleteDB      = $tokenRepository->deleteByAccessToken($signToken);

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

		/** @var TokenRepository $tokenRepository */
		$tokenRepository = StorageRepository::getRepository(TokenRepository::class);
		$tokens          = $tokenRepository->loadByUserId($userId);

		$isDeleteRedis = SessionRedis::create()->deleteKeys(\array_column($tokens, 'access'));
		$isDeleteDB    = $tokenRepository->deleteTokensByUserId($userId);
		
		if ($isDeleteDB && $isDeleteRedis) {
			$this->isLogout = true;
		}

		return $this;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return null|Authentication
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function processUpdateRefreshToken(AbstractValidator $validator):? Authentication
	{
		/** @var TokenRepository $tokenRepository */
		$tokenRepository   = StorageRepository::getRepository(TokenRepository::class);
		$tokenModel        = $tokenRepository->loadByRefreshToken($validator);

		/** @var ClientAppRepository $clientAppRepository */
		$clientAppRepository = StorageRepository::getRepository(ClientAppRepository::class);

		if (!$tokenRepository->isLoaded()) {
			$validator->setExtraErrorAPI('unknown-refresh', Validators::COMMON);
			return null;
		}

		$JWToken = JWTokenManager::create();

		$now = Util::now();
		$ttl = $clientAppRepository->getResult()->getAccessTTL();

		$user = User::loadByUserId($tokenModel->getUserId());

		$dataToSave = $this->fillPayload($clientAppRepository, $user, $now, $ttl);
		
		$JWToken
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		$tokenRepository->updateRefreshToken($tokenModel);
		SessionRedis::create()->set($JWToken->getToken(), \json_encode($dataToSave, $ttl));

		$this->isUpdate = true;
		
		return $this;
	}

	/**
	 * @param UserInterface $user
	 * @param int $ttl
	 * @return Authentication
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function processAuthentication(UserInterface $user): Authentication
	{
		/** @var TokenRepository $tokenRepository */
		$tokenRepository   = StorageRepository::getRepository(TokenRepository::class);
		/** @var ClientAppRepository $clientAppRepository */
		$clientAppRepository = StorageRepository::getRepository(ClientAppRepository::class);

		$JWTokenManager = JWTokenManager::create();

		$now = Util::now();
		$ttl = $clientAppRepository->getResult()->getAccessTTL();

		$dataToSave = $this->fillPayload($clientAppRepository, $user, $now, $ttl);

		$JWTokenManager
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		$signToken = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		$result    = $tokenRepository->addAccessToken($JWTokenManager);

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

	/**
	 * @param ClientAppRepository $authAppRepository
	 * @param UserInterface $user
	 * @param int $now
	 * @param int $ttl
	 * @return array
	 */
	private function fillPayload(ClientAppRepository $authAppRepository, UserInterface $user, int $now, int $ttl): array
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