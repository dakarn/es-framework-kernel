<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 18:13
 */

namespace Middleware;

class StorageMiddleware
{
	private static $middlewareList = [];

	private static $currPos = 0;

	public static function add(array $middlewares)
	{
		self::$middlewareList = [];
		self::$currPos        = 0;

		foreach ($middlewares as $middleware) {
			if ($middleware['autoStart'] === true) {
				self::$middlewareList[] = $middleware;
			}
		}
	}

	public static function addOne(array $middleware)
	{
		self::$middlewareList[] = $middleware;
	}

	public static function currPosition(): int
	{
		return self::$currPos;
	}

	public static function nextPosition(): void
	{
		self::$currPos++;
	}

	public static function count(): int
	{
		return count(self::$middlewareList);
	}

	public static function get(): array
	{
		return self::$middlewareList;
	}
}