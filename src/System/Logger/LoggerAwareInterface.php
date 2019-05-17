<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 15:21
 */

namespace System\Logger;

interface LoggerAwareInterface
{
	/**
	 * @param string $loggerClass
	 * @return mixed
	 */
	public static function setLogger(string $loggerClass);
}