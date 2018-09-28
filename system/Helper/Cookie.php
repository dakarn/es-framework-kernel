<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:03
 */

namespace Helper;

use Traits\SingletonTrait;

class Cookie
{
	use SingletonTrait;

	public function get(string $key): string
	{
		return $_COOKIE[$key] ?? '';
	}

	public function has(string $key): bool
	{
		return isset($_COOKIE[$key]) ? true : false;
	}

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

	public function getAll(): array
	{
		return $_COOKIE;
	}

	public function set(string $key, string $value, string $path = '', int $expire = 0, string $domain = ''): Cookie
	{
		setcookie($key, $value, $expire, $path, $domain);
		return $this;
	}
}