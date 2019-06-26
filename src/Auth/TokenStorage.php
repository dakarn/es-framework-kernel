<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 23:06
 */

namespace ES\Kernel\Auth;

use ES\Kernel\Helper\StorageHelper\EsFrameworkMySQLStorage;
use ES\Kernel\Helper\Util;
use ES\Kernel\ObjectMapper\ClassToMappingInterface;
use ES\Kernel\Validators\AbstractValidator;

class TokenStorage extends EsFrameworkMySQLStorage
{
    /**
     * @return string
     */
    protected function getObjectName(): string
    {
        return ClientApp::class;
    }

	/**
	 * @param JWTokenManager $JWToken
	 * @param string $refreshToken
	 * @param TokenModel $tokenModel
	 * @return bool
	 * @throws \Exception
	 */
	public function updateRefreshToken(JWTokenManager $JWToken, string $refreshToken, TokenModel $tokenModel): bool
	{
		$result = $this->getConnection()->update('
			UPDATE 
				`access_tokens` 
			SET
				`refresh` = \'' . $refreshToken . '\',
				`access`  = \'' . $JWToken->getPartToken(JWTokenManager::SIGN_TOKEN) . '\',
				`expire`  = \'' . $JWToken->getProperties()->getExpAsDT() . '\',
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
		return $this->getConnection()->delete('
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
        $this->getConnection()->delete('
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
        $this->getConnection()->insert('
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
	public function loadByRefreshToken(AbstractValidator $validator): ClassToMappingInterface
	{
		 return $this->fetchRowToObject('
			SELECT 
				*
			FROM 
				access_tokens
			WHERE 
				refresh = \'' . $validator->getValueField('refreshToken') . '\'
			LIMIT 1
		');
	}

	/**
	 * @param int $userId
	 * @param int $maxAuthUserWithDevices
	 * @return array
	 * @throws \Exception
	 */
	public function loadByUserId(int $userId, int $maxAuthUserWithDevices): ClassToMappingInterface
	{
		 return $this->fetchRowToObject('
			SELECT 
				*
			FROM 
				access_tokens
			WHERE 
				userId = \'' . $userId . '\'
			LIMIT ' . $maxAuthUserWithDevices . '
		');
	}
}