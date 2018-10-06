<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2018
 * Time: 15:21
 */

namespace Http\Session;

use Http\Session\Strategy\RedisStrategy;
use Http\Session\Strategy\Session;

class SessionRedis
{
	/**
	 * @var RedisStrategy
	 */
	private static $strategy;

	/**
	 * @return RedisStrategy
	 */
	public static function create(): RedisStrategy
	{
		if (!self::$strategy instanceof RedisStrategy) {
			self::$strategy = (new Session())->getRedisStrategy();
		}

		return self::$strategy;
	}
}