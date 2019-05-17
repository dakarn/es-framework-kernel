<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 17:51
 */

namespace Exception;

class ServiceException extends \Exception
{
	/**
	 * @param array $arguments
	 * @return ServiceException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('This service "' . $arguments[0] . '" not found');
	}
}