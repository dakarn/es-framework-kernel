<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:16
 */

namespace ES\Kernel\Auth\Authentication\Processes;

use ES\Kernel\Exception\FileException;
use ES\Kernel\Helper\RepositoryHelper\StorageRepository;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Session\SessionRedis;
use ES\Kernel\Auth\JWTokenManager;

class LogoutProcess extends FillingPayload implements AuthenticationProcessInterface
{
	/**
	 * @return bool
	 * @throws FileException
	 * @throws \Exception
	 */
	public function execute(): bool
	{
		$JWTokenManager = JWTokenManager::create();
		$JWTokenManager->setToken(ServerRequest::create()->getAccessTokenFromRequest());

		if (!$JWTokenManager->verifyToken()) {
			return false;
		}

		$signToken     = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		$isDeleteRedis = SessionRedis::create()->delete($signToken);

		$tokenRepository = StorageRepository::getTokenRepository();
		$isDeleteDB      = $tokenRepository->deleteByAccessToken($signToken);

		if ($isDeleteRedis && $isDeleteDB) {
			return true;
		}

		return false;
	}
}