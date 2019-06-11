<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:17
 */

namespace ES\Kernel\Auth;

use ES\Kernel\Configs\Config;
use ES\Kernel\Helper\Util;
use ES\Kernel\Http\Cookie;
use ES\Kernel\Traits\SingletonTrait;

class JWTokenManager implements JWTokenManagerInterface
{
	use SingletonTrait;
	
	public const HEADER     = 0;
	public const PAYLOAD    = 1;
	public const SIGN_TOKEN = 2;

	private $header = [
		'alg' => 'HS256',
		'typ' => Cookie::JWT,
	];

	/**
	 * @var array
	 */
	private $payload = [];

	/**
	 * @var JWTokenProperties
	 */
	private $JWTokenProperties;

	/**
	 * @var bool
	 */
	private $isCreated = false;

	/**
	 * @var string
	 */
	private $token = '';

	/**
	 * @var string 
	 */
	private $refreshToken = '';

	/**
	 * @param string $refreshToken
	 * @return JWTokenManager
	 */
	public function setRefreshToken(string $refreshToken): JWTokenManager
	{
		$this->refreshToken = $refreshToken;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRefreshToken(): string
	{
		return $this->refreshToken;
	}

	/**
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}
	
	/**
	 * @return JWTokenProperties
	 */
	public function getProperties(): JWTokenProperties
	{
		return $this->JWTokenProperties;
	}

	/**
	 * @param string $token
	 * @return JWTokenManager
	 */
	public function setToken(string $token): JWTokenManager
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * @param int $part
	 * @return string
	 */
	public function getPartToken(int $part): string
	{
		$exp = \explode('.', $this->token);

		return $exp[$part] ?? '';
	}

	/**
	 * @param array $payload
	 * @return JWTokenManager
	 */
	public function setPayload(array $payload): JWTokenManager
	{
		$this->payload = $payload;
		
		return $this;
	}

	/**
	 * @return array
	 */
	public function getPayload(): array
	{
		return $this->payload;
	}

	/**
	 * @param array $header
	 */
	public function setHeader(array $header): void
	{
		$this->header = $header;
	}

	/**
	 * @param string $token
	 * @param string $secretKey
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function verifyToken(string $token = '', string $secretKey = ''): bool
	{
		if (empty($token)) {
			$token = $this->token;
		}

		if (empty($secretKey)) {
			$secretKey = Config::get('salt', 'jwToken');
		}

		$partToken = \explode('.', $token);

		if (\count($partToken) != 3) {
			return false;
		}

		list($header, $payload, $signToken) = $partToken;

		$checkToken = \hash_hmac('sha256', $header . '.' . $payload, $secretKey, true);
		$checkToken = Util::base64encode($checkToken);

		if ($signToken !== $checkToken) {
			return false;
		}

		if ($this->decode()->getExp() < \time()) {
			return false;
		}

		return true;
	}

	/**
	 * @return JWTokenManager
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function createToken(): JWTokenManager
	{
		$secretKey = Config::get('salt', 'jwToken');

		$headerBase64  = Util::base64encode(\json_encode($this->header));
		$payloadBase64 = Util::base64encode(\json_encode($this->payload));

		$unsignedToken = $headerBase64 . '.' . $payloadBase64;
		$signedToken   = Util::base64encode(\hash_hmac('sha256', $unsignedToken, $secretKey, true));

		$this->token             = $unsignedToken . '.' . $signedToken;
		$this->JWTokenProperties = new JWTokenProperties($this->header + $this->payload);
		$this->isCreated         = true;

		return $this;
	}

	/**
	 * @param string $token
	 * @return JWTokenProperties
	 */
	public function decode(string $token = ''): JWTokenProperties
	{
		if ($this->JWTokenProperties instanceof JWTokenProperties) {
			return $this->JWTokenProperties;
		}

		if (empty($this->token)) {
			$this->token = $token;
		}

		list($headerStr, $payloadStr) = \explode('.', $this->token);

		$header  = \json_decode(Util::base64decode($headerStr), true);
		$payload = \json_decode(Util::base64decode($payloadStr), true);

		$this->JWTokenProperties = new JWTokenProperties($header + $payload);

		return $this->JWTokenProperties;
	}
}