<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:40
 */

namespace Exception;

class RoutingException extends \Exception
{
	/**
	 * @param array $arguments
	 * @return RoutingException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('A route with this address is not installed on the system!');
	}
}