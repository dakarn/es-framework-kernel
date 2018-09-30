<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:48
 */

namespace Helper;

use System\Logger\LogLevel;

class Redis
{
	private const MAX_TRY_CONNECT = 5;

	/**
	 * @var \Redis
	 */
	private static $redis;

	/**
	 * @var int
	 */
	private static $tryConnect = 0;

	private static function connect()
	{
		if (!self::$redis instanceof \Redis) {

			try {
				self::$redis = new \Redis('127.0.0.1', 6379);
				self::$tryConnect = 0;

			} catch (\Throwable $e) {

				if (self::MAX_TRY_CONNECT <= self::$tryConnect) {
					Util::log(LogLevel::CRITICAL, 'Unable to connect Redis');
					return;
				}

				self::$tryConnect++;
				self::connect();
			}
		}
	}

	public static function get(string $key)
	{
		self::connect();

		return self::$redis->get($key);
	}

	public static function delete(string $key): bool
	{
		self::connect();

		return self::$redis->delete($key);
	}

	public static function set(string $key, $value, int $ttl): bool
	{
		self::connect();

		return self::$redis->set($key, $value, $ttl);
	}
}