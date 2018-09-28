<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 22:29
 */

namespace Helper;

use Exception\KernelException;
class Util
{
	const DICTIONARY       = 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM';

	const DICTIONARY_DIGIT = '1234567890';

	public static function filterRegex(): string
	{
		return '';
	}

	public static function generateCSRFToken(int $length = 30): string
	{
		return self::generateRandom($length);
	}

	public static function generateCookieToken(int $length = 20): string
	{
		return self::generateRandom($length);
	}

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

	public static function selectLoaderClass(): void
	{
		switch (true) {
			case PSR_4:
				include_once PATH_SYSTEM . '/../vendor/autoload.php';
				break;
			case CUSTOM_LOADER:
				include_once PATH_SYSTEM . 'autoload.php';
				break;
		}
	}
}