<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.10.2018
 * Time: 20:14
 */

namespace System\Auth;

use Helper\Util;
use System\Database\DB;

class TokenRepository
{
	/**
	 * @param JWTokenManager $JWTokenManager
	 * @return bool
	 * @throws \Exception
	 */
	public function addToken(JWTokenManager $JWTokenManager): bool
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

	public function loadByRefreshToken(string $refreshToken): TokenRepository
	{
		return $this;
	}

	public function loadByAccessToken(string $token): TokenRepository
	{
		return $this;
	}

	public function loadByUserId(int $userId): TokenRepository
	{
		return $this;
	}
}