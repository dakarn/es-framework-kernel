<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:16
 */

namespace System\Auth\Authentication\Processes;

use Helper\RepositoryHelper\StorageRepository;
use Http\Request\ServerRequest;
use Http\Session\SessionRedis;
use System\Auth\JWTokenManager;
use System\Auth\TokenRepository;

class LogoutAllDevicesProcess extends FillingPayload implements AuthenticationProcessInterface
{
	/**
	 * @return bool
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function execute(): bool
	{
		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken(ServerRequest::create()->getAccessTokenFromRequest());

		if (!$JWTokenManager->verifyToken()) {
			return false;
		}

		$userId = $JWTokenManager->decode()->getUserId();

		/** @var TokenRepository $tokenRepository */
		$tokenRepository = StorageRepository::getRepository(TokenRepository::class);
		$tokens          = $tokenRepository->loadByUserId($userId);

		$isDeleteRedis = SessionRedis::create()->deleteKeys(\array_column($tokens, 'access'));
		$isDeleteDB    = $tokenRepository->deleteTokensByUserId($userId);

		if ($isDeleteDB && $isDeleteRedis) {
			return true;
		}

		return false;
	}
}