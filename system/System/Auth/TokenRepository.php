<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.10.2018
 * Time: 20:14
 */

namespace System\Auth;

use App\Models\AuthAppRepository;
use Configs\Config;
use Helper\Util;
use Models\User\User;
use System\Database\DB;
use System\Validators\AbstractValidator;

class TokenRepository
{
	/**
	 * @var bool
	 */
	private $isLoaded = false;

	/**
	 * @param TokenModel $tokenModel
	 * @return bool
	 * @throws \Exception
	 */
	public function updateRefreshToken(TokenModel $tokenModel, AuthAppRepository $authAppRepository): bool
	{
		$JWToken      = JWTokenManager::create();
		$refreshToken = $JWToken->getRefreshToken();
		$now          = Util::now();
		
		$result = DB::MySQLAdapter()->update('
			UPDATE 
				access_tokens 
			SET
				refresh = "' . $refreshToken . '",
				access = "' . $JWToken->getPartToken(JWTokenManager::SIGN_TOKEN) . '",
				expire = "' . $JWToken->getProperties()->getExpAsDT() . '",
				created = "' . Util::toDbTime() . '"
			WHERE 
				refresh = "' . $tokenModel->getRefresh() . '"
		');

		return $result > 0 ? true : false;
	}

	/**
	 * @param string $token
	 * @return bool
	 * @throws \Exception
	 */
	public function deleteByAccessToken(string $token): bool
	{
		DB::MySQLAdapter()->delete('
			DELETE
			FROM 
				access_tokens
			WHERE
				access = "' . $token  . '"
		');

		return true;
	}

	/**
	 * @param int $userId
	 * @return bool
	 * @throws \Exception
	 */
	public function deleteTokensByUserId(int $userId): bool
	{
		DB::MySQLAdapter()->delete('
			DELETE
			FROM 
				access_tokens
			WHERE
				userId = "' . $userId  . '"
		');

		return true;
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
		
		DB::MySQLAdapter()->insert('
			INSERT INTO access_tokens
			(
				access, 
				refresh, 
				userId, 
				created,
				expire
			)
			VALUES (
				"' . $token . '",
			    "' . $JWTokenManager->getRefreshToken() . '", 
			    "' . $payload->getUserId() . '",  
			    "' . Util::toDbTime() . '",
			    "' . $payload->getExpAsDT() . '")
		');

		return true;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return TokenModel
	 * @throws \Exception
	 */
	public function loadByRefreshToken(AbstractValidator $validator): TokenModel
	{
		$result = DB::MySQLAdapter()->fetchRow('
			SELECT 
				*
			FROM 
				access_tokens
			WHERE 
				refresh = "' . $validator->getValueField('refreshToken') . '"
			LIMIT 1
		');

		if (!empty($result)) {
			$this->isLoaded = true;
		}

		return new TokenModel($result);
	}

	/**
	 * @return bool
	 */
	public function isLoaded(): bool
	{
		return $this->isLoaded;
	}

	public function loadByAccessToken(string $token): TokenRepository
	{
		return $this;
	}

	/**
	 * @param int $userId
	 * @return array
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function loadByUserId(int $userId): array
	{
		$maxAuthUserWithDevices = Config::get('common', 'maxAuthUserWithDevices');

		$result = DB::MySQLAdapter()->fetch('
			SELECT 
				*
			FROM 
				access_tokens
			WHERE 
				userId = "' . $userId . '"
			LIMIT ' . $maxAuthUserWithDevices . '
		');

		if (!empty($result)) {
			$this->isLoaded = true;
		}

		return $result;
	}
}