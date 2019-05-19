<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.10.2018
 * Time: 20:14
 */

namespace ES\Kernel\System\Auth;

use ES\Kernel\Configs\Config;
use ES\Kernel\Helper\RepositoryHelper\AbstractRepository;
use ES\Kernel\ObjectMapper\ObjectMapper;
use ES\Kernel\System\Validators\AbstractValidator;

class TokenRepository extends AbstractRepository
{
	/**
	 * @param TokenModel $tokenModel
	 * @return bool
	 * @throws \Exception
	 */
	public function updateRefreshToken(TokenModel $tokenModel): bool
	{
		$JWToken      = JWTokenManager::create();
		$refreshToken = $JWToken->getRefreshToken();

		$result = $this->getStorage()->updateRefreshToken($JWToken, $refreshToken, $tokenModel);

		return $result > 0 ? true : false;
	}

	/**
	 * @param string $token
	 * @return bool
	 * @throws \Exception
	 */
	public function deleteByAccessToken(string $token): bool
	{
		return $this->getStorage()->deleteByAccessToken($token);
	}

	/**
	 * @param int $userId
	 * @return bool
	 * @throws \Exception
	 */
	public function deleteTokensByUserId(int $userId): bool
	{
		return $this->getStorage()->deleteByAccessToken($userId);
	}
	
	/**
	 * @param JWTokenManager $JWTokenManager
	 * @return bool
	 * @throws \Exception
	 */
	public function addAccessToken(JWTokenManager $JWTokenManager): bool
	{
		$token   = $JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN);
		$payload = $JWTokenManager->getProperties();

		$this->getStorage()->addAccessToken($JWTokenManager->getRefreshToken(), $token, $payload);

		return true;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return TokenModel
	 * @throws \Exception
	 */
	public function loadByRefreshToken(AbstractValidator $validator): TokenModel
	{
		$result = $this->getStorage()->loadByRefreshToken($validator);

		if (!empty($result)) {
			$this->isLoaded = true;
		}

		return ObjectMapper::create()->arrayToObject($result, TokenModel::class);
	}

	/**
	 * @param int $userId
	 * @return array
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \Exception
	 */
	public function loadByUserId(int $userId): array
	{
		$maxAuthUserWithDevices = Config::get('common', 'maxAuthUserWithDevices');

		$result = $this->getStorage()->loadByUserId($userId, $maxAuthUserWithDevices);

		if (!empty($result)) {
			$this->isLoaded = true;
		}

		return $result;
	}

	/**
	 * @return TokenStorage
	 */
	private function getStorage(): TokenStorage
	{
		if (!$this->storage instanceof TokenStorage) {
			$this->storage = new TokenStorage();
		}

		return $this->storage;
	}
}