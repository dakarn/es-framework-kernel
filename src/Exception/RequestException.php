<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:39
 */

namespace ES\Kernel\Exception;

class RequestException extends \Exception
{
	/**
	 * @param array $argumnets
	 * @return RequestException
	 */
	public static function failed(array $argumnets = []): self
	{
		return new self('');
	}
}