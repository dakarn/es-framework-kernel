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
	 * @param LoggerInterface $logger
	 * @return Logger
	 */
	public static function setLogger(LoggerInterface $logger): Logger
	{
		if (!self::$logger instanceof LoggerInterface) {
			self::$logger = $logger;
		}

		return self::$logger;
	}
}