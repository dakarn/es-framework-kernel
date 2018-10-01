<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:30
 */

namespace Http\Session;

use Helper\Redis;

class RedisStrategy implements SessionStrategy
{
	/**
	 * @param string $key
	 * @return bool|string
	 */
	public function get(string $key)
	{
		return Redis::get($key);
	}

	public function delete(string $key): bool
	{
		return Redis::delete($key);
	}

	public function has(string $key): bool
	{
		return Redis::delete($key);
	}

	public function set(string $key, $value): bool
	{
		return Redis::set($key, $value);
	}
}