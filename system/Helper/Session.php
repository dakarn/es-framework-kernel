<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:03
 */

namespace Helper;

use Traits\SingletonTrait;

class Session
{
	use SingletonTrait;

	public function isStart(): bool
	{
		return isset($_SESSION);
	}

	public function start(): bool
	{
		return session_start();
	}

	public function get(string $key): string
	{
		return $_SESSION[$key] ?? '';
	}

	public function getAsArray(string $key): array
	{
		return $_SESSION[$key] ?? [];
	}

	public function has(string $key): bool
	{
		return isset($_SESSION[$key]) ? true : false;
	}

	public function getSome(array $keys): array
	{
		$foundKeys = [];

		foreach ($keys as $key) {
			if (isset($_SESSION[$key])) {
				$foundKeys[$key] = $_SESSION[$key];
			}
		}

		return $foundKeys;
	}

	public function getAll(): array
	{
		return $_SESSION;
	}

	public function delete(string $key)
	{
		unset($_SESSION[$key]);
	}

	public function set(string $key, $value): Session
	{
		$_SESSION[$key] = $value;
		return $this;
	}
}