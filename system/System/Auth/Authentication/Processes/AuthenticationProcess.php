<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:17
 */

namespace System\Auth\Authentication\Processes;

use Helper\RepositoryHelper\StorageRepository;
use Helper\Util;
use Http\Session\SessionRedis;
use Models\User\UserInterface;
use System\Auth\ClientAppRepository;
use System\Auth\JWTokenManager;
use System\Auth\TokenRepository;

class AuthenticationProcess extends FillingPayload implements AuthenticationProcessInterface
{
	/**
	 * @var UserInterface
	 */
	private $user;

	/**
	 * AuthenticationProcess constructor.
	 * @param UserInterface $user
	 */
	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * @return bool
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function execute(): bool
	{
		/** @var TokenRepository $tokenRepository */
		$tokenRepository   = StorageRepository::getRepository(TokenRepository::class);
		/** @var ClientAppRepository $clientAppRepository */
		$clientAppRepository = StorageRepository::getRepository(ClientAppRepository::class);

		$JWTokenManager = JWTokenManager::create();

		$now = Util::now();
		$ttl = $clientAppRepository->getResult()->getAccessTTL();

		$dataToSave = $this->fillPayload($clientAppRepository, $this->user, $now, $ttl);

		$JWTokenManager
			->setPayload($dataToSave)
			->setRefreshToken(Util::createRefreshToken())
			->createToken();

		$signToken = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		$result    = $tokenRepository->addAccessToken($JWTokenManager);

		SessionRedis::create()->set($signToken, \json_encode($dataToSave, $ttl));

		if ($result) {
			return true;
		}

		return false;
	}
}