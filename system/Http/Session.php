<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:03
 */

namespace Http;

use Traits\SingletonTrait;

class Session
{
	use SingletonTrait;

	/**
	 * @return bool
	 */
	public function isStart(): bool
	{
		return isset($_SESSION);
	}

	/**
	 * @return bool
	 */
	public function start(): bool
	{
		return session_start();
	}

	/**
	 * @param string $key
	 * @return string
	 */
	public function get(string $key): string
	{
		return $_SESSION[$key] ?? '';
	}

	/**
	 * @param string $key
	 * @return array
	 */
	public function getAsArray(string $key): array
	{
		return $_SESSION[$key] ?? [];
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return isset($_SESSION[$key]) ? true : false;
	}

    /**
     * @return int
     */
	public function count(): int
    {
        return count($_SESSION);
    }

	/**
	 * @param array $keys
	 * @return array
	 */
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

    /**
     * @return void
     */
	public function clear(): void
    {
        session_unset();
    }

	/**
	 * @return array
	 */
	public function all(): array
	{
		return $_SESSION;
	}

	/**
	 * @param string $key
	 */
	public function delete(string $key)
	{
		unset($_SESSION[$key]);
	}

	/**
	 * @param string $key
	 * @param $value
	 * @return Session
	 */
	public function set(string $key, $value): Session
	{
		$_SESSION[$key] = $value;
		return $this;
	}
}