<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 22:29
 */

namespace Helper;

use System\Logger\Logger;
use System\Logger\LoggerAware;

class Util
{
	const DICTIONARY       = 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM';

	const DICTIONARY_DIGIT = '1234567890';

	/**
	 * @return string
	 */
	public static function filterRegex(): string
	{
		return '';
	}

	/**
	 * @param int $length
	 * @return string
	 * @throws \Exception
	 */
	public static function generateCSRFToken(int $length = 30): string
	{
		return self::generateRandom($length);
	}

	/**
	 * @param int $length
	 * @return string
	 * @throws \Exception
	 */
	public static function generateCookieToken(int $length = 20): string
	{
		return self::generateRandom($length);
	}

	/**
	 * @param int $length
	 * @return string
	 * @throws \Exception
	 */
	private static function generateRandom(int $length): string
	{
		$i        = 0;
		$response = '';
		$count    = strlen(self::DICTIONARY) - 1;

		while ($i <= $length) {
			$response .= self::DICTIONARY[random_int(0, $count)];
			++$i;
		}

		return $response;
	}

	/**
	 * @return void
	 */
	public static function selectLoaderClass(): void
	{
		switch (true) {
			case PSR_4:
				include_once PATH_LOADER;
				break;
			default:
				include_once PATH_SYSTEM . 'autoload.php';
				break;
		}
	}

	public static function log(string $level, string  $message)
	{
		LoggerAware::setlogger(new Logger())->log($level, $message);
	}
}