<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:26
 */

namespace Exception;

class FileException extends \Exception
{
	public static function notFound(array $argumnets = []): self
	{
		return new self('This file "' . $argumnets[0] . '" not found!');
	}
}