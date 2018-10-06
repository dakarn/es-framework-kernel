<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:17
 */

namespace Helper;

use Configs\Config;
use Traits\SingletonTrait;

class JWTokenManager implements JWTokenManagerInterface
{
	use SingletonTrait;
	
	public const HEADER     = 0;
	public const PAYLOAD    = 1;
	public const SIGN_TOKEN = 2;

	private $header = [
		'alg' => 'HS256',
		'typ' => 'JWT',
	];

	private $payload = [
		'iss'   => 'es-framework.dev.ru',
		'sub'   => 'site',
	];

	/**
	 * @var JWTokenProperties
	 */
	private$JWTokenProperties;

	/**
	 * @var bool
	 */
	private $isCreated = false;

	/**
	 * @var string
	 */
	private $token = '';

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
		$this->payload = $this->payload + $payload;
		
		return $this;
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
	 * @throws \Exception\FileException
	 */
	public function verifyToken(string $token, string $secretKey = ''): bool
	{
		$secretKey = !empty($secretKey) ? $secretKey: Config::get('salt', 'jwToken');

		list($header, $payload, $signToken) = \explode('.', $token);

		$checkToken = \hash_hmac('sha256', $header . '.' . $payload, $secretKey, true);
		$checkToken = Util::base64encode($checkToken);

		return $signToken === $checkToken;
	}

	/**
	 * @return JWTokenManager
	 * @throws \Exception\FileException
	 */
	public function createToken(): JWTokenManager
	{
		$secretKey = Config::get('salt', 'jwToken');

		$headerBase64  = Util::base64encode(\json_encode($this->header));
		$payloadBase64 = Util::base64encode(\json_encode($this->payload));

		$unsignedToken = $headerBase64 . '.' . $payloadBase64;
		$signedToken   = Util::base64encode(\hash_hmac('sha256', $unsignedToken, $secretKey, true));

		$this->token = $unsignedToken . '.' . $signedToken;
		$this->isCreated = true;

		return $this;
	}

	/**
	 * @param string $token
	 * @return JWTokenProperties
	 */
	public function decode(string $token): JWTokenProperties
	{
		list($headerStr, $payloadStr) = \explode('.', $token);

		$header  = \json_decode(Util::base64decode($headerStr), true);
		$payload = \json_decode(Util::base64decode($payloadStr), true);

		$this->JWTokenProperties = new JWTokenProperties($header + $payload);
		return $this->JWTokenProperties;
	}
}