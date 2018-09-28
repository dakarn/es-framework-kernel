<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2018
 * Time: 12:39
 */

namespace Exception;

class ResponseException extends \Exception
{
	public static function invalidResponse(array $arguments = []): self
	{
		return new self('This response invalid type!');
	}

	public static function notSetupResponse(array $arguments = []): self
	{
		return new self('Unable execute middleware with index 0. Need minimum one middleware!');
	}

	public static function notImplementedResponse(array $arguments = []): self
	{
		return new self('This variable response do not implemented ResponseInterface!');
	}
}