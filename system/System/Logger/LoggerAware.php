<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 16:48
 */

namespace System\Logger;

class LoggerAware implements LoggerAwareInterface
{
	/**
     * @var  Logger
	 */
	private static $logger;

	/**
	 * @param string $loggerClass
	 * @return Logger
	 */
	public static function setLogger(string $loggerClass): LoggerInterface
	{
		if (!self::$logger instanceof LoggerInterface) {
			self::$logger = new $loggerClass();
		}

		return self::$logger;
	}
}