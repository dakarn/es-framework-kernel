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
	/**
	 * @param array $arguments
	 * @return MiddlewareException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('A middleware with this name was not found in system!');
	}

	/**
	 * @param array $arguments
	 * @return MiddlewareException
	 */
	public static function needMinOne(array $arguments = []): self
	{
		return new self('The WebApp must have at least one system middleware!');
	}
}