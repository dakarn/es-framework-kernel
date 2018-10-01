<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:48
 */

namespace Helper;

use Configs\Config;
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

	/**
	 * @param string $key
	 * @return bool|string
	 * @throws \Exception\FileException
	 */
	public static function get(string $key)
	{
		self::connect();

		return self::$redis->get($key);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public static function has(string $key): bool
	{
		self::connect();

		return self::$redis->exists($key);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public static function delete(string $key): bool
	{
		self::connect();

		return self::$redis->delete($key);
	}

	/**
	 * @param $key
	 * @param $value
	 * @param int $ttl
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public static function set($key, $value, int $ttl = 0): bool
	{
		self::connect();

		return self::$redis->set($key, $value, $ttl);
	}

	/**
	 * @throws \Exception\FileException
	 */
	public static function close()
	{
		self::connect();

		self::$redis->close();
	}

	/**
	 * @return array
	 * @throws \Exception\FileException
	 */
	private static function getConfig(): array
	{
		return Config::get('common', 'redis')[0];
	}

	/**
	 * @throws \Exception\FileException
	 */
	private static function connect()
	{
		if (!self::$redis instanceof \Redis) {

			try {
				$config = self::getConfig();

				self::$redis = new \Redis();
				self::$redis->connect($config['host'], $config['port']);

				self::$tryConnect = 0;
			} catch (\Throwable $e) {

				if (self::MAX_TRY_CONNECT <= self::$tryConnect) {
					Util::log(LogLevel::CRITICAL, 'Unable to connect Redis');
					return self::$redis;
				}

				self::$tryConnect++;
				self::connect();
			}
		}

		return self::$redis;
	}
}