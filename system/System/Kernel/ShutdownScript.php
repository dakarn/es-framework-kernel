<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:11
 */

namespace System\Kernel;

use System\Logger\LoggerStorage;

class ShutdownScript
{
	public static function run()
	{
		self::releaseLog();
	}

	private static function releaseLog()
	{
		LoggerStorage::create()->releaseLog();
	}
}