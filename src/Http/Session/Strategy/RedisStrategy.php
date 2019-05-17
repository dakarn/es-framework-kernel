<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:30
 */

namespace Http\Session\Strategy;

use Helper\Redis;

/**
 * Class RedisStrategy
 * @package Http\Session
 */
class RedisStrategy implements SessionStrategy
{
	/**
	 * @param string $key
	 * @return array
	 * @throws \Exception\FileException
	 */
	public function getAsArray($key): array
	{
		$value = Redis::get($key);

		if (!$value) {
			return [];
		}

		return \json_decode($value, true, JSON_UNESCAPED_UNICODE);
	}

	/**
	 * @param array $keys
	 * @return array
	 * @throws \Exception\FileException
	 */
	public function getSome(array $keys): array
	{
		$ret = [];

		foreach ($keys as $key) {
			$ret[$key] = Redis::get($key);
		}

		return $ret;
	}

	/**
	 * @return array
	 */
	public function all(): array
	{
		return [];
	}

	/**
	 * @return int
	 * @throws \Exception\FileException
	 */
	public function count(): int
	{
		return Redis::getAmountKeys();
	}

	/**
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function clear(): bool
	{
		return Redis::flushAll();
	}

	/**
	 * @param string $key
	 * @return bool|mixed|string
	 * @throws \Exception\FileException
	 */
	public function get($key)
	{
		return Redis::get($key);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function delete($key): bool
	{
		return Redis::delete($key);
	}

	/**
	 * @param array $keys
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function deleteKeys(array $keys): bool
	{
		if (empty($keys)) {
			return false;
		}

		return Redis::deleteKeys($keys);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function has($key): bool
	{
		return Redis::delete($key);
	}

	/**
	 * @param string $key
	 * @param $value
	 * @param int $ttl
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function set($key, $value, int $ttl = 0): bool
	{
		return Redis::set($key, $value);
	}
}