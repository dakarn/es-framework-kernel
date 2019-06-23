<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2018
 * Time: 20:06
 */

namespace ES\Kernel\Auth;

use ES\Kernel\Http\Cookie;
use ES\Kernel\ObjectMapper\ClassToMappingInterface;

class JWTokenProperties implements ClassToMappingInterface
{
	/**
	 * @var array
	 */
	private $header = [
		'alg' => 'HS256',
		'typ' => Cookie::JWT,
	];

	/**
	 * @var string
	 */
	private $alg = 'HS256';

	/**
	 * @var string
	 */
	private $typ = Cookie::JWT;

	/**
	 * @var string
	 */
	private $iss = '';

	/**
	 * @var string
	 */
	private $sub = '';

	/**
	 * @var int
	 */
	private $exp = 0;

	/**
	 * @var int|mixed
	 */
	private $userId = 0;

	/**
	 * @var mixed|string
	 */
	private $email = '';

	/**
	 * @var mixed|string
	 */
	private $login = '';

	/**
	 * @var int|mixed
	 */
	private $role = 0;

	/**
	 * @var mixed|string
	 */
	private $created = '';

	/**
	 * @var int|mixed
	 */
	private $iat = 0;

	/**
	 * @var string
	 */
	private $userIp = '';

	/**
	 * @var string
	 */
	private $uniqueId = '';

	public function getProperties(): array
	{
		return [
			'role',
			'userId',
			'login',
			'email',
			'exp',
			'created',
			'iat',
			'iss',
			'sub',
			'userIp',
			'uniqueId',
		];
	}

	/**
	 * JWTokenProperties constructor.
	 * @param array $props
	 */
	public function __construct(array $props)
	{
		$this->header['alg'] = $props['alg'] ?? '';
		$this->header['typ'] = $props['typ'] ?? '';

		$this->role      = $props['role'];
		$this->userId    = $props['userId'];
		$this->login     = $props['login'];
		$this->email     = $props['email'];
		$this->exp       = $props['exp'];
		$this->created   = $props['created'];
		$this->iat       = $props['iat'];
		$this->iss       = $props['iss'] ?? '';
		$this->sub       = $props['sub'] ?? '';
		$this->userIp    = $props['ip'] ?? '';
		$this->uniqueId  = $props['uniqueId'] ?? '';
	}

	/**
	 * @return string
	 */
	public function getUserIp(): string
	{
		return $this->userIp;
	}

	/**
	 * @return array
	 */
	public function getHeader(): array
	{
		return $this->header;
	}

	/**
	 * @return string
	 */
	public function getUniqueId(): string
	{
		return $this->uniqueId;
	}

	/**
	 * @return string
	 */
	public function getAlg(): string
	{
		return $this->alg;
	}

	/**
	 * @return string
	 */
	public function getTyp(): string
	{
		return $this->typ;
	}

	/**
	 * @return string
	 */
	public function getIss(): string
	{
		return $this->iss;
	}

	/**
	 * @return string
	 */
	public function getSub(): string
	{
		return $this->sub;
	}

	/**
	 * @return int
	 */
	public function getExp(): int
	{
		return $this->exp;
	}

	public function getExpAsDT(): string
	{
		return \date('Y-m-d H:i:s', $this->exp);
	}
	
	/**
	 * @return int|mixed
	 */
	public function getIat(): int
	{
		return $this->iat;
	}

	/**
	 * @return int
	 */
	public function getRole(): int
	{
		return $this->role;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getCreated(): string
	{
		return $this->created;
	}

	/**
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->userId;
	}

	/**
	 * @return string
	 */
	public function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'role'    => $this->role,
			'created' => $this->created,
			'email'   => $this->email,
			'login'   => $this->login,
			'userId'  => $this->userId,
			'alg'     => $this->alg,
			'typ'     => $this->typ,
			'iss'     => $this->iss,
			'exp'     => $this->exp,
			'sub'     => $this->sub,
			'iat'     => $this->iat,
		];
	}
}