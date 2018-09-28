<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 23:17
 */

namespace Helper;

use Traits\SingletonTrait;

class CSRFToken
{
	use SingletonTrait;

	private $isValid = false;

	private $token;

	public function setValidationData(string $tokenFromCookie, string $tokenFromPost): CSRFToken
	{
		$this->isValid = $tokenFromCookie === $tokenFromPost;
		return $this;
	}

	public function makeToken()
	{
		$this->token = Util::generateCSRFToken();

		Request::create()
			->getCookie()
			->set('CSRFToken', $this->token);
	}

	public function getToken(): string
	{
		return $this->token;
	}

	public function isValid(): bool
	{
		return $this->isValid;
	}
}