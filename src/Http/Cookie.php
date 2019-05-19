<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:03
 */

namespace ES\Kernel\Http;

use ES\Kernel\System\Constants;
use ES\Kernel\Traits\SingletonTrait;

class Cookie implements CookieInterface
{
	use SingletonTrait;

	public const JWT = 'JWT';

	/**
	 * @param string $key
	 * @return string
	 */
	public function get(string $key): string
	{
		return $_COOKIE[$key] ?? '';
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return isset($_COOKIE[$key]) ? true : false;
	}

	/**
	 * @param array $keys
	 * @return array
	 */
	public function getSome(array $keys): array
	{
		$foundKeys = [];

		foreach ($keys as $key) {
			if (isset($_COOKIE[$key])) {
				$foundKeys[$key] = $_COOKIE[$key];
			}
		}

		return $foundKeys;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		return $_COOKIE;
	}

    /**
     * @param string $key
     */
	public function remove(string $key)
    {
        \setcookie($key);
    }

	/**
	 * @param string $key
	 * @param string $value
	 * @param string $path
	 * @param int $expire
	 * @param string $domain
	 * @return Cookie
	 */
	public function set(string $key, string $value, string $path = '/', int $expire = 0, string $domain = Constants::COMMON_URL): Cookie
	{
		\setcookie($key, $value, $expire, $path, $domain);
		return $this;
	}
}