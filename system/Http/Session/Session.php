<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:29
 */

namespace Http\Session;

use Traits\SingletonTrait;

class Session
{
	use SingletonTrait;

	/**
	 * @var RedisStrategy
	 */
	private $strategy;

	/**
	 * @return SessionStrategy
	 */
	private function getStrategy(): SessionStrategy
	{
		if (!$this->strategy instanceof SessionStrategy) {
			$this->strategy = new RedisStrategy();
		}

		return $this->strategy;
	}

	/**
	 * @param string $key
	 * @return string
	 */
	public function get(string $key): string
	{
		return $this->getStrategy()->get($key);
	}

	/**
	 * @param string $key
	 * @return array
	 */
	public function getAsArray(string $key): array
	{
		return [];
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return $this->getStrategy()->has($key);
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
	 * @return bool
	 */
	public function delete(string $key): bool
	{
		return $this->getStrategy()->delete($key);
	}

	/**
	 * @param string $key
	 * @param $value
	 * @return Session
	 */
	public function set(string $key, $value): Session
	{
		$this->getStrategy()->set($key, $value);
		return $this;
	}
}