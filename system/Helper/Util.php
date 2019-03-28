<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 22:29
 */

namespace Helper;

use Configs\Config;
use System\Logger\Logger;
use System\Logger\LoggerAware;

class Util
{
	const DICTIONARY       = 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM';

	const DICTIONARY_DIGIT = '1234567890';

	/**
	 * @var array
	 */
	private static $formMessage = [];

	/**
	 * @return string
	 */
	public static function filterRegex(): string
	{
		return '';
	}

	/**
	 * @return int
	 */
	public static function now(): int
	{
		return \time();

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
	 * @param $value
	 * @return string
	 */
	public static function base64encode($value): string
	{
		return \strtr(\base64_encode($value), ['+' => '-', '/' => '_', '=' => '']);
	}

	/**
	 * @param $value
	 * @return string
	 */
	public static function base64decode($value): string
	{
		return \base64_decode(\strtr($value, ['-' => '+' , '_' => '/']));
	}

	/**
	 * @param string $key
	 * @return array
	 * @throws \Exception\FileException
	 */
	public static function getFormMessage(string $key): array
	{
		if (empty(self::$formMessage)) {
			self::$formMessage = Config::get('form-result/form-message');
		}

		return self::$formMessage[$key] ?? [];
	}
	/**
	 * @return string
	 */
	public static function toDbTime(): string
	{
		return \date('Y-m-d H:i:s', \time());
	}

	public static function escapeStringSQL(string $text): string
	{
		return \preg_replace('', '', $text);
	}

	/**
	 * @param int $length
	 * @return string
	 * @throws \Exception
	 */
	public static function generateRandom(int $length): string
	{
		$i        = 0;
		$response = '';
		$count    = \strlen(self::DICTIONARY) - 1;

		while ($i <= $length) {
			$response .= self::DICTIONARY[\random_int(0, $count)];
			++$i;
		}

		return $response;
	}

	/**
	 * @param string $level
	 * @param string $message
	 */
	public static function log(string $level, string  $message)
	{
		LoggerAware::setlogger(Logger::class)->log($level, $message);
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	public static function createRefreshToken(): string
	{
		return Util::base64encode(Util::generateCSRFToken());
	}
}