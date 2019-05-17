<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:54
 */

namespace Helper;

use Traits\SingletonTrait;

class RedisManager
{
	use SingletonTrait;

	public function setTtl(int $ttl): RedisManager
	{
		return $this;
	}

	public function setKey(string $key): RedisManager
	{
		return $this;
	}

	public function setFunction(\Closure $closure): RedisManager
	{
		return $this;
	}

	public function disableCache(): RedisManager
	{
		return $this;
	}

	public function enableCache(): RedisManager
	{
		return $this;
	}
}