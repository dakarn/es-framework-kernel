<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:48
 */

namespace ES\Kernel\Helper;

use ES\Kernel\Configs\Config;
use ES\Kernel\System\Logger\LogLevel;

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
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function get($key)
	{
		self::connect();

		return self::$redis->get($key);
	}

	/**
	 * @return int
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function getAmountKeys(): int
	{
		self::connect();

		return self::$redis->dbSize();
	}

	/**
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function flushAll(): bool
	{
		self::connect();

		return self::$redis->flushAll();
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function has($key): bool
	{
		self::connect();

		return self::$redis->exists($key);
	}

	/**
	 * @param $key
	 * @return int
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function incr($key): int
	{
		self::connect();

		return self::$redis->incr($key);
	}

	/**
	 * @param $key
	 * @return int
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function decr($key): int
	{
		self::connect();

		return self::$redis->decr($key);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function delete($key): bool
	{
		self::connect();

		return self::$redis->delete($key);
	}

	/**
	 * @param array $keys
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function deleteKeys(array $keys): bool
	{
		self::connect();

		return \call_user_func_array([self::$redis, 'delete'], $keys);
	}

	/**
	 * @param $key
	 * @param $value
	 * @param int $ttl
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function set($key, $value, int $ttl = 0): bool
	{
		self::connect();

		if (\is_array($value)) {
			$value = \json_encode($value, JSON_UNESCAPED_SLASHES || JSON_UNESCAPED_UNICODE);
		}

		if ($ttl === 0) {
			$result = self::$redis->set($key, $value);
		} else {
			$result = self::$redis->set($key, $value, $ttl);
		}

		return $result;
	}

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function close()
	{
		self::connect();

		self::$redis = null;
		self::$redis->close();
	}

	/**
	 * @return array
	 * @throws \ES\Kernel\Exception\FileException
	 */
	private static function getConfig(): array
	{
		return Config::get('common', 'redis')[0];
	}

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 */
	private static function connect()
	{
		if (!self::$redis instanceof \Redis) {

			$config = self::getConfig();

			try {

				self::$redis = new \Redis();
				self::$redis->connect($config['host'], $config['port']);

				if (!empty($config['password'])) {
					self::$redis->auth($config['password']);
				}

				self::$tryConnect = 0;
			} catch (\Throwable $e) {

				if (self::MAX_TRY_CONNECT <= self::$tryConnect) {
					Util::log(LogLevel::CRITICAL, 'Unable to connect Redis');
					return self::$redis;
				}

				self::$redis = null;
				self::$tryConnect++;
				self::connect();
			}
		}

		return self::$redis;
	}
}