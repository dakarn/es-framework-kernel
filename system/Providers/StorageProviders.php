<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 18:13
 */

namespace Providers;

class StorageProviders
{
	private static $list = [];

	private static $currPos = 0;

	public static function add(array $providers)
	{
		foreach ($providers as $provider) {
			if ($provider['autoStart'] === true) {
				self::$list[] = $provider;
			}
		}
	}

	public static function addOne(array $provider)
	{
		self::$list[] = $provider;
	}

	public static function currPosition(): int
	{
		return self::$currPos;
	}

	public static function nextPosition()
	{
		self::$currPos++;
	}

	public static function count(): int
	{
		return count(self::$list);
	}

	public static function get(): array
	{
		return self::$list;
	}
}