<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 2:18
 */

namespace Exception;

class WidgetException extends \Exception
{
	/**
	 * @param array $arguments
	 * @return WidgetException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('This widget "' . $arguments[0]  . '" not found!');
	}
}