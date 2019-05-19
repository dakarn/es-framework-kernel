<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:26
 */

namespace ES\Kernel\Exception;

class FileException extends \Exception
{
	/**
	 * @param array $arguments
	 * @return FileException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('This file "' . $arguments[0] . '" not found!');
	}
}