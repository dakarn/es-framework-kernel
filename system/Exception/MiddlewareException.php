<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 19:32
 */

namespace Exception;

class MiddlewareException extends \Exception
{
	public static function notFound(array $arguments = []): self
	{
		return new self('');
	}

	public static function needMinOne(array $arguments = []): self
	{
		return new self('');
	}

	public static function failedResult(array $arguments = []): self
	{
		return new self('Current middleware returned a failed result!');
	}
}