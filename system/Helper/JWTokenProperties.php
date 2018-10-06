<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2018
 * Time: 20:06
 */

namespace Helper;

class JWTokenProperties
{
	private $header = [
		'alg' => 'HS256',
		'typ' => 'JWT',
	];

	private $alg = 'HS256';

	private $typ = 'JWT';

	private $iss = 'es-framework.dev.ru';

	private $sub = 'site';

	private $exp = 0;

	private $userId = 0;

	private $email = '';

	private $login = '';

	private $role = 0;

	/**
	 * JWTokenProperties constructor.
	 * @param array $props
	 */
	public function __construct(array $props)
	{
		$this->role   = $props['role'];
		$this->userId = $props['userId'];
		$this->login  = $props['login'];
		$this->email  = $props['email'];
	}

	public function getRole(): int
	{
		return $this->role;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function getLogin(): string
	{
		return $this->login;
	}

	public function toArray(): array
	{
		return [
			'role'   => $this->role,
			'email'  => $this->email,
			'login'  => $this->login,
			'userId' => $this->userId,
			'alg'    => $this->alg,
			'typ'    => $this->typ,
			'iss'    => $this->iss,
			'exp'    => $this->exp,
			'sub'    => $this->sub,
		];
	}
}