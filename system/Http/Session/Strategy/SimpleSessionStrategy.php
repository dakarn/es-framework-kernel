<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:31
 */

namespace Http\Session\Strategy;

/**
 * Class SimpleSessionStrategy
 * @package Http\Session
 */
class SimpleSessionStrategy implements SessionStrategy
{
	/**
	 * @param string $key
	 * @return array
	 */
	public function getAsArray($key): array
	{
		return $_SESSION[$key] ?? [];
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
	 * @param string $key
	 * @return mixed|string
	 */
	public function get($key)
	{
		return $_SESSION[$key] ?? '';
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has($key): bool
	{
		return isset($_SESSION[$key]) ? true : false;
	}

	/**
	 * @return void
	 */
	public function clear(): void
	{
		\session_unset();
	}

	/**
	 * @return array
	 */
	public function all(): array
	{
		return $_SESSION;
	}

	/**
	 * @return int
	 */
	public function count(): int
	{
		return \count($_SESSION);
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function delete($key): bool
	{
		unset($_SESSION[$key]);

		return true;
	}

	/**
	 * @param string $key
	 * @param $value
	 * @return SimpleSessionStrategy
	 */
	public function set($key, $value): SimpleSessionStrategy
	{
		$_SESSION[$key] = $value;
		return $this;
	}
}