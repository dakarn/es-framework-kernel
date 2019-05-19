<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 2:24
 */

namespace ES\Kernel\System\Auth;

interface JWTokenManagerInterface
{
	/**
	 * @return string
	 */
	public function getToken(): string;

	/**
	 * @param string $refreshToken
	 * @return JWTokenManager
	 */
	public function setRefreshToken(string $refreshToken): JWTokenManager;

	/**
	 * @return string
	 */
	public function getRefreshToken(): string;

	/**
	 * @return JWTokenProperties
	 */
	public function getProperties(): JWTokenProperties;

	/**
	 * @param string $token
	 * @return JWTokenManager
	 */
	public function setToken(string $token): JWTokenManager;

	/**
	 * @param int $part
	 * @return string
	 */
	public function getPartToken(int $part): string;

	/**
	 * @param array $payload
	 * @return JWTokenManager
	 */
	public function setPayload(array $payload): JWTokenManager;

	/**
	 * @param array $header
	 */
	public function setHeader(array $header): void;

	/**
	 * @param string $token
	 * @param string $secretKey
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function verifyToken(string $token, string $secretKey = ''): bool;

	/**
	 * @return JWTokenManager
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function createToken(): JWTokenManager;

	/**
	 * @param string $token
	 * @return JWTokenProperties
	 */
	public function decode(string $token): JWTokenProperties;

	/**
	 * @return mixed
	 */
	public function __clone();

	/**
	 * @return JWTokenManager
	 */
	public static function create(): JWTokenManager;
}