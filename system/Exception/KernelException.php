<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:38
 */

namespace Exception;

class KernelException extends \Exception
{
	public static function notFoundInAppMemento(array $arguments = []): self
	{
		return new self('This object "' . $arguments[0] . '" not found in the AppMemento!');
	}

	public static function unknownEnvironment(array $arguments = []): self
	{
		return new self('This environment not support this application. Only CLI or WEB!');
	}
}