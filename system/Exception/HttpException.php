<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:39
 */

namespace Exception;

class HttpException extends \Exception
{
	/**
	 * @param array $arguments
	 * @return HttpException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('');
	}

	/**
	 * @param array $arguments
	 * @return HttpException
	 */
	public static function internalError(array $arguments = []): self
	{
		return new self('');
	}

	/**
	 * @param array $arguments
	 * @return HttpException
	 */
	public static function badRequest(array $arguments = []): self
	{
		return new self('');
	}
}