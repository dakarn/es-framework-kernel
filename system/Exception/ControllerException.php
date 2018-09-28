<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:20
 */

namespace Exception;

class ControllerException extends \Exception
{
	public static function notFoundController(array $arguments = []): self
	{
		return new self('This controller "' . $arguments[0] . '" not found!');
	}

	public static function notFoundAction(array $arguments = []): self
	{
		return new self('This action "' . $arguments[0] . '" not found in this controller!');
	}

	public static function deniedMethod(array $arguments = []): self
	{
		return new self('This method "' . $arguments[0] . '" forbidden on the URL!');
	}

	public static function invalidArguments(array $arguments = []): self
	{
		return new self('');
	}

	public static function beforeNoReturnBool(array $arguments = []): self
	{
		return new self('');
	}
}