<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2018
 * Time: 15:21
 */

namespace ES\Kernel\Http\Session;

use ES\Kernel\Http\Session\Strategy\RedisStrategy;
use ES\Kernel\Http\Session\Strategy\Session;
use ES\Kernel\Http\Session\Strategy\SimpleSessionStrategy;

class SessionSimple
{
	/**
	 * @var SimpleSessionStrategy
	 */
	private static $strategy;

	/**
	 * @return SimpleSessionStrategy
	 */
	public static function create(): SimpleSessionStrategy
	{
		if (!self::$strategy instanceof RedisStrategy) {
			self::$strategy = (new Session())->getSimpleStrategy();
		}

		return self::$strategy;
	}
}