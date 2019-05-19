<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 23:06
 */

namespace ES\Kernel\System\Auth;

use ES\Kernel\Helper\Util;
use ES\Kernel\System\Database\DB;
use ES\Kernel\System\Validators\AbstractValidator;

class TokenStorage
{
	/**
	 * @param JWTokenManager $JWToken
	 * @param string $refreshToken
	 * @param TokenModel $tokenModel
	 * @return bool
	 * @throws \Exception
	 */
	public function updateRefreshToken(JWTokenManager $JWToken, string $refreshToken, TokenModel $tokenModel): bool
	{
		$result = DB::MySQLAdapter()->update('
			UPDATE 
				`access_tokens` 
			SET
				`refresh` = \'' . $refreshToken . '\',
				`access` = \'' . $JWToken->getPartToken(JWTokenManager::SIGN_TOKEN) . '\',
				`expire` = \'' . $JWToken->getProperties()->getExpAsDT() . '\',
				`created` = \'' . Util::toDbTime() . '\'
			WHERE 
				`refresh` = \'' . $tokenModel->getRefresh() . '\'
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
		return DB::MySQLAdapter()->delete('
			DELETE
			FROM 
				access_tokens
			WHERE
				access = \'' . $token  . '\'
		');
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
				userId = \'' . $userId  . '\'
		');

		return true;
	}

	/**
	 * @param string $refreshToken
	 * @param string $token
	 * @param JWTokenProperties $JWTokenProperties
	 * @return bool
	 * @throws \Exception
	 */
	public function addAccessToken(string $refreshToken, string $token, JWTokenProperties $JWTokenProperties): bool
	{
		DB::MySQLAdapter()->insert('
			INSERT INTO `access_tokens`
			(
				`access`, 
				`refresh`, 
				`userId`, 
				`created`,
				`expire`
			)
			VALUES (
				\'' . $token . '\',
			    \'' . $refreshToken . '\', 
			    \'' . $JWTokenProperties->getUserId() . '\',  
			    \'' . Util::toDbTime() . '\',
			    \'' . $JWTokenProperties->getExpAsDT() . '\')
		');

		return true;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return array
	 * @throws \Exception
	 */
	public function loadByRefreshToken(AbstractValidator $validator): array
	{
		 return DB::MySQLAdapter()->fetchRow('
			SELECT 
				*
			FROM 
				access_tokens
			WHERE 
				refresh = \'' . $validator->getValueField('refreshToken') . '\'
			LIMIT 1
		') ?? [];
	}

	/**
	 * @param int $userId
	 * @param int $maxAuthUserWithDevices
	 * @return array
	 * @throws \Exception
	 */
	public function loadByUserId(int $userId, int $maxAuthUserWithDevices): array
	{
		 return DB::MySQLAdapter()->fetch('
			SELECT 
				*
			FROM 
				access_tokens
			WHERE 
				userId = \'' . $userId . '\'
			LIMIT ' . $maxAuthUserWithDevices . '
		') ?? [];
	}
}