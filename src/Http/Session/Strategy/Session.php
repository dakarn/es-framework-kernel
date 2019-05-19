<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:29
 */

namespace ES\Kernel\Http\Session\Strategy;

/**
 * Class Session
 * @package Http\Session
 */
class Session
{
	/**
	 * @return SimpleSessionStrategy
	 */
	public function getSimpleStrategy(): SimpleSessionStrategy
	{
		return new SimpleSessionStrategy();
	}

	/**
	 * @return RedisStrategy
	 */
	public function getRedisStrategy(): RedisStrategy
	{
		return new RedisStrategy();
	}

	/**
	 * @param string $key
	 * @return string
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function get(string $key): string
	{
		return $this->getRedisStrategy()->get($key);
	}

	/**
	 * @param string $key
	 * @return array
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function getAsArray(string $key): array
	{
		return $this->getRedisStrategy()->getAsArray($key);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function has(string $key): bool
	{
		return $this->getRedisStrategy()->has($key);
	}

	/**
	 * @return int
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function count(): int
	{
		return $this->getRedisStrategy()->count();
	}

	/**
	 * @param array $keys
	 * @return array
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function getSome(array $keys): array
	{
		return $this->getRedisStrategy()->getSome($keys);
	}

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function clear(): void
	{
		$this->getRedisStrategy()->clear();
	}

	/**
	 * @return array
	 */
	public function all(): array
	{
		return $this->getRedisStrategy()->all();
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function delete(string $key): bool
	{
		return $this->getRedisStrategy()->delete($key);
	}

	/**
	 * @param string $key
	 * @param $value
	 * @return Session
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function set(string $key, $value): Session
	{
		$this->getRedisStrategy()->set($key, $value);
		return $this;
	}
}