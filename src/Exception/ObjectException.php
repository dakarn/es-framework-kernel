<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:24
 */

namespace ES\Kernel\Exception;

class ObjectException extends \Exception
{
	/**
	 * @param array $argumnets
	 * @return ObjectException
	 */
	public static function notFound(array $argumnets = []): self
	{
		return new self('This class or interface or trait "' . $argumnets[0] . '" not found!');
	}
}