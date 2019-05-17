<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 23:17
 */

namespace Helper;

use Configs\Config;
use System\Logger\LogLevel;
use Traits\SingletonTrait;
use Http\Cookie;

class CSRFTokenManager
{
	use SingletonTrait;

    /**
     * @var string
     */
	const TOKEN_NAME = 'CSRFToken';

	/**
	 * @var bool
	 */
	private $isValid = false;

    /**
     * @var CSRFToken
     */
	private $token;

	/**
	 * @var bool
	 */
	private $isUseToken = false;

	/**
	 * @throws \Exception\FileException
	 */
	public function start(): void
    {
        if (!$this->token instanceof CSRFToken) {
            $this->token = new CSRFToken();
        }

	    $this->isUseToken = Config::get('common', 'useCSRFToken');

    }

	/**
	 * @param string $tokenFromCookie
	 * @param string $tokenFromPost
	 * @return CSRFTokenManager
	 */
	public function setValidationData(string $tokenFromCookie, string $tokenFromPost): CSRFTokenManager
	{
		if (!$this->isUseToken) {
			$this->isValid = true;
			return $this;
		}

		if (empty($tokenFromPost) || empty($tokenFromCookie)) {
			$this->isValid = false;
			return $this;
		}

		$this->isValid = $tokenFromCookie === $tokenFromPost;
		
		return $this;
	}

	/**
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function makeToken(): void
	{
		if (!$this->isUseToken) {
			return;
		}

		$this->start();

		$this->token->setToken(Util::generateCSRFToken());
		Cookie::create()->set(self::TOKEN_NAME, $this->token->getToken(), '/', 0, '.es-framework.dev.ru');
	}

	/**
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function refreshToken(): void
    {
	    $this->start();

        $this->token->setToken(Util::generateCSRFToken());
        Cookie::create()->set(self::TOKEN_NAME, $this->token->getToken(), '/', 0, '.es-framework.dev.ru');
    }

    /**
     * @return void
     */

	public function removeToken(): void
    {
        Cookie::create()->remove(self::TOKEN_NAME);
    }

	/**
	 * @return string
	 */
	public function returnForForm(): string
	{
		if (!$this->isUseToken) {
			return '';
		}

		return $this->token->getToken();
	}

	/**
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token->getToken();
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool
	{
		if (!$this->isValid) {
			Util::log(LogLevel::NOTICE, 'A CSRFSecure found an incorrect csrf-token!');
		}

		return $this->isValid;
	}
}